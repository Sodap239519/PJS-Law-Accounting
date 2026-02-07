# Database Schema Documentation

## Overview
This document describes the database schema for the PJS Law and Accounting corporate website.

## Tables

### users
Stores admin user accounts for accessing the admin panel.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | User ID |
| name | varchar(255) | NOT NULL | User's full name |
| email | varchar(255) | NOT NULL, UNIQUE | User's email address |
| email_verified_at | timestamp | NULLABLE | Email verification timestamp |
| password | varchar(255) | NOT NULL | Hashed password |
| role | varchar(255) | DEFAULT 'admin' | User role |
| remember_token | varchar(100) | NULLABLE | Remember me token |
| created_at | timestamp | NULLABLE | Record creation time |
| updated_at | timestamp | NULLABLE | Record update time |

**Indexes:**
- PRIMARY KEY (id)
- UNIQUE (email)

---

### categories
Stores categories for organizing news, documents, and case studies.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Category ID |
| name_th | varchar(255) | NOT NULL | Category name in Thai |
| name_en | varchar(255) | NOT NULL | Category name in English |
| slug | varchar(255) | NOT NULL | URL-friendly identifier |
| type | varchar(255) | NOT NULL | Type: 'news', 'document', 'case_study' |
| description_th | text | NULLABLE | Description in Thai |
| description_en | text | NULLABLE | Description in English |
| is_active | boolean | DEFAULT true | Active status |
| created_at | timestamp | NULLABLE | Record creation time |
| updated_at | timestamp | NULLABLE | Record update time |

**Indexes:**
- PRIMARY KEY (id)

**Sample Values:**
- Type: 'news', 'document', 'case_study'

---

### team_members
Stores information about team members displayed on the website.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Member ID |
| name_th | varchar(255) | NOT NULL | Name in Thai |
| name_en | varchar(255) | NOT NULL | Name in English |
| position_th | varchar(255) | NOT NULL | Position in Thai |
| position_en | varchar(255) | NOT NULL | Position in English |
| bio_th | text | NULLABLE | Biography in Thai |
| bio_en | text | NULLABLE | Biography in English |
| photo | varchar(255) | NULLABLE | Photo file path |
| order | integer | DEFAULT 0 | Display order |
| is_active | boolean | DEFAULT true | Active status |
| created_at | timestamp | NULLABLE | Record creation time |
| updated_at | timestamp | NULLABLE | Record update time |

**Indexes:**
- PRIMARY KEY (id)

**Notes:**
- Photos stored in `storage/app/public/team/`
- Lower order value = higher display priority

---

### news
Stores news articles and blog posts with bilingual content.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | News ID |
| title_th | varchar(255) | NOT NULL | Title in Thai |
| title_en | varchar(255) | NOT NULL | Title in English |
| slug | varchar(255) | NOT NULL | URL-friendly identifier |
| excerpt_th | text | NULLABLE | Short excerpt in Thai |
| excerpt_en | text | NULLABLE | Short excerpt in English |
| content_th | longtext | NOT NULL | Full content in Thai |
| content_en | longtext | NOT NULL | Full content in English |
| featured_image | varchar(255) | NULLABLE | Featured image path |
| category_id | bigint | NULLABLE, FOREIGN KEY | Reference to categories |
| is_published | boolean | DEFAULT false | Publication status |
| published_at | timestamp | NULLABLE | Publication date |
| views | integer | DEFAULT 0 | View count |
| created_at | timestamp | NULLABLE | Record creation time |
| updated_at | timestamp | NULLABLE | Record update time |

**Indexes:**
- PRIMARY KEY (id)
- FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL

**Notes:**
- Images stored in `storage/app/public/news/`
- Slug must be unique

---

### documents
Stores downloadable files with metadata.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Document ID |
| title_th | varchar(255) | NOT NULL | Title in Thai |
| title_en | varchar(255) | NOT NULL | Title in English |
| description_th | text | NULLABLE | Description in Thai |
| description_en | text | NULLABLE | Description in English |
| file_path | varchar(255) | NOT NULL | File storage path |
| file_name | varchar(255) | NOT NULL | Original file name |
| file_size | integer | NOT NULL | File size in bytes |
| category_id | bigint | NULLABLE, FOREIGN KEY | Reference to categories |
| downloads | integer | DEFAULT 0 | Download count |
| is_active | boolean | DEFAULT true | Active status |
| created_at | timestamp | NULLABLE | Record creation time |
| updated_at | timestamp | NULLABLE | Record update time |

**Indexes:**
- PRIMARY KEY (id)
- FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL

**Notes:**
- Files stored in `storage/app/public/documents/`
- Accepted file types: PDF, DOC, DOCX, XLS, XLSX

---

