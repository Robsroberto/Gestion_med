const express = require('express');
const { body } = require('express-validator');
const router = express.Router();
const { register, login, logout, me } = require('../controllers/auth.controller');
const authenticate = require('../middleware/auth');

/**
 * @swagger
 * /api/v1/register:
 *   post:
 *     summary: Inscription d'un nouvel utilisateur
 *     tags: [Auth]
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             required: [name, email, password]
 *             properties:
 *               name:
 *                 type: string
 *                 example: Jean Dupont
 *               email:
 *                 type: string
 *                 example: jean@example.com
 *               password:
 *                 type: string
 *                 example: secret123
 *               role:
 *                 type: string
 *                 enum: [admin, medecin, patient]
 *                 example: patient
 *     responses:
 *       201:
 *         description: Inscription réussie
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 message: { type: string }
 *                 user: { $ref: '#/components/schemas/User' }
 *                 token: { type: string }
 *       422:
 *         description: Erreur de validation
 *         content:
 *           application/json:
 *             schema: { $ref: '#/components/schemas/ErrorResponse' }
 */
router.post(
  '/register',
  [
    body('name').notEmpty().withMessage('Le nom est requis.').trim(),
    body('email').isEmail().withMessage('Email invalide.').normalizeEmail(),
    body('password').isLength({ min: 6 }).withMessage('Mot de passe : 6 caractères minimum.'),
    body('role').optional().isIn(['admin', 'medecin', 'patient']).withMessage('Rôle invalide.'),
  ],
  register
);

/**
 * @swagger
 * /api/v1/login:
 *   post:
 *     summary: Connexion et obtention du token JWT
 *     tags: [Auth]
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             required: [email, password]
 *             properties:
 *               email:
 *                 type: string
 *                 example: jean@example.com
 *               password:
 *                 type: string
 *                 example: secret123
 *     responses:
 *       200:
 *         description: Connexion réussie
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 message: { type: string }
 *                 user: { $ref: '#/components/schemas/User' }
 *                 token:
 *                   type: string
 *                   example: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...
 *       401:
 *         description: Identifiants incorrects
 */
router.post(
  '/login',
  [
    body('email').isEmail().withMessage('Email invalide.').normalizeEmail(),
    body('password').notEmpty().withMessage('Mot de passe requis.'),
  ],
  login
);

/**
 * @swagger
 * /api/v1/logout:
 *   post:
 *     summary: Déconnexion (invalider le token côté client)
 *     tags: [Auth]
 *     security:
 *       - bearerAuth: []
 *     responses:
 *       200:
 *         description: Déconnexion réussie
 *       401:
 *         description: Non authentifié
 */
router.post('/logout', authenticate, logout);

/**
 * @swagger
 * /api/v1/me:
 *   get:
 *     summary: Profil de l'utilisateur connecté
 *     tags: [Auth]
 *     security:
 *       - bearerAuth: []
 *     responses:
 *       200:
 *         description: Profil récupéré
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 message: { type: string }
 *                 user: { $ref: '#/components/schemas/User' }
 *       401:
 *         description: Non authentifié
 */
router.get('/me', authenticate, me);

module.exports = router;
