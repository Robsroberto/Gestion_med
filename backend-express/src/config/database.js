const { Sequelize } = require('sequelize');
require('dotenv').config();

const sequelize = new Sequelize(
  process.env.DB_NAME || 'reservation_app',
  process.env.DB_USER || 'root',
  process.env.DB_PASSWORD || '',
  {
    host: process.env.DB_HOST || '127.0.0.1',
    port: parseInt(process.env.DB_PORT) || 3306,
    dialect: 'mysql',
    logging: false, // mettre console.log pour déboguer les requêtes SQL
    define: {
      // Correspond aux colonnes created_at / updated_at de Laravel
      underscored: true,
      timestamps: true,
    },
  }
);

module.exports = sequelize;