### case_studies
Stores portfolio case studies with bilingual content.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Case study ID |
| title_th | varchar(255) | NOT NULL | Title in Thai |
| title_en | varchar(255) | NOT NULL | Title in English |
| slug | varchar(255) | NOT NULL | URL-friendly identifier |
| client_name | varchar(255) | NULLABLE | Client name (can be "Confidential") |
| challenge_th | text | NULLABLE | Challenge description in Thai |
| challenge_en | text | NULLABLE | Challenge description in English |
| solution_th | text | NULLABLE | Solution description in Thai |
| solution_en | text | NULLABLE | Solution description in English |
| result_th | text | NULLABLE | Result description in Thai |
| result_en | text | NULLABLE | Result description in English |
| featured_image | varchar(255) | NULLABLE | Featured image path |
| gallery | json | NULLABLE | Array of gallery images |
| category_id | bigint | NULLABLE, FOREIGN KEY | Reference to categories |
| is_published | boolean | DEFAULT false | Publication status |
| views | integer | DEFAULT 0 | View count |
| created_at | timestamp | NULLABLE | Record creation time |
| updated_at | timestamp | NULLABLE | Record update time |

**Indexes:**
- PRIMARY KEY (id)
- FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL

**Notes:**
- Images stored in `storage/app/public/case-studies/`
- Gallery field stores JSON array of image paths
- Slug must be unique

---

### contacts
Stores contact form submissions from website visitors.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Contact ID |
| name | varchar(255) | NOT NULL | Sender's name |
| phone | varchar(255) | NOT NULL | Sender's phone number |
| subject | varchar(255) | NOT NULL | Message subject |
| details | text | NOT NULL | Full message content |
| email | varchar(255) | NULLABLE | Sender's email (optional) |
| is_read | boolean | DEFAULT false | Read status |
| read_at | timestamp | NULLABLE | When message was read |
| created_at | timestamp | NULLABLE | Submission time |
| updated_at | timestamp | NULLABLE | Record update time |

**Indexes:**
- PRIMARY KEY (id)

**Notes:**
- Email notifications sent to: pjs.legal2025@gmail.com
- Messages marked as read when viewed in admin panel

---

### cache
Laravel cache storage (standard Laravel table).

---

### jobs
Laravel job queue storage (standard Laravel table).

---

### sessions
User session storage (standard Laravel table).

---

## Relationships

### One-to-Many Relationships

1. **categories → news**
   - One category can have many news articles
   - Foreign Key: news.category_id → categories.id
   - On Delete: SET NULL

2. **categories → documents**
   - One category can have many documents
   - Foreign Key: documents.category_id → categories.id
   - On Delete: SET NULL

3. **categories → case_studies**
   - One category can have many case studies
   - Foreign Key: case_studies.category_id → categories.id
   - On Delete: SET NULL

## Data Types by Language

### Bilingual Fields
All content tables support both Thai and English with these field patterns:
- `*_th` - Thai language content
- `*_en` - English language content

### Displaying Content
Use Laravel's localization system to display appropriate content:
```php
$locale = app()->getLocale(); // 'th' or 'en'
$title = $news->{"title_" . $locale};
```

## File Storage

All uploaded files are stored in `storage/app/public/` with symbolic link to `public/storage/`:

- **News Images**: `storage/app/public/news/`
- **Documents**: `storage/app/public/documents/`
- **Case Studies**: `storage/app/public/case-studies/`
- **Team Photos**: `storage/app/public/team/`

Access via: `storage/{type}/{filename}`

## Indexes and Performance

### Recommended Indexes (if using MySQL)
```sql
-- News table
CREATE INDEX idx_news_slug ON news(slug);
CREATE INDEX idx_news_published ON news(is_published, published_at);
CREATE INDEX idx_news_category ON news(category_id);

-- Documents table
CREATE INDEX idx_documents_active ON documents(is_active);
CREATE INDEX idx_documents_category ON documents(category_id);

-- Case Studies table
CREATE INDEX idx_cases_slug ON case_studies(slug);
CREATE INDEX idx_cases_published ON case_studies(is_published);
CREATE INDEX idx_cases_category ON case_studies(category_id);
```

## Migration Files

Migrations are located in `database/migrations/` directory:
- `0001_01_01_000000_create_users_table.php`
- `2026_02_07_074003_create_categories_table.php`
- `2026_02_07_074004_add_role_to_users_table.php`
- `2026_02_07_074004_create_case_studies_table.php`
- `2026_02_07_074004_create_contacts_table.php`
- `2026_02_07_074004_create_documents_table.php`
- `2026_02_07_074004_create_news_table.php`
- `2026_02_07_074004_create_team_members_table.php`

---

Last Updated: February 2026
