require('dotenv').config();
const express = require('express');
const cors = require('cors');
const swaggerUi = require('swagger-ui-express');
const swaggerSpec = require('./src/config/swagger');
const { sequelize } = require('./src/models');
const routes = require('./src/routes');

const app = express();
const PORT = process.env.PORT || 3000;

// ─── Middlewares globaux ──────────────────────────────────────

// CORS : autoriser le frontend Vue.js (port 5173)
app.use(
  cors({
    origin: ['http://localhost:5173', 'http://127.0.0.1:5173'],
    methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
    allowedHeaders: ['Content-Type', 'Authorization'],
    credentials: true,
  })
);

// Parser JSON
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// ─── Documentation Swagger ────────────────────────────────────
app.use('/api-docs', swaggerUi.serve, swaggerUi.setup(swaggerSpec, {
  customSiteTitle: 'Gestion Med API Docs',
  swaggerOptions: {
    persistAuthorization: true, // garde le token entre les requêtes dans l'UI
  },
}));

// ─── Routes API ───────────────────────────────────────────────
app.use('/api/v1', routes);

// ─── Route racine ─────────────────────────────────────────────
app.get('/', (req, res) => {
  res.json({
    message: 'Gestion Med — Backend Express.js',
    version: '1.0.0',
    docs: `http://localhost:${PORT}/api-docs`,
    api: `http://localhost:${PORT}/api/v1`,
  });
});

// ─── Gestion des routes inexistantes ─────────────────────────
app.use((req, res) => {
  res.status(404).json({ message: `Route introuvable : ${req.method} ${req.originalUrl}` });
});

// ─── Gestion globale des erreurs ─────────────────────────────
app.use((err, req, res, next) => {
  console.error('Erreur non gérée:', err);
  res.status(500).json({ message: 'Erreur serveur interne.' });
});

// ─── Démarrage ────────────────────────────────────────────────
const start = async () => {
  try {
    // Tester la connexion à la base de données
    await sequelize.authenticate();
    console.log('✓ Connexion MySQL établie (base : ' + process.env.DB_NAME + ')');

    // NE PAS synchroniser : les tables existent déjà (créées par Laravel)
    // sequelize.sync() est volontairement omis

    app.listen(PORT, () => {
      console.log('');
      console.log('┌─────────────────────────────────────────────────┐');
      console.log(`│  Gestion Med — Express API                      │`);
      console.log(`│  Serveur     : http://localhost:${PORT}             │`);
      console.log(`│  API         : http://localhost:${PORT}/api/v1      │`);
      console.log(`│  Swagger UI  : http://localhost:${PORT}/api-docs    │`);
      console.log('└─────────────────────────────────────────────────┘');
      console.log('');
    });
  } catch (error) {
    console.error('Impossible de démarrer le serveur :', error.message);
    console.error('Vérifiez votre fichier .env et que MySQL est démarré.');
    process.exit(1);
  }
};

start();
