# Project Summary:
- A simple web-based system to manage monitoring stations and their sensors
- Built using Laravel 10, Livewire, and Tailwind CSS
- Features include add/edit/delete stations & sensors, with status indicators and confirmation modals

--------------------------------------------------------------------------------------------------------

# Built With:
- **Laravel 10** – PHP web framework
- **Livewire** – Laravel full-stack framework for dynamic interfaces
- **Tailwind CSS** – Utility-first CSS framework
- **MySQL** – Relational database management system
- **XAMPP** – Local development environment (Apache, MySQL, PHP)
- **Node.js & NPM** – For frontend asset compilation (Laravel Mix)

--------------------------------------------------------------------------------------------------------

# How to run the project:

1. **Clone the repository**
git clone https://github.com/Fraqla/datanian-tech-test.git
cd your-repo-name (example: cd datanian-tech-test\src\sensor-manager)

2. **Install laravel dependencies**
composer install

3. **Install front-end dependencies**
npm install

4. **Edit .env with your database credentials (if needed)**
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

5. **Generate application key**
php artisan key:generate

6. **Run migration**
php artisan migrate

7. **Compile assets**
npm run dev

8. **Run optimize**
php artisan optimize

9. **Run laravel server**
php artisan serve

10. **Open your browser**
http://127.0.0.1:8000

--------------------------------------------------------------------------------------------------------

# Notes:
- Make sure MySQL is running in XAMPP before you migrate the database.
- You may need to create the database manually using phpMyAdmin or MySQL CLI.
- .env.example is provided — copy it to .env if it's not already present.