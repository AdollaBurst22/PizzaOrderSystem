# 🍕 PizzaOrderSystem

A full-featured, Shopping web application built with PHP, Blade, SCSS, CSS, and JavaScript, Bootstrap, Jquery. Easily customize your products, manage orders, and deliver a seamless experience for both customers and staff.

---

## 🚀 Features

-   User-friendly shopping interface
-   Dynamic shopping cards with customizable products and details
-   Secure user authentication and registration
-   Order history and status tracking
-   Responsive design for mobile and desktop
-   Admin dashboard for managing items and orders
-   Real-time order

---

## Screenshots

## Screenshots

### Admin Side

![Admin Product List](public/admin/screenshots/productListA_POS.png)
![Admin Profile](public/admin/screenshots/profileA_POS.png)
![Admin Orders](public/admin/screenshots/orderDetailsA_POS.png)

### User Side

![User Homepage](public/admin/screenshots/userhomePOS.png)
![User Order Page](public/admin/screenshots/productdetailsPOS.png)

## 🛠 Tech Stack

<p align="left">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
  <img src="https://img.shields.io/badge/Blade-563D7C?style=for-the-badge&logo=laravel&logoColor=white" alt="Blade" />
  <img src="https://img.shields.io/badge/SCSS-CC6699?style=for-the-badge&logo=sass&logoColor=white" alt="SCSS" />
  <img src="https://img.shields.io/badge/CSS-1572B6?style=for-the-badge&logo=css3&logoColor=white" alt="CSS" />
  <img src="https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap" />
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript" />
  <img src="https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white" alt="jQuery" />
</p>

| Technology              | Usage         |
| ----------------------- | ------------- |
| PHP/Laravel             | Backend logic |
| Blade                   | Templating    |
| SCSS/CSS/Bootstrap      | Styling       |
| JavaScript/Jquery(AJAX) | Interactivity |

---

## ⚡ Getting Started

### Prerequisites

-   PHP 8.x+
-   Composer
-   Node.js & npm
-   (Optional) MySQL or SQLite for database

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/AdollaBurst22/PizzaOrderSystem.git
cd PizzaOrderSystem

# 2. Install PHP dependencies
composer install

# 3. Install JS/CSS dependencies & compile assets
npm install
npm run dev

# 4. Configure Environment
# Copy .env.example to .env and update your database and mail credentials

# 5. Run database migrations
php artisan migrate

# 6. Serve the application
php artisan serve

PizzaOrderSystem/
├── app/                # Backend logic (controllers, models)
├── resources/
│   ├── views/          # Blade templates
│   └── scss/           # SCSS source files
├── public/             # Public assets (CSS, JS, images)
├── routes/             # Web routes
├── database/           # Migrations, seeders
├── package.json
├── composer.json
└── ...
```
