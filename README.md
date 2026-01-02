# ComPro Laravel Project

Sebuah company profile website yang dibangun menggunakan Laravel 12 dengan template modern dan responsive.

## 📋 Prerequisites
- **PHP** >= 8.2
- **Node.js** >= 20.19.1

## 🚀 Installation & Setup

### 1. Clone Repository
```bash
git clone https://github.com/adrianeka/ComPro.git
cd ComPro
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies  
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration
Edit file `.env` dan sesuaikan database settings:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Database Migration & Seeding
```bash
# Create database tables
php artisan migrate

# Seed database dengan data sample (opsional)
php artisan db:seed
```

### 6. Build Assets
```bash
# Untuk development
npm run dev

# Untuk production
npm run build
```

### 7. Run Application
```bash
# Start Laravel development server
php artisan serve
```

## � Docker Development Setup

This project includes a Docker configuration for easy development setup with MySQL and phpMyAdmin.

### 1. Prerequisites
- Docker & Docker Compose installed

### 2. Setup Environment
Ensure your `.env` file has the following database configuration:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_compro
DB_USERNAME=laravel
DB_PASSWORD=secret
```

### 3. Start Database Services
Run the following command to start MySQL and phpMyAdmin containers:

```bash
docker compose up -d
```

### 4. Application Access
- **Laravel App**: Run locally with `php artisan serve` (http://127.0.0.1:8000)
- **phpMyAdmin**: http://localhost:8081
  - Username: `laravel`
  - Password: `secret`

### 5. Troubleshooting
If you encounter permission issues connecting to the database, try resetting the volume:

```bash
docker compose down -v
docker compose up -d
```

## �📁 Project Structure

```
ComPro/
├── app/               # Laravel application logic
├── resources/
│   ├── css/          # Stylesheets
│   ├── js/           # JavaScript files
│   └── views/        
