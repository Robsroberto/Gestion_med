const express = require('express');
const router = express.Router();

const authRoutes = require('./auth.routes');
const serviceRoutes = require('./service.routes');
const reservationRoutes = require('./reservation.routes');
const adminRoutes = require('./admin.routes');

// Routes publiques et auth
router.use('/', authRoutes);

// Services (public)
router.use('/services', serviceRoutes);

// Réservations (patient authentifié)
router.use('/reservations', reservationRoutes);

// Routes admin + médecin (montées à la racine pour respecter les préfixes /admin et /medecin)
router.use('/', adminRoutes);

module.exports = router;
