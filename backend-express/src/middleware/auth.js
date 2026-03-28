const jwt = require('jsonwebtoken');
const { User } = require('../models');

/**
 * Middleware d'authentification JWT
 *
 * Rôle : vérifier que la requête contient un token Bearer valide,
 * récupérer l'utilisateur en base et l'attacher à req.user.
 *
 * Équivalent Laravel : auth:sanctum middleware
 */
const authenticate = async (req, res, next) => {
  try {
    // 1. Extraire le token de l'en-tête Authorization: Bearer <token>
    const authHeader = req.headers['authorization'];

    if (!authHeader || !authHeader.startsWith('Bearer ')) {
      return res.status(401).json({ message: 'Token non fourni. Authentification requise.' });
    }

    const token = authHeader.split(' ')[1];

    // 2. Vérifier et décoder le token
    let decoded;
    try {
      decoded = jwt.verify(token, process.env.JWT_SECRET);
    } catch (err) {
      if (err.name === 'TokenExpiredError') {
        return res.status(401).json({ message: 'Token expiré. Reconnectez-vous.' });
      }
      return res.status(401).json({ message: 'Token invalide.' });
    }

    // 3. Charger l'utilisateur depuis la base
    const user = await User.findByPk(decoded.id);
    if (!user) {
      return res.status(401).json({ message: 'Utilisateur introuvable.' });
    }

    // 4. Attacher l'utilisateur à la requête pour les middlewares suivants
    req.user = user;
    next();
  } catch (error) {
    console.error('Erreur middleware auth:', error);
    return res.status(500).json({ message: 'Erreur serveur lors de l\'authentification.' });
  }
};

module.exports = authenticate;
