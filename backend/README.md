# NOM DU PROJET

Une application web moderne construite avec **Laravel** (backend), **React** (frontend), **Vite** (build tool), **Inertia.js** (SPA), et **Filament** (admin panel).  
Ce projet offre une base robuste pour développer des applications web performantes, modulaires et maintenables.

---

## 🛠️ Stack Technique

- **Backend :** Laravel 12, PHP 8.2
- **Frontend :** React 18, Vite, TailwindCSS
- **SPA & Routing :** Inertia.js, Ziggy
- **Admin :** Filament (avec extensions : Shield, Breezy, Apex Charts, Language Switch)
- **Authentification/API :** Sanctum
- **Tests :** PHPUnit, Pest, Faker
- **Outils Dev :** Sail, Pint, Breeze, Collision
- **Autres :** PDF, Excel, Word (phpspreadsheet, phpword, pdfparser)

---

## 🚀 Démarrage rapide

### Prérequis

- PHP 8.2+
- Node.js & npm
- Composer
- Base de données (MySQL, SQLite, etc.)

### Installation

1. **Cloner le repository**
   ```bash
   git clone https://github.com/votre-utilisateur/votre-projet.git
   cd votre-projet
   ```

2. **Installer les dépendances**
   ```bash
   composer install
   npm install
   ```

3. **Configurer l’environnement**
   ```bash
   cp .env.example .env
   php artisan key:generate
   # Configurez votre .env (DB, MAIL, etc.)
   ```

4. **Lancer les migrations**
   ```bash
   php artisan migrate
   ```

5. **Lancer le serveur local**
   - **Via Sail** (optionnel, si Docker) :
     ```bash
     ./vendor/bin/sail up -d
     ./vendor/bin/sail npm run dev
     ```
   - **Classique :**
     ```bash
     npm run dev
     php artisan serve
     ```

---

## 📦 Scripts Utiles

- `npm run dev` : Lancer le serveur Vite en mode développement.
- `npm run build` : Compiler les assets pour la production.
- `composer dev` : Lancer tous les serveurs (backend, queue, vite) en parallèle.
- `composer test` : Lancer les tests back-end.

---

## ✨ Fonctionnalités principales

- Panneau d'administration Filament personnalisable
- Authentification et autorisations avancées (Sanctum, Filament Shield & Breezy, Spatie Permissions)
- Gestion multilingue (Filament Language Switch)
- Tableaux de bord et statistiques (Apex Charts)
- Export PDF, Excel et Word
- SPA fluide avec Inertia.js & React
- UI moderne avec TailwindCSS et Headless UI

---

## 📁 Structure du projet

- `/app` : Code Laravel (contrôleurs, modèles, etc.)
- `/resources/js` : Code React (pages, composants)
- `/resources/views` : Vues Blade (principalement pour Inertia)
- `/routes` : Fichiers de routes Laravel
- `/public` : Fichiers statiques
- `/tests` : Tests unitaires et fonctionnels

---

## 🔒 Sécurité & Bonnes pratiques

- Gestion avancée des permissions (Spatie, Filament Shield)
- Utilisation de Sanctum pour les API sécurisées
- Vérification des entrées & validation côté back-end et front-end
- Mises à jour régulières recommandées (`composer update`, `npm update`)

---

## 🧑‍💻 Contributions

Les contributions sont les bienvenues !  
Merci de soumettre vos Pull Requests ou d’ouvrir des Issues pour toute suggestion ou bug.

---

## 📄 Licence

Ce projet est sous licence MIT.

---

## 🙏 Remerciements

- [Laravel](https://laravel.com/)
- [React](https://react.dev/)
- [Filament](https://filamentphp.com/)
- [Inertia.js](https://inertiajs.com/)
- [TailwindCSS](https://tailwindcss.com/)
