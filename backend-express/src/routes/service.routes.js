const express = require('express');
const router = express.Router();
const { index, show } = require('../controllers/service.controller');

/**
 * @swagger
 * /api/v1/services:
 *   get:
 *     summary: Liste tous les services actifs (public)
 *     tags: [Services]
 *     responses:
 *       200:
 *         description: Liste des services
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 message: { type: string }
 *                 data:
 *                   type: array
 *                   items: { $ref: '#/components/schemas/Service' }
 */
router.get('/', index);

/**
 * @swagger
 * /api/v1/services/{id}:
 *   get:
 *     summary: Détail d'un service (public)
 *     tags: [Services]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema: { type: integer }
 *         description: ID du service
 *     responses:
 *       200:
 *         description: Détail du service
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 message: { type: string }
 *                 data: { $ref: '#/components/schemas/Service' }
 *       404:
 *         description: Service introuvable
 */
router.get('/:id', show);

module.exports = router;
