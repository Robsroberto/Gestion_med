const { validationResult } = require('express-validator');
const { User, Service, Reservation } = require('../models');

// ─────────────────────────────────────────────────────────────
//  GESTION DES SERVICES (Admin + Médecin partagent certaines routes)
// ─────────────────────────────────────────────────────────────

/**
 * GET /api/v1/admin/services
 * Liste TOUS les services (admin)
 */
const adminListServices = async (req, res) => {
  try {
    const services = await Service.findAll({
      include: [{ model: User, as: 'medecin', attributes: ['id', 'name'] }],
      order: [['created_at', 'DESC']],
    });
    return res.status(200).json({ message: 'Tous les services.', data: services });
  } catch (error) {
    console.error('Erreur adminListServices:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

/**
 * POST /api/v1/admin/services
 * Créer un service
 */
const adminCreateService = async (req, res) => {
  const errors = validationResult(req);
  if (!errors.isEmpty()) {
    return res.status(422).json({ message: 'Erreur de validation.', errors: errors.mapped() });
  }

  try {
    const { titre, description, prix, duree, statut, medecin_id } = req.body;

    if (medecin_id) {
      const medecin = await User.findOne({ where: { id: medecin_id, role: 'medecin' } });
      if (!medecin) {
        return res.status(404).json({ message: 'Médecin introuvable.' });
      }
    }

    const service = await Service.create({ titre, description, prix, duree, statut: statut || 'actif', medecin_id: medecin_id || null });
    return res.status(201).json({ message: 'Service créé.', data: service });
  } catch (error) {
    console.error('Erreur adminCreateService:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

/**
 * PUT /api/v1/admin/services/:id
 * Modifier un service
 */
const adminUpdateService = async (req, res) => {
  const errors = validationResult(req);
  if (!errors.isEmpty()) {
    return res.status(422).json({ message: 'Erreur de validation.', errors: errors.mapped() });
  }

  try {
    const service = await Service.findByPk(req.params.id);
    if (!service) return res.status(404).json({ message: 'Service introuvable.' });

    await service.update(req.body);
    return res.status(200).json({ message: 'Service mis à jour.', data: service });
  } catch (error) {
    console.error('Erreur adminUpdateService:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

/**
 * DELETE /api/v1/admin/services/:id
 * Supprimer un service
 */
const adminDeleteService = async (req, res) => {
  try {
    const service = await Service.findByPk(req.params.id);
    if (!service) return res.status(404).json({ message: 'Service introuvable.' });

    await service.destroy();
    return res.status(200).json({ message: 'Service supprimé.' });
  } catch (error) {
    console.error('Erreur adminDeleteService:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

/**
 * POST /api/v1/admin/services/:id/assign
 * Assigner un médecin à un service
 */
const adminAssignMedecin = async (req, res) => {
  try {
    const { medecin_id } = req.body;
    const service = await Service.findByPk(req.params.id);
    if (!service) return res.status(404).json({ message: 'Service introuvable.' });

    const medecin = await User.findOne({ where: { id: medecin_id, role: 'medecin' } });
    if (!medecin) return res.status(404).json({ message: 'Médecin introuvable.' });

    await service.update({ medecin_id });
    return res.status(200).json({ message: 'Médecin assigné au service.', data: service });
  } catch (error) {
    console.error('Erreur adminAssignMedecin:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

// ─────────────────────────────────────────────────────────────
//  GESTION DES RÉSERVATIONS (Admin)
// ─────────────────────────────────────────────────────────────

/**
 * GET /api/v1/admin/reservations
 * Toutes les réservations
 */
const adminListReservations = async (req, res) => {
  try {
    const reservations = await Reservation.findAll({
      include: [
        { model: User, as: 'patient', attributes: ['id', 'name', 'email'] },
        { model: Service, as: 'service', attributes: ['id', 'titre', 'prix'] },
      ],
      order: [['date_reservation', 'DESC']],
    });
    return res.status(200).json({ message: 'Toutes les réservations.', data: reservations });
  } catch (error) {
    console.error('Erreur adminListReservations:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

/**
 * POST /api/v1/admin/reservations/:id/cancel
 * Annuler n'importe quelle réservation (admin)
 */
const adminCancelReservation = async (req, res) => {
  try {
    const reservation = await Reservation.findByPk(req.params.id);
    if (!reservation) return res.status(404).json({ message: 'Réservation introuvable.' });

    await reservation.update({ statut: 'annulee' });
    return res.status(200).json({ message: 'Réservation annulée.', data: reservation });
  } catch (error) {
    console.error('Erreur adminCancelReservation:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

// ─────────────────────────────────────────────────────────────
//  GESTION DES UTILISATEURS (Admin)
// ─────────────────────────────────────────────────────────────

/**
 * GET /api/v1/admin/users
 * Liste tous les utilisateurs
 */
const adminListUsers = async (req, res) => {
  try {
    const users = await User.findAll({
      attributes: { exclude: ['password'] },
      order: [['created_at', 'DESC']],
    });
    return res.status(200).json({ message: 'Liste des utilisateurs.', data: users });
  } catch (error) {
    console.error('Erreur adminListUsers:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

/**
 * POST /api/v1/admin/users/:id/set-role
 * Modifier le rôle d'un utilisateur
 */
const adminSetRole = async (req, res) => {
  try {
    const { role } = req.body;
    const validRoles = ['admin', 'medecin', 'patient'];

    if (!validRoles.includes(role)) {
      return res.status(422).json({ message: 'Rôle invalide. Valeurs acceptées : admin, medecin, patient.' });
    }

    const user = await User.findByPk(req.params.id);
    if (!user) return res.status(404).json({ message: 'Utilisateur introuvable.' });

    await user.update({ role });
    return res.status(200).json({
      message: `Rôle mis à jour : ${role}.`,
      user: { id: user.id, name: user.name, email: user.email, role: user.role },
    });
  } catch (error) {
    console.error('Erreur adminSetRole:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

// ─────────────────────────────────────────────────────────────
//  ROUTES MÉDECIN
// ─────────────────────────────────────────────────────────────

/**
 * GET /api/v1/medecin/services
 * Services du médecin connecté
 */
const medecinServices = async (req, res) => {
  try {
    const services = await Service.findAll({
      where: { medecin_id: req.user.id },
      order: [['created_at', 'DESC']],
    });
    return res.status(200).json({ message: 'Mes services.', data: services });
  } catch (error) {
    console.error('Erreur medecinServices:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

/**
 * GET /api/v1/medecin/reservations
 * Réservations des services du médecin connecté
 */
const medecinReservations = async (req, res) => {
  try {
    // Récupérer les IDs des services du médecin
    const services = await Service.findAll({
      where: { medecin_id: req.user.id },
      attributes: ['id'],
    });
    const serviceIds = services.map((s) => s.id);

    const reservations = await Reservation.findAll({
      where: { service_id: serviceIds },
      include: [
        { model: User, as: 'patient', attributes: ['id', 'name', 'email'] },
        { model: Service, as: 'service', attributes: ['id', 'titre'] },
      ],
      order: [['date_reservation', 'DESC']],
    });

    return res.status(200).json({ message: 'Réservations de mes services.', data: reservations });
  } catch (error) {
    console.error('Erreur medecinReservations:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

/**
 * POST /api/v1/medecin/reservations/:id/update-status
 * Mettre à jour le statut d'une réservation (médecin)
 */
const medecinUpdateStatus = async (req, res) => {
  try {
    const { statut } = req.body;
    const validStatuts = ['confirmee', 'annulee', 'effectuee'];

    if (!validStatuts.includes(statut)) {
      return res.status(422).json({
        message: 'Statut invalide. Valeurs acceptées : confirmee, annulee, effectuee.',
      });
    }

    // Vérifier que la réservation appartient à un service du médecin
    const services = await Service.findAll({
      where: { medecin_id: req.user.id },
      attributes: ['id'],
    });
    const serviceIds = services.map((s) => s.id);

    const reservation = await Reservation.findOne({
      where: { id: req.params.id, service_id: serviceIds },
    });

    if (!reservation) {
      return res.status(404).json({ message: 'Réservation introuvable.' });
    }

    await reservation.update({ statut });
    return res.status(200).json({ message: `Statut mis à jour : ${statut}.`, data: reservation });
  } catch (error) {
    console.error('Erreur medecinUpdateStatus:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

module.exports = {
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
};
