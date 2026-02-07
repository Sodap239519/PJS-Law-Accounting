# PJS Law and Accounting Co., Ltd. - Corporate Website

A professional corporate website built with Laravel 12 for PJS Law and Accounting Co., Ltd., featuring multi-language support (Thai/English), content management system, and modern responsive design.

![Homepage Screenshot](https://github.com/user-attachments/assets/eca86470-5c6c-4c5e-a0bd-43894c1ca4f8)

## Features

### 🌐 Multi-Language Support
- Thai and English language switching
- All content stored in both languages
- Automatic locale detection and switching
- Language switcher in navigation

### 📄 Public Pages
- **Home/About Page** - Company introduction with legal and accounting services
- **Vision Page** - Company vision and mission statement
- **Team Members Page** - Professional team showcase with 4 members
- **News & Activities** - Blog/news system with categories and pagination
- **Case Studies** - Portfolio of successful cases
- **Downloads** - Document library for downloadable files
- **Contact Page** - Contact form with email notifications

### 🔐 Admin Panel
Secure admin panel for content management:
- **Dashboard** - Statistics and quick actions
- **News Management** - Full CRUD for news articles
- **Document Management** - Upload and manage downloadable files
- **Case Studies Management** - Manage portfolio cases
- **Team Members Management** - Update team information and photos
- **Contact Messages** - View and manage contact form submissions

### 🎨 Design
- Professional design with custom color scheme:
  - Dark Blue (#1e3a8a) - Primary color
  - Gold (#c5a647) - Accent color
  - White and Black - Supporting colors
- Fully responsive mobile-first design
- Modern Tailwind CSS styling
- Professional corporate aesthetic

## Technology Stack

- **Framework:** Laravel 12.50.0
- **PHP:** 8.2+
- **Database:** SQLite (easily switchable to MySQL)
- **Frontend:** 
  - Tailwind CSS
  - Laravel Breeze (Authentication)
  - Vite (Asset bundling)
- **Image Processing:** Intervention Image

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and npm
- SQLite (or MySQL)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/Sodap239519/PJS-Law-Accounting.git
   cd PJS-Law-Accounting
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Set up environment file**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   - For SQLite (default):
     ```bash
     touch database/database.sqlite
     ```
   - For MySQL: Update `.env` file with your database credentials

6. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Create storage link**
   ```bash
   php artisan storage:link
   ```

8. **Build frontend assets**
   ```bash
   npm run build
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

10. **Visit the application**
    - Frontend: http://localhost:8000
    - Admin: http://localhost:8000/login

## Default Admin Credentials

- **Email:** admin@pjs-law.com
- **Password:** password

**⚠️ Important:** Change these credentials immediately after first login!

## Database Schema

### Main Tables
- `users` - Admin user accounts with role field
- `team_members` - Team member information (bilingual)
- `news` - News articles with categories and translations
- `documents` - Downloadable files with metadata
- `case_studies` - Portfolio case studies (bilingual)
- `contacts` - Contact form submissions
- `categories` - Categories for news, documents, and cases

## File Storage Structure

```
storage/app/public/
├── news/           # News featured images
├── documents/      # Downloadable PDF/DOC files
├── case-studies/   # Case study images
└── team/           # Team member photos
```

## Multi-Language System

### Language Files
Located in `lang/` directory:
- `lang/en/common.php` - English translations
- `lang/th/common.php` - Thai translations

### Adding Translations
1. Add key-value pairs to both language files
2. Use in views: `__('common.key')` or `@lang('common.key')`

### Switching Languages
Users can switch languages via the language switcher in the navigation menu.

## Admin Panel Usage

### Accessing Admin Panel
1. Navigate to `/login`
2. Enter admin credentials
3. Access dashboard at `/admin/dashboard`

### Managing Content

#### News Articles
1. Go to **Admin → News**
2. Click **Create New** button
3. Fill in both Thai and English content
4. Upload featured image (optional)
5. Select category
6. Set publication status
7. Click **Save**

#### Documents
1. Go to **Admin → Documents**
2. Click **Create New**
3. Fill in document details (Thai/English)
4. Upload file (PDF, DOC, XLS)
5. Select category
6. Click **Save**

#### Case Studies
1. Go to **Admin → Case Studies**
2. Click **Create New**
3. Fill in case details (Challenge, Solution, Result)
4. Upload featured image
5. Click **Save**

#### Team Members
1. Go to **Admin → Team Members**
2. Click **Create New**
3. Fill in member information
4. Upload photo
5. Set display order
6. Click **Save**

#### Contact Messages
- View messages at **Admin → Contacts**
- Click on any message to view details
- Messages are automatically marked as read when viewed

## Email Configuration

### Development (Default)
Emails are logged to `storage/logs/laravel.log`

### Production Setup
Update `.env` file:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=pjs.legal2025@gmail.com
MAIL_FROM_NAME="PJS Law and Accounting"
```

## Company Information

**PJS Law and Accounting Co., Ltd.**
- **Phone:** 092-256-9828
- **Email:** pjs.legal2025@gmail.com
- **Address:** 27/20 ซอยบางบอน4 ซอย4 แขวงบางบอนเหนือ เขตบางบอน กรุงเทพมหานคร 10150
- **Address (EN):** 27/20 Soi Bang Bon 4, Soi 4, Bang Bon Nuea, Bang Bon, Bangkok 10150

## Sample Data

The database seeders include:
- 1 admin user
- 4 team members (President, Legal Expert, Asset Investigation Head, Attorney)
- 5 news articles
- 3 case studies
- 6 categories (for news, documents, and case studies)

## Security Features

- CSRF protection on all forms
- Authentication required for admin panel
- File upload validation
- SQL injection protection via Eloquent ORM
- XSS protection via Blade templating

## Development Commands

```bash
# Run development server
php artisan serve

# Watch and compile assets
npm run dev

# Build for production
npm run build

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Refresh database with seeders
php artisan migrate:fresh --seed
```

## Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter TestName
```

## Troubleshooting

### Images not displaying
```bash
php artisan storage:link
```

### Route not found errors
```bash
php artisan route:clear
php artisan config:clear
```

### Assets not loading
```bash
npm run build
```

## License

This project is proprietary software for PJS Law and Accounting Co., Ltd.

## Support

For technical support or questions:
- Email: pjs.legal2025@gmail.com
- Phone: 092-256-9828

---

Built with ❤️ using Laravel 12
