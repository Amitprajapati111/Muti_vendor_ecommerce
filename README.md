# MultiVendor eShop (PHP + MySQL)

A responsive, animated multi-vendor eCommerce website built with PHP (no framework), MySQL, Bootstrap 5, and vanilla JS. Includes Customer, Vendor, and Admin flows with dashboards and AJAX search.

## Requirements
- XAMPP (Apache + MySQL) on Windows
- PHP 8.1+ recommended
- Apache `mod_rewrite` enabled

## Quick Start (XAMPP)
1. Copy this folder to your XAMPP htdocs, e.g. `C:\xampp\htdocs\multivendor-eshop`.
2. Start Apache and MySQL from XAMPP Control Panel.
3. Create and seed the database:
   - Open phpMyAdmin: http://localhost/phpmyadmin
   - Import `database/schema.sql`
   - Import `database/seed.sql`
   - Import `database/alter_01_wishlist.sql` (adds wishlist table)
   - Import `database/alter_02_order_item_status.sql` (adds order_items.status for vendor shipping updates)
4. Visit the app: http://localhost/multivendor-eshop/public/

If you prefer a clean URL without `/public`, you can keep the root `.htaccess` we added which redirects to `public/` automatically, then use: http://localhost/multivendor-eshop/

## Default Accounts (DEV)
- Admin: `admin@demo.com` / `admin123`
- Vendor: `vendor@demo.com` / `vendor123`
- Customer: `customer@demo.com` / `customer123`

Note: In `config/config.php`, `APP_DEBUG` is true by default. While in DEV, plaintext passwords from seed are accepted (see `app/controllers/AuthController.php`). In production, set `APP_DEBUG` to false and use hashed passwords.

## Folder Structure
- `public/` Front controller (`index.php`), assets, and webroot `.htaccess`
- `app/core/` Router, Controller, Database
- `app/controllers/` MVC Controllers
- `app/models/` Data models (User, Vendor, Product, Category, Order)
- `app/views/` Layout and pages (home, auth, products, cart, dashboards)
- `app/helpers/` Helper functions (URL, session, flash, auth)
- `config/` App configuration
- `database/` SQL schema and seed data

## Features (MVP)
- Customer login/register, cart, checkout (COD), browse products (filters + AJAX search)
- Vendor registration (approval workflow), vendor dashboard with product add & list
- Admin dashboard with stats and vendor approval
- Smooth animations via AOS, dark mode, responsive Bootstrap 5 UI

## New User Features
- Profile page (update name) at `account/profile`
- Order history at `account/orders`
- Wishlist at `wishlist` (add/remove from product page)
- Reviews: write a review as a customer on product details; star ratings aggregated and filterable on listing (min rating filter)

## SEO & Performance
- Semantic HTML5, meta description/keywords in `app/views/layout/header.php`
- Clean URLs via Apache rewrite
- Optimized assets via CDN, minimal custom JS/CSS

## Configure
- Edit DB credentials in `config/config.php`
- Change site name via `APP_NAME` in `config/config.php`

## Notes
- Payment is simulated (COD + placeholder for online payments)
- Reviews and order tracking stubs are included in the DB, view integrations are planned for phase 2
- Cross-browser: tested on latest Chrome/Edge; Bootstrap ensures broad compatibility

## Roadmap (Phase 2)
- Full Vendor CRUD (edit/delete), image uploads, inventory management
- Admin catalog management (categories, products, users)
- Reviews UI and rating filters
- Real payment gateway integration
- SEO polish (OpenGraph, canonical tags), sitemaps, robots.txt
- Analytics charts powered by real order data
