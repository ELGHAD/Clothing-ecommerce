# Clothing E-commerce — Boutique en ligne (Laravel)

> Plateforme e-commerce pour une marque de vêtements : catalogue produits filtrable, panier (invité et connecté), tunnel de commande complet et suivi des commandes.

![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4-06B6D4?style=flat&logo=tailwindcss&logoColor=white)
![Status](https://img.shields.io/badge/Status-Portfolio%20Project-blue)
![License](https://img.shields.io/badge/License-MIT-green)

## Aperçu du projet

Clothing E-commerce est une application Laravel implémentant le cœur fonctionnel d'une boutique en ligne de vêtements : navigation produits avec filtres avancés, gestion de panier, tunnel de commande (checkout) avec facturation/livraison, et suivi des commandes côté client. Le projet illustre une architecture MVC Laravel classique avec relations Eloquent, scopes de requête réutilisables et validation robuste des entrées.

Il s'adresse aux recruteurs souhaitant évaluer une implémentation Laravel structurée autour d'un domaine métier e-commerce réaliste (catalogue, panier, commande) plutôt qu'un CRUD basique.

## Fonctionnalités clés

- **Catalogue produits** — listing paginé avec filtres (catégorie, prix min/max, taille, couleur), recherche texte et tri (prix, nouveauté, mis en avant).
- **Fiches produits** — détail produit avec images multiples, produits similaires suggérés par catégorie.
- **Catégories** — hiérarchie catégorie/sous-catégorie avec navigation dédiée.
- **Panier** — fonctionne pour les visiteurs non connectés (basé sur la session) et les utilisateurs authentifiés, avec ajout/mise à jour/suppression via API JSON.
- **Tunnel de commande (checkout)** — formulaire de facturation et livraison, calcul automatique (sous-total, taxe, frais de port), création de commande transactionnelle (rollback en cas d'erreur) avec décrément du stock.
- **Historique de commandes** — consultation des commandes passées et de leur détail depuis le profil utilisateur.
- **Gestion de profil** — mise à jour des informations personnelles, suppression de compte avec confirmation par mot de passe.
- **Newsletter** — inscription à la newsletter avec validation d'email unique.

## Architecture & Stack technique

| Élément | Technologie |
|---|---|
| **Backend** | Laravel 12 (PHP 8.2+) |
| **Base de données** | SQLite en développement (configuré dans `.env.example`) |
| **Frontend** | Blade templates + TailwindCSS 4, build via Vite |
| **Authentification** | Laravel Breeze (dépendance installée, scaffolding non finalisé — voir section "Point d'attention") |
| **Traitement d'images** | Intervention Image |
| **Architecture** | MVC — Contrôleurs, Modèles Eloquent (avec scopes de requête), vues Blade |

**Modèles principaux :** `Product`, `Category`, `ProductImage`, `CartItem`, `Order`, `OrderItem`, `NewsletterSubscriber`, `User` (étendu avec `is_admin`, téléphone, date de naissance, etc.)

## Installation & Démarrage rapide

### Prérequis
- PHP 8.2+
- Composer
- Node.js + npm

### Étapes

```bash
git clone https://github.com/ELGHAD/Clothing-ecommerce.git
cd Clothing-ecommerce

# Dépendances PHP
composer install

# Dépendances front-end
npm install

# Configuration de l'environnement
cp .env.example .env
php artisan key:generate

# Base de données (SQLite par défaut)
touch database/database.sqlite
php artisan migrate --seed

# Compiler les assets et lancer le serveur
npm run dev
php artisan serve
```

L'application est accessible sur `http://localhost:8000`.

## Structure du projet
