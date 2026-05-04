# Bright Future Hub 

Bright Future Hub is an advanced, AI-powered platform designed to bridge the gap between students and global academic/career opportunities. Built as a comprehensive Final Year Project (FYP), it features role-based dashboards, an AI Resume Scorer, an intelligent Career Roadmap generator, and real-time smart notifications.

## Key Features

- **Role-Based Architecture**: Dedicated, secure portals for Students, Organizations, and System Admins.
- **AI-Powered Resume Builder & Scorer**: Students can build professional CVs and get them analyzed by Google Gemini AI against specific opportunities.
- **Smart Career Roadmap**: Generates a step-by-step, personalized career path based on a student's profile.
- **Context-Aware AI Chatbot**: An intelligent assistant capable of understanding platform context and answering career-related queries.
- **Opportunity Matching System**: Automated smart notifications sent to students when a new or modified opportunity matches their skills and interests.
- **Premium UI/UX**: Designed with a "Modern Academic Glassmorphism" aesthetic, providing a highly engaging and responsive experience.

##  Technology Stack

- **Backend Framework**: Laravel 10 (PHP)
- **Frontend**: Blade Templates, Bootstrap 5, Custom Vanilla CSS (Glassmorphism)
- **Database**: MySQL
- **AI Integration**: Google Gemini AI (Pro Model)

##  Installation & Setup Guide

Follow these steps to run the project locally on your machine (e.g., using XAMPP).

### 1. Prerequisites
- PHP >= 8.1
- Composer
- MySQL (XAMPP / WAMP)
- Node.js & NPM (Optional, for frontend assets if required)

### 2. Clone the Repository
```bash
git clone <your-repository-url>
cd bright_future_hub
```

### 3. Install Dependencies
```bash
composer install
```

### 4. Configure Environment
Duplicate the `.env.example` file and rename it to `.env`.
```bash
cp .env.example .env
```
Update the following critical variables in your new `.env` file:
```ini
DB_DATABASE=bright_future_hub
DB_USERNAME=root
DB_PASSWORD=

# Get your API key from Google AI Studio
GEMINI_API_KEY=your_gemini_api_key_here
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Run Migrations & Seed the Database
This command will create all necessary tables and populate them with realistic dummy data for the presentation.
```bash
php artisan migrate:fresh --seed
```

### 7. Link Storage (For Image Uploads)
```bash
php artisan storage:link
```

### 8. Start the Development Server
```bash
php artisan serve
```
Your application will now be running at `http://127.0.0.1:8000`.

##  Default Test Accounts
After running the seeder, you can log in using the following credentials:

- **Admin Account**: `admin@brightfuture.com` | Password: `password`
- **Organization Account**: `org@techuni.com` | Password: `password`
- **Student Account**: `student@example.com` | Password: `password`

##  License
This project is developed as a Final Year Project and is intended for academic purposes.
