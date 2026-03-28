const { DataTypes } = require('sequelize');
const sequelize = require('../config/database');

/**
 * Modèle Reservation
 *
 * Correspond à la table `reservations` créée par les migrations Laravel.
 */
const Reservation = sequelize.define(
  'Reservation',
  {
    id: {
      type: DataTypes.BIGINT.UNSIGNED,
      primaryKey: true,
      autoIncrement: true,
    },
    user_id: {
      type: DataTypes.BIGINT.UNSIGNED,
      allowNull: false,
      references: {
        model: 'users',
        key: 'id',
      },
    },
    service_id: {
      type: DataTypes.BIGINT.UNSIGNED,
      allowNull: false,
      references: {
        model: 'services',
        key: 'id',
      },
    },
    date_reservation: {
      type: DataTypes.DATEONLY,
      allowNull: false,
    },
    heure_reservation: {
      type: DataTypes.TIME,
      allowNull: false,
    },
    statut: {
      type: DataTypes.ENUM('en_attente', 'confirmee', 'annulee', 'effectuee'),
      allowNull: false,
      defaultValue: 'en_attente',
    },
    commentaire: {
      type: DataTypes.TEXT,
      allowNull: true,
    },
  },
  {
    tableName: 'reservations',
    timestamps: true,
    underscored: true,
  }
);

module.exports = Reservation;
