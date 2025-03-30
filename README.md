# School Management System API

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)  
![Firebase](https://img.shields.io/badge/Firebase-FFCA28?style=for-the-badge&logo=firebase&logoColor=black)  
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)  

## Table of Contents
- [Features](#features)
- [Installation](#installation)
- [API Documentation](#api-documentation)
- [Development](#development)
- [Project Structure](#project-structure)
- [License](#license)

## Features
- Role-based authentication (Admin/Teacher/Student)
- Class and student management
- Grade tracking system
- Firebase push notifications
- PDF report generation
- RESTful API endpoints

## Installation

- First Fork the Repo 

### 1. Clone the repository
```bash
git clone https://github.com/yourusername/school-management-api.git
cd school-management-api
```

### 2. Install dependencies
```bash
composer install
npm install
```

### 3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Set up database
Edit `.env` file with your database credentials:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=school_management
DB_USERNAME=root
DB_PASSWORD=
```

Then run migrations:
```bash
php artisan migrate --seed
```

### 5. Configure Firebase
- Download service account JSON from Firebase Console  
- Save to: `storage/app/firebase/service-account.json`

## API Documentation

### Authentication
| Method | Endpoint       | Description       |
|--------|----------------|-------------------|
| POST   | `/api/register`| Register new user |
| POST   | `/api/login`   | User login        |
| POST   | `/api/logout`  | User logout       |

### Admin Endpoints
| Method | Endpoint       | Description         |
|--------|----------------|---------------------|
| GET    | `/api/users`   | List all users      |
| POST   | `/api/classes` | Create new class    |

### Teacher Endpoints
| Method | Endpoint                     | Description           |
|--------|------------------------------|-----------------------|
| POST   | `/api/grades`                | Add student grade     |
| GET    | `/api/classes/{id}/students`| View class students   |

### Student Endpoints
| Method | Endpoint                     | Description           |
|--------|------------------------------|-----------------------|
| GET    | `/api/student/grades`        | View my grades        |
| GET    | `/api/student/grades/export` | Export grades as PDF  |

## Development

Start the development server:
```bash
php artisan serve
```

Run tests:
```bash
php artisan test
```

## Project Structure
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   ├── AuthController.php
│   │   │   ├── ClassController.php
│   │   │   ├── GradeController.php
│   │   │   └── NotificationController.php
config/
database/
routes/
├── api.php
storage/
├── app/
│   ├── firebase/      # Firebase configuration
│   └── pdfs/          # Generated PDF reports
```

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.  
