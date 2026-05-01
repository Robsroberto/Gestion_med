const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
const { validationResult } = require('express-validator');
const { User } = require('../models');

/**
 * Génère un token JWT pour un utilisateur
 */
const generateToken = (user) => {
  return jwt.sign(
    { id: user.id, email: user.email, role: user.role },
    process.env.JWT_SECRET,
    { expiresIn: process.env.JWT_EXPIRES_IN || '7d' }
  );
};

/**
 * POST /api/v1/register
 * Inscription d'un nouvel utilisateur
 */
const register = async (req, res) => {
  // 1. Valider les données entrantes
  const errors = validationResult(req);
  if (!errors.isEmpty()) {
    return res.status(422).json({
      message: 'Erreur de validation.',
      errors: errors.mapped(),
    });
  }

  try {
    const { name, email, password, role } = req.body;

    // 2. Vérifier que l'email n'est pas déjà utilisé
    const existing = await User.findOne({ where: { email } });
    if (existing) {
      return res.status(422).json({
        message: 'Erreur de validation.',
        errors: { email: { msg: 'Cet email est déjà utilisé.' } },
      });
    }

    // 3. Hasher le mot de passe (compatible avec bcrypt Laravel)
    const hashedPassword = await bcrypt.hash(password, 10);

    // 4. Créer l'utilisateur
    const user = await User.create({
      name,
      email,
      password: hashedPassword,
      role: role || 'patient',
    });

    // 5. Générer le token JWT
    const token = generateToken(user);

    return res.status(201).json({
      message: 'Inscription réussie.',
      user: {
        id: user.id,
        name: user.name,
        email: user.email,
        role: user.role,
      },
      token,
    });
  } catch (error) {
    console.error('Erreur register:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

/**
 * POST /api/v1/login
 * Connexion d'un utilisateur existant
 */
const login = async (req, res) => {
  const errors = validationResult(req);
  if (!errors.isEmpty()) {
    return res.status(422).json({
      message: 'Erreur de validation.',
      errors: errors.mapped(),
    });
  }

  try {
    const { email, password } = req.body;

    // 1. Trouver l'utilisateur par email
    const user = await User.findOne({ where: { email } });
    if (!user) {
      return res.status(401).json({ message: 'Identifiants incorrects.' });
    }

    // 2. Comparer le mot de passe avec le hash bcrypt
    const isMatch = await bcrypt.compare(password, user.password);
    if (!isMatch) {
      return res.status(401).json({ message: 'Identifiants incorrects.' });
    }

    // 3. Générer le token
    const token = generateToken(user);

    return res.status(200).json({
      message: 'Connexion réussie.',
      user: {
        id: user.id,
        name: user.name,
        email: user.email,
        role: user.role,
      },
      token,
    });
  } catch (error) {
    console.error('Erreur login:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

/**
 * POST /api/v1/logout
 * Déconnexion (côté JWT, on informe le client de supprimer le token)
 * Note : avec JWT stateless, la déconnexion réelle se fait côté client.
 * Pour invalider les tokens, il faudrait une blacklist Redis (aller plus loin).
 */
const logout = async (req, res) => {
  return res.status(200).json({
    message: 'Déconnexion réussie. Supprimez le token côté client.',
  });
};

/**
 * GET /api/v1/me
 * Retourner le profil de l'utilisateur connecté
 */
const me = async (req, res) => {
  return res.status(200).json({
    message: 'Profil récupéré.',
    user: {
      id: req.user.id,
      name: req.user.name,
      email: req.user.email,
      role: req.user.role,
      created_at: req.user.created_at,
    },
  });
};

module.exports = { register, login, logout, me };
