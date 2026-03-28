const express = require('express');
const { body } = require('express-validator');
const router = express.Router();
const authenticate = require('../middleware/auth');
const role = require('../middleware/role');
const {
  adminListServices,
  adminCreateService,
  adminUpdateService,
  adminDeleteService,
  adminAssignMedecin,
  adminListReservations,
  adminCancelReservation,
  adminListUsers,
  adminSetRole,
  medecinServices,
  medecinReservations,
  medecinUpdateStatus,
} = require('../controllers/admin.controller');

// ─── Routes MÉDECIN ──────────────────────────────────────────

/**
 * @swagger
 * /api/v1/medecin/services:
 *   get:
 *     summary: Services du médecin connecté
 *     tags: [Médecin]
 *     security:
 *       - bearerAuth: []
 *     responses:
 *       200:
 *         description: Liste des services
 *       403:
 *         description: Accès interdit (rôle médecin requis)
 */
router.get('/medecin/services', authenticate, role('medecin'), medecinServices);

/**
 * @swagger
 * /api/v1/medecin/reservations:
 *   get:
 *     summary: Réservations des services du médecin connecté
 *     tags: [Médecin]
 *     security:
 *       - bearerAuth: []
 *     responses:
 *       200:
 *         description: Liste des réservations
 */
router.get('/medecin/reservations', authenticate, role('medecin'), medecinReservations);

/**
 * @swagger
 * /api/v1/medecin/reservations/{id}/update-status:
 *   post:
 *     summary: Mettre à jour le statut d'une réservation (médecin)
 *     tags: [Médecin]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema: { type: integer }
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             required: [statut]
 *             properties:
 *               statut:
 *                 type: string
 *                 enum: [confirmee, annulee, effectuee]
 *     responses:
 *       200:
 *         description: Statut mis à jour
 *       404:
 *         description: Réservation introuvable
 */
router.post('/medecin/reservations/:id/update-status', authenticate, role('medecin'), medecinUpdateStatus);

// ─── Routes ADMIN ────────────────────────────────────────────

/**
 * @swagger
 * /api/v1/admin/services:
 *   get:
 *     summary: Liste tous les services (admin)
 *     tags: [Admin]
 *     security:
 *       - bearerAuth: []
 *     responses:
 *       200:
 *         description: Tous les services
 *       403:
 *         description: Accès interdit (rôle admin requis)
 */
router.get('/admin/services', authenticate, role('admin'), adminListServices);

/**
 * @swagger
 * /api/v1/admin/services:
 *   post:
 *     summary: Créer un service (admin)
 *     tags: [Admin]
 *     security:
 *       - bearerAuth: []
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             required: [titre, prix, duree]
 *             properties:
 *               titre: { type: string, example: "Consultation cardiologie" }
 *               description: { type: string }
 *               prix: { type: number, example: 15000 }
 *               duree: { type: integer, example: 45 }
 *               statut: { type: string, enum: [actif, inactif] }
 *               medecin_id: { type: integer }
 *     responses:
 *       201:
 *         description: Service créé
 *       422:
 *         description: Erreur de validation
 */
router.post(
  '/admin/services',
  authenticate,
  role('admin'),
  [
    body('titre').notEmpty().withMessage('Le titre est requis.'),
    body('prix').isNumeric().withMessage('Le prix doit être un nombre.'),
    body('duree').isInt({ min: 1 }).withMessage('La durée doit être un entier positif.'),
    body('statut').optional().isIn(['actif', 'inactif']).withMessage('Statut invalide.'),
  ],
  adminCreateService
);

/**
 * @swagger
 * /api/v1/admin/services/{id}:
 *   put:
 *     summary: Modifier un service (admin)
 *     tags: [Admin]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema: { type: integer }
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema: { $ref: '#/components/schemas/Service' }
 *     responses:
 *       200:
 *         description: Service mis à jour
 *       404:
 *         description: Service introuvable
 */
router.put(
  '/admin/services/:id',
  authenticate,
  role('admin'),
  [
    body('titre').optional().notEmpty().withMessage('Le titre ne peut pas être vide.'),
    body('prix').optional().isNumeric().withMessage('Le prix doit être un nombre.'),
    body('duree').optional().isInt({ min: 1 }).withMessage('Durée invalide.'),
    body('statut').optional().isIn(['actif', 'inactif']).withMessage('Statut invalide.'),
  ],
  adminUpdateService
);

/**
 * @swagger
 * /api/v1/admin/services/{id}:
 *   delete:
 *     summary: Supprimer un service (admin)
 *     tags: [Admin]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema: { type: integer }
 *     responses:
 *       200:
 *         description: Service supprimé
 *       404:
 *         description: Service introuvable
 */
router.delete('/admin/services/:id', authenticate, role('admin'), adminDeleteService);

/**
 * @swagger
 * /api/v1/admin/services/{id}/assign:
 *   post:
 *     summary: Assigner un médecin à un service (admin)
 *     tags: [Admin]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema: { type: integer }
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             required: [medecin_id]
 *             properties:
 *               medecin_id: { type: integer, example: 2 }
 *     responses:
 *       200:
 *         description: Médecin assigné
 *       404:
 *         description: Service ou médecin introuvable
 */
router.post('/admin/services/:id/assign', authenticate, role('admin'), adminAssignMedecin);

/**
 * @swagger
 * /api/v1/admin/reservations:
 *   get:
 *     summary: Toutes les réservations (admin)
 *     tags: [Admin]
 *     security:
 *       - bearerAuth: []
 *     responses:
 *       200:
 *         description: Toutes les réservations
 */
router.get('/admin/reservations', authenticate, role('admin'), adminListReservations);

/**
 * @swagger
 * /api/v1/admin/reservations/{id}/cancel:
 *   post:
 *     summary: Annuler une réservation (admin)
 *     tags: [Admin]
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
 */
router.post('/admin/reservations/:id/cancel', authenticate, role('admin'), adminCancelReservation);

/**
 * @swagger
 * /api/v1/admin/users:
 *   get:
 *     summary: Liste tous les utilisateurs (admin)
 *     tags: [Admin]
 *     security:
 *       - bearerAuth: []
 *     responses:
 *       200:
 *         description: Liste des utilisateurs
 */
router.get('/admin/users', authenticate, role('admin'), adminListUsers);

/**
 * @swagger
 * /api/v1/admin/users/{id}/set-role:
 *   post:
 *     summary: Modifier le rôle d'un utilisateur (admin)
 *     tags: [Admin]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema: { type: integer }
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             required: [role]
 *             properties:
 *               role:
 *                 type: string
 *                 enum: [admin, medecin, patient]
 *     responses:
 *       200:
 *         description: Rôle mis à jour
 *       404:
 *         description: Utilisateur introuvable
 *       422:
 *         description: Rôle invalide
 */
router.post('/admin/users/:id/set-role', authenticate, role('admin'), adminSetRole);

module.exports = router;
