const { DataTypes } = require('sequelize');
const sequelize = require('../config/database');

/**
 * Modèle Service
 *
 * Correspond à la table `services` créée par les migrations Laravel.
 */
const Service = sequelize.define(
  'Service',
  {
    id: {
      type: DataTypes.BIGINT.UNSIGNED,
      primaryKey: true,
      autoIncrement: true,
    },
    titre: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    description: {
      type: DataTypes.TEXT,
      allowNull: true,
    },
    prix: {
      type: DataTypes.DECIMAL(10, 2),
      allowNull: false,
    },
    duree: {
      type: DataTypes.INTEGER,
      allowNull: false,
      comment: 'Durée en minutes',
    },
    statut: {
      type: DataTypes.ENUM('actif', 'inactif'),
      allowNull: false,
      defaultValue: 'actif',
    },
    medecin_id: {
      type: DataTypes.BIGINT.UNSIGNED,
      allowNull: true,
      references: {
        model: 'users',
        key: 'id',
      },
    },
  },
  {
    tableName: 'services',
    timestamps: true,
    underscored: true,
  }
);

module.exports = Service;
