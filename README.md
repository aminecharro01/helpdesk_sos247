# Helpdesk SOS247 — Système de gestion de tickets

Ce projet est une application web de gestion de tickets d’assistance (Helpdesk) développée avec Laravel. Elle permet aux clients de soumettre des tickets, aux agents de les traiter, aux superviseurs de superviser l’activité, et aux administrateurs de gérer l’ensemble du système.

## Fonctionnalités principales

- **Gestion multi-rôles** : Administrateur, Superviseur, Agent, Client
- **Création et suivi de tickets** (statut, priorité, catégorie, pièces jointes)
- **Commentaires sur les tickets**
- **Notifications** pour les mises à jour importantes
- **Statistiques et tableaux de bord** adaptés à chaque rôle
- **Filtres et recherche avancée**
- **Interface moderne et responsive** (Bootstrap 5)
- **Sécurité** : authentification, autorisations, CSRF, etc.

## Technologies utilisées
- Laravel 10+
- Bootstrap 5.3
- Chart.js (statistiques)
- MySQL/MariaDB
- PHP 8+

## Installation

1. **Cloner le dépôt**

```bash
git clone https://github.com/aminecharro01/helpdesk_sos247.git
cd helpdesk_sos247
```

2. **Installer les dépendances**

```bash
composer install
npm install && npm run build
```

3. **Configurer l’environnement**

Copiez `.env.example` en `.env` puis configurez la connexion à la base de données et autres variables :

```bash
cp .env.example .env
```

Générez la clé d’application :

```bash
php artisan key:generate
```

4. **Migrer la base de données et ajouter les données de base**

```bash
php artisan migrate --seed
```

5. **Démarrer le serveur local**

```bash
php artisan serve
```

6. **Accéder à l’application**

Ouvrez [http://localhost:8000](http://localhost:8000) dans votre navigateur.

## Utilisation

- **Client** : crée des tickets, suit leur avancement, ajoute des commentaires.
- **Agent** : gère les tickets assignés, répond aux clients, met à jour les statuts.
- **Superviseur** : supervise l’activité, consulte les statistiques, réattribue les tickets si besoin.
- **Administrateur** : gère les utilisateurs, les catégories, supervise tout le système.

## Structure du projet

- `app/Http/Controllers` : logique métier et gestion des rôles
- `resources/views` : interfaces Blade (Bootstrap)
- `routes/web.php` : routes principales de l’application
- `public/` : fichiers accessibles publiquement (assets, uploads)

## Contribution

Toute contribution est la bienvenue ! Merci de créer une issue ou une pull request sur le dépôt GitHub.

## Licence

Ce projet est sous licence MIT.

---

Pour toute question ou suggestion, contactez l’auteur du dépôt.


If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
