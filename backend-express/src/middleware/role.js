/**
 * Middleware de vérification de rôle
 *
 * Utilisation : role('admin')  ou  role('admin', 'medecin')
 * Doit toujours être placé APRÈS le middleware authenticate.
 *
 * Équivalent Laravel : middleware('role:admin') ou Gate
 */
const role = (...roles) => {
  return (req, res, next) => {
    // req.user est attaché par le middleware authenticate
    if (!req.user) {
      return res.status(401).json({ message: 'Non authentifié.' });
    }

    if (!roles.includes(req.user.role)) {
      return res.status(403).json({
        message: `Accès interdit. Rôle requis : ${roles.join(' ou ')}.`,
      });
    }

    next();
  };
};

module.exports = role;
