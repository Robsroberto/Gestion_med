const { validationResult } = require('express-validator');
const { Reservation, Service, User } = require('../models');

/**
 * GET /api/v1/reservations
 * Liste des réservations du patient connecté
 */
const index = async (req, res) => {
  try {
    const reservations = await Reservation.findAll({
      where: { user_id: req.user.id },
      include: [
        {
          model: Service,
          as: 'service',
          attributes: ['id', 'titre', 'prix', 'duree'],
        },
      ],
      order: [['date_reservation', 'DESC']],
    });

    return res.status(200).json({
      message: 'Mes réservations.',
      data: reservations,
    });
  } catch (error) {
    console.error('Erreur reservation.index:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

/**
 * POST /api/v1/reservations
 * Créer une nouvelle réservation (patient)
 */
const store = async (req, res) => {
  const errors = validationResult(req);
  if (!errors.isEmpty()) {
    return res.status(422).json({
      message: 'Erreur de validation.',
      errors: errors.mapped(),
    });
  }

  try {
    const { service_id, date_reservation, heure_reservation, commentaire } = req.body;

    // Vérifier que le service existe et est actif
    const service = await Service.findOne({
      where: { id: service_id, statut: 'actif' },
    });
    if (!service) {
      return res.status(404).json({ message: 'Service introuvable ou inactif.' });
    }

    const reservation = await Reservation.create({
      user_id: req.user.id,
      service_id,
      date_reservation,
      heure_reservation,
      statut: 'en_attente',
      commentaire: commentaire || null,
    });

    // Recharger avec les associations
    const reservationWithRelations = await Reservation.findByPk(reservation.id, {
      include: [{ model: Service, as: 'service', attributes: ['id', 'titre', 'prix'] }],
    });

    return res.status(201).json({
      message: 'Réservation créée avec succès.',
      data: reservationWithRelations,
    });
  } catch (error) {
    console.error('Erreur reservation.store:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

/**
 * POST /api/v1/reservations/:id/cancel
 * Annuler une réservation (patient — seulement les siennes)
 */
const cancel = async (req, res) => {
  try {
    const reservation = await Reservation.findOne({
      where: { id: req.params.id, user_id: req.user.id },
    });

    if (!reservation) {
      return res.status(404).json({ message: 'Réservation introuvable.' });
    }

    if (reservation.statut === 'annulee') {
      return res.status(400).json({ message: 'Cette réservation est déjà annulée.' });
    }

    if (['effectuee', 'confirmee'].includes(reservation.statut)) {
      return res.status(400).json({
        message: 'Impossible d\'annuler une réservation confirmée ou effectuée.',
      });
    }

    await reservation.update({ statut: 'annulee' });

    return res.status(200).json({
      message: 'Réservation annulée.',
      data: reservation,
    });
  } catch (error) {
    console.error('Erreur reservation.cancel:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

module.exports = { index, store, cancel };
