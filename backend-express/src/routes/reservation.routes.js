const express = require('express');
const { body } = require('express-validator');
const router = express.Router();
const { index, store, cancel } = require('../controllers/reservation.controller');
const authenticate = require('../middleware/auth');
const role = require('../middleware/role');

// Toutes les routes de ce fichier requièrent : authentifié + rôle patient
router.use(authenticate, role('patient'));

/**
 * @swagger
 * /api/v1/reservations:
 *   get:
 *     summary: Liste des réservations du patient connecté
 *     tags: [Patient]
 *     security:
 *       - bearerAuth: []
 *     responses:
 *       200:
 *         description: Liste des réservations
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 message: { type: string }
 *                 data:
 *                   type: array
 *                   items: { $ref: '#/components/schemas/Reservation' }
 *       401:
 *         description: Non authentifié
 *       403:
 *         description: Accès interdit (rôle patient requis)
 */
router.get('/', index);

/**
 * @swagger
 * /api/v1/reservations:
 *   post:
 *     summary: Créer une réservation (patient)
 *     tags: [Patient]
 *     security:
 *       - bearerAuth: []
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             required: [service_id, date_reservation, heure_reservation]
 *             properties:
 *               service_id:
 *                 type: integer
 *                 example: 1
 *               date_reservation:
 *                 type: string
 *                 format: date
 *                 example: "2024-12-20"
 *               heure_reservation:
 *                 type: string
 *                 example: "09:00"
 *               commentaire:
 *                 type: string
 *                 example: "Première consultation"
 *     responses:
 *       201:
 *         description: Réservation créée
 *       422:
 *         description: Erreur de validation
 */
router.post(
  '/',
  [
    body('service_id').isInt({ min: 1 }).withMessage('service_id invalide.'),
    body('date_reservation').isDate().withMessage('Date invalide (format YYYY-MM-DD).'),
    body('heure_reservation').notEmpty().withMessage('Heure requise.'),
  ],
  store
);

/**
 * @swagger
 * /api/v1/reservations/{id}/cancel:
 *   post:
 *     summary: Annuler une réservation (patient)
 *     tags: [Patient]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema: { type: integer }
 *     responses:
 *       200:
 *         description: Réservation annulée
 *       404:
 *         description: Réservation introuvable
 *       400:
 *         description: Annulation impossible
 */
router.post('/:id/cancel', cancel);

module.exports = router;
