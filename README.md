# Auto-École Management System

Une application moderne et intuitive pour la gestion d'une auto-école, construite avec **Laravel**, **Tailwind CSS** et **Alpine.js**.

## Fonctionnalités Clés

L'application propose une gestion complète via différents tableaux de bord adaptés à chaque rôle :

### Administrateur
- **Tableau de bord statistique** : Vue d'ensemble des revenus, réservations et effectifs.
- **Gestion des utilisateurs** : Administration complète des candidats et du personnel.
- **Gestion des formations** : Création et modification des tarifs de formation.
- **Exports PDF** : Génération de rapports pour les utilisateurs, séances, et paiements.

### Assistante
- **Planification** : Gestion des séances de conduite et du planning.
- **Suivi des paiements** : Enregistrement et suivi des règlements candidats.
- **Gestion des réservations** : Validation et suivi du statut des réservations.

### Moniteur
- **Planning personnel** : Consultation des séances de conduite assignées.
- **Suivi candidats** : Accès à la liste des élèves pour chaque séance.
- **Total d'heures** : Récapitulatif des heures de conduite effectuées.

### Candidat (Élève)
- **Réservation en ligne** : Choix des séances de conduite selon les disponibilités.
- **Paiement sécurisé** : Règlement des formations et suivi des factures.
- **Tableau de bord personnel** : Suivi de la progression (heures faites) et des paiements restants.

---

## Installation et Lancement

Suivez ces étapes pour installer le projet localement :

1.  **Cloner le dépôt**
    ```bash
    git clone <url-du-depot>
    cd auto-ecole-app
    ```

2.  **Installer les dépendances**
    ```bash
    composer install
    npm install
    ```

3.  **Configurer l'environnement**
    - Copiez le fichier `.env.example` en `.env`.
    - Configurez vos accès à la base de données dans le fichier `.env`.

4.  **Initialiser la base de données**
    - Créez la base de données (si non existante via `php create_db.php`).
    ```bash
    php artisan key:generate
    php artisan migrate --seed
    ```

5.  **Lancer le serveur**
    ```bash
    php artisan serve
    npm run dev
    ```

---

## Accès aux Tableaux de Bord

Voici les comptes de test générés par défaut pour accéder à chaque interface :

| Rôle | URL d'accès | Email | Mot de passe |
| :--- | :--- | :--- | :--- |
| **Admin** | `/admin/dashboard` | `admin@auto-ecole.com` | `password` |
| **Assistante** | `/assistante/dashboard` | `assistante@auto-ecole.com` | `password` |
| **Moniteur** | `/moniteur/dashboard` | `moniteur@auto-ecole.com` | `password` |
| **Candidat** | `/candidat/dashboard` | `eleve@auto-ecole.com` | `password` |

---

## Stack Technique

- **Backend** : Laravel 11.x
- **Frontend** : Blade, Tailwind CSS, Alpine.js (Laravel Breeze Stack)
- **Base de données** : MySQL
- **Tooling** : Vite, Composer, NPM
# auto-ecole-app