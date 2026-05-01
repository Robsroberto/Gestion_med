const swaggerJsdoc = require('swagger-jsdoc');

const options = {
  definition: {
    openapi: '3.0.0',
    info: {
      title: 'Gestion Med API',
      version: '1.0.0',
      description:
        'API REST de réservation médicale — Backend Express.js (réplique du backend Laravel)',
    },
    servers: [
      {
        url: 'http://localhost:3000',
        description: 'Serveur de développement',
      },
    ],
    components: {
      securitySchemes: {
        // Authentification Bearer JWT — identique à Laravel Sanctum
        bearerAuth: {
          type: 'http',
          scheme: 'bearer',
          bearerFormat: 'JWT',
          description: 'Entrez votre token JWT obtenu via POST /api/v1/login',
        },
      },
      schemas: {
        User: {
          type: 'object',
          properties: {
            id: { type: 'integer', example: 1 },
            name: { type: 'string', example: 'Jean Dupont' },
            email: { type: 'string', example: 'jean@example.com' },
            role: {
              type: 'string',
              enum: ['admin', 'medecin', 'patient'],
              example: 'patient',
            },
            created_at: { type: 'string', format: 'date-time' },
            updated_at: { type: 'string', format: 'date-time' },
          },
        },
        Service: {
          type: 'object',
          properties: {
            id: { type: 'integer', example: 1 },
            titre: { type: 'string', example: 'Consultation générale' },
            description: {
              type: 'string',
              example: 'Consultation médicale de base',
            },
            prix: { type: 'number', example: 5000 },
            duree: { type: 'integer', example: 30, description: 'En minutes' },
            statut: {
              type: 'string',
              enum: ['actif', 'inactif'],
              example: 'actif',
            },
            medecin_id: { type: 'integer', nullable: true, example: 2 },
          },
        },
        Reservation: {
          type: 'object',
          properties: {
            id: { type: 'integer', example: 1 },
            user_id: { type: 'integer', example: 3 },
            service_id: { type: 'integer', example: 1 },
            date_reservation: {
              type: 'string',
              format: 'date',
              example: '2024-12-15',
            },
            heure_reservation: { type: 'string', example: '09:00' },
            statut: {
              type: 'string',
              enum: ['en_attente', 'confirmee', 'annulee', 'effectuee'],
              example: 'en_attente',
            },
            commentaire: { type: 'string', nullable: true },
          },
        },
        ErrorResponse: {
          type: 'object',
          properties: {
            message: { type: 'string', example: 'Erreur de validation.' },
            errors: { type: 'object' },
          },
        },
      },
    },
    tags: [
      { name: 'Auth', description: 'Inscription, connexion, déconnexion' },
      { name: 'Services', description: 'Consultation des services médicaux' },
      {
        name: 'Patient',
        description: 'Gestion des réservations (rôle patient)',
      },
      {
        name: 'Médecin',
        description: 'Gestion des services et réservations (rôle médecin)',
      },
      {
        name: 'Admin',
        description: 'Administration complète (rôle admin)',
      },
    ],
  },
  // Fichiers contenant les annotations @swagger
  apis: ['./src/routes/*.js'],
};

const swaggerSpec = swaggerJsdoc(options);

module.exports = swaggerSpec;
