const sequelize = require('../config/database');
const User = require('./User');
const Service = require('./Service');
const Reservation = require('./Reservation');

// ─── Associations (équivalent des relations Eloquent Laravel) ───────────────

// Un médecin (User) possède plusieurs services
User.hasMany(Service, { foreignKey: 'medecin_id', as: 'services' });
Service.belongsTo(User, { foreignKey: 'medecin_id', as: 'medecin' });

// Un patient (User) possède plusieurs réservations
User.hasMany(Reservation, { foreignKey: 'user_id', as: 'reservations' });
Reservation.belongsTo(User, { foreignKey: 'user_id', as: 'patient' });

// Un service peut avoir plusieurs réservations
Service.hasMany(Reservation, { foreignKey: 'service_id', as: 'reservations' });
Reservation.belongsTo(Service, { foreignKey: 'service_id', as: 'service' });

module.exports = { sequelize, User, Service, Reservation };
