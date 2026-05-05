# Portfolio Builder SaaS

A modern SaaS platform that enables developers and professionals to create, manage, and showcase their professional portfolios with zero setup. Build structured portfolios and enhance them with an AI-powered assistant.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php)
![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-3.x-38b2ac?style=flat-square&logo=tailwind-css)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

## Features

### Portfolio Management
- **Profile Management** - Title, bio, avatar upload, email privacy control
- **Skills** - Name, proficiency level, category with soft-delete support
- **Work Experience** - Company, role, duration, description
- **Education** - Institute, degree, graduation year
- **Projects** - Title, description, project link, image upload
- **Social Links** - Platform and URL management

### Public Portfolio Pages
- SEO-friendly URLs using unique slugs (e.g., `/john-doe`)
- Automatic username and slug generation
- Responsive design with Tailwind CSS
- Open Graph meta tags for social sharing
- Stats display (skills count, projects count, etc.)

### AI Chatbot Assistant
- OpenAI-powered chatbot on public portfolio pages
- Answers visitor questions about the portfolio owner
- Context-aware responses based on portfolio data

### Admin Panel
- User management with role assignment
- Platform statistics (total users, portfolios, projects)
- Protected by Admin role middleware (Spatie)

### API & Performance
- RESTful API for portfolio data access
- Cached responses for performance (1-hour cache)
- JSON resources for structured data delivery

## Tech Stack

**Backend:**
- PHP 8.2+
- Laravel 12.x
- Laravel Breeze (Authentication)
- Spatie Laravel Permission (Role management)
- OpenAI PHP Client (AI integration)

**Frontend:**
- Tailwind CSS 3.x
- Alpine.js 3.x
- Vite 7.x
- Axios

**Database:**
- SQLite (default for development)
- MySQL/PostgreSQL supported

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and npm

### Quick Setup

```bash
composer run setup
```

This command will install dependencies, create `.env`, generate app key, run migrations, and build assets.

### Manual Setup

1. **Install PHP dependencies:**
   ```bash
   composer install
   ```

2. **Set up environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configure database:**
   - Default uses SQLite
   ```bash
   touch database/database.sqlite
   ```
   - Or configure MySQL/PostgreSQL in `.env`

4. **Run migrations:**
   ```bash
   php artisan migrate
   ```

5. **Install Node.js dependencies:**
   ```bash
   npm install
   ```

6. **Build frontend assets:**
   ```bash
   npm run build
   ```

7. **Start the development server:**
   ```bash
   npm run dev:serve
   ```
   This runs both Laravel server and Vite dev server concurrently.

## Configuration

### AI Chatbot Setup

Add your OpenAI API key to `.env`:

```env
OPENAI_API_KEY=your_openai_api_key_here
```

### File Storage

Create symbolic link for file uploads:

```bash
php artisan storage:link
```

## Usage

1. Register a new account at `/register`
2. Complete your profile at `/dashboard`
3. Add your skills, experience, education, and projects
4. Your public portfolio will be available at `/{your-username}`
5. Visitors can interact with your AI assistant on your public page

### Admin Access

Assign admin role to a user:

```bash
php artisan tinker
$user = App\Models\User::find(1);
$user->assignRole('admin');
```

Access admin panel at `/admin`

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/portfolio/{slug}` | Get full portfolio data |
| GET | `/api/portfolio/{slug}/profile` | Get profile information |
| GET | `/api/portfolio/{slug}/skills` | Get skills list |
| GET | `/api/portfolio/{slug}/experience` | Get work experience |
| GET | `/api/portfolio/{slug}/education` | Get education history |
| GET | `/api/portfolio/{slug}/projects` | Get projects list |
| GET | `/api/portfolio/{slug}/social-links` | Get social links |

All API responses are cached for 1 hour.

## Project Structure

```
app/
├── Http/Controllers/     # Controllers (Auth, Portfolio, Admin, Chatbot)
├── Models/               # Eloquent models with relationships
├── Policies/             # Authorization policies
└── Resources/            # API resources
resources/
├── views/
│   ├── dashboard/        # Portfolio management pages
│   ├── profile/          # Profile editing
│   ├── admin/            # Admin panel
│   └── components/       # Reusable Blade components (chatbot)
├── css/                  # Tailwind styles
└── js/                   # Alpine.js components
```

## Testing

Run tests with Pest PHP:

```bash
php artisan test
```

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).
