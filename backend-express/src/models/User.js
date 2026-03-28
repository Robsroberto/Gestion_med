const { DataTypes } = require('sequelize');
const sequelize = require('../config/database');

/**
 * Modèle User
 *
 * Correspond exactement à la table `users` créée par les migrations Laravel.
 * sync: false → Sequelize ne touche PAS à la table existante.
 */
const User = sequelize.define(
  'User',
  {
    id: {
      type: DataTypes.BIGINT.UNSIGNED,
      primaryKey: true,
      autoIncrement: true,
    },
    name: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    email: {
      type: DataTypes.STRING,
      allowNull: false,
      unique: true,
      validate: {
        isEmail: true,
      },
    },
    password: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    role: {
      type: DataTypes.ENUM('admin', 'medecin', 'patient'),
      allowNull: false,
      defaultValue: 'patient',
    },
  },
  {
    tableName: 'users',    // nom exact de la table Laravel
    timestamps: true,      // created_at, updated_at
    underscored: true,     // snake_case pour les colonnes
  }
);

module.exports = User;
