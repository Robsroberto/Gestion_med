const { validationResult } = require('express-validator');
const { Service, User } = require('../models');

/**
 * GET /api/v1/services
 * Liste de tous les services actifs (public)
 */
const index = async (req, res) => {
  try {
    const services = await Service.findAll({
      where: { statut: 'actif' },
      include: [
        {
          model: User,
          as: 'medecin',
          attributes: ['id', 'name', 'email'],
        },
      ],
      order: [['created_at', 'DESC']],
    });

    return res.status(200).json({
      message: 'Liste des services.',
      data: services,
    });
  } catch (error) {
    console.error('Erreur service.index:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

/**
 * GET /api/v1/services/:id
 * Détail d'un service (public)
 */
const show = async (req, res) => {
  try {
    const service = await Service.findByPk(req.params.id, {
      include: [
        {
          model: User,
          as: 'medecin',
          attributes: ['id', 'name', 'email'],
        },
      ],
    });

    if (!service) {
      return res.status(404).json({ message: 'Service introuvable.' });
    }

    return res.status(200).json({
      message: 'Détail du service.',
      data: service,
    });
  } catch (error) {
    console.error('Erreur service.show:', error);
    return res.status(500).json({ message: 'Erreur serveur.' });
  }
};

module.exports = { index, show };
