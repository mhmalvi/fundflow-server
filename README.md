# FundFlow Server

The backend API for FundFlow, a crowdfunding platform that enables users to create, manage, and contribute to fundraising campaigns. Built with Laravel 8 and designed to work alongside the FundFlow Client frontend application.

## Tech Stack

- **PHP** ^7.3 | ^8.0
- **Laravel** ^8.75
- **Laravel Sanctum** for API authentication
- **Laravel UI** for authentication scaffolding
- **Doctrine DBAL** for database migrations
- **Tailwind CSS** for server-rendered views
- **Vite** / Webpack Mix for asset compilation

## Features

- RESTful API for crowdfunding operations
- User authentication and authorization via Sanctum
- Campaign creation and management
- Contribution processing
- Database migrations with DBAL support
- CORS handling for cross-origin requests

## Getting Started

### Prerequisites

- PHP >= 7.3
- Composer
- Node.js & npm
- MySQL or compatible database

### Installation

```bash
# Clone the repository
git clone https://github.com/mhmalvi/fundflow-server.git
cd fundflow-server

# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Run database migrations
php artisan migrate

# Compile assets
npm run dev
```

### Development

```bash
# Start the development server
php artisan serve

# Watch for asset changes
npm run dev
```

### Testing

```bash
php artisan test
```

## Project Structure

```
fundflow-server/
├── app/                # Application logic (Models, Controllers, etc.)
├── bootstrap/          # Framework bootstrap files
├── config/             # Configuration files
├── database/           # Migrations, factories, and seeders
├── public/             # Public assets and entry point
├── resources/          # Views, raw assets, and language files
├── routes/             # Route definitions
├── storage/            # Logs, cache, and compiled files
└── tests/              # Automated tests
```

## Related

- [FundFlow Client](https://github.com/mhmalvi/fundflow-client) — Frontend application

## License

MIT