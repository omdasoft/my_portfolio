## Table of Contents
1. [General Information](#general-information)
2. [Technologies Used](#technologies-used)
3. [Project Status](#project-status)
4. [Installation Guide](#installation-guide)

---

## General Information
My personal website.

---

## Technologies Used
The project is built with the following technologies:
- **Laravel 12**
- **Livewire 3**
- **Tailwind CSS**
- **MySql Database**
---

## Project Status
**Current Status:** In progress

---

## Installation Guide
Follow these steps to set up the project locally:

1. Clone the repository:
   ```bash
   git clone <repository-url>
   ```

2. Navigate to the project directory:
   ```bash
   cd <project-directory>
   ```

3. Copy the example environment file:
   ```bash
   cp .env.example .env
   ```
   
4. Install PHP dependencies:
   ```bash
   composer install

5. Generate the application key:
   ```bash
   php artisan key:generate
   ```
   
7. Run the database migrations and seed data:
   ```bash
   php artisan migrate:fresh --seed
   ```
8. Run npm:
   ```bash
   npm run dev
   ```

---
