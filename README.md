# 🏠 EasyColoc

**EasyColoc** is a specialized expense-management platform built with **PHP/Laravel**. It solves the "roommate math" problem by automating debt calculations and ensuring financial accountability through a custom **Global Reputation System**.

---

## 🌟 Key Features

### 💰 Automated Financial Logic
* **Real-Time Split:** Automatically divides expenses among group members using Laravel Eloquent relationships.
* **Debt Inheritance:** A safety feature where Owners inherit the debt of "kicked" members to protect the original payer's balance.
* **Monthly Filtering:** Advanced SQL filtering to view expenses by specific months and categories.

### 🛡️ Social Accountability
* **Reputation System:** Users are assigned a dynamic score. Leaving a group with unpaid debts triggers an automatic reputation penalty.
* **Admin Dashboard:** High-level oversight of platform volume, user management, and the ability to ban users for malicious behavior.

### 📧 Communication
* **Mailtrap Integration:** Secure SMTP-based invitation system allowing owners to invite new members via email.

---

## 🏗️ Technical Architecture

### MVC Pattern
The project strictly follows the **Model-View-Controller** architecture to ensure a separation of concerns:
* **Models:** Handle data integrity and complex business logic (e.g., balance calculations).
* **Views:** Clean UI built with **Blade** templates and styled with **Tailwind CSS**.
* **Controllers:** Act as mediators, keeping the logic flow predictable and easy to debug.

### 🧩 OOP & SOLID Principles
* **Single Responsibility:** Logic is delegated to dedicated classes (e.g., Mailable classes for emails).
* **Encapsulation:** Sensitive data and logic are protected within Eloquent models.
* **Dependency Inversion:** Use of Laravel Facades to remain agnostic of low-level mail/database implementations.

---

## 📊 Visual Documentation

### Class Diagram & UML
Refer to the documentation folder for full architectural diagrams.
> **Note:** Diagram images are located in `/public/docs/diagrams/`

### Database Schema
A relational schema optimized with **Pivot Tables** (Many-to-Many) connecting Users and Colocations.

## 📅 Project Management
The development of this project was managed using Trello. You can view the task breakdown and sprint progress here:
[View Trello Board](https://trello.com/b/KcSOuDRi/easycoloc)

---

## 🚀 Installation & Setup

1. **Clone the Repo:**
   ```bash
   git clone [https://github.com/mohammed-mehdi-saibat/easycoloc.git](https://github.com/mohammed-mehdi-saibat/easycoloc.git)

    Install Dependencies:
    Bash

    composer install && npm install

    Environment Setup:

        Copy .env.example to .env

        Configure your Database and Mailtrap credentials.

    Database Migration & Seeding:
    Bash

    php artisan migrate:fresh --seed

    Start Development Server:
    Bash

    php artisan serve

🧪 Demonstration Scenarios (Soutenance)

    The Auditor: Log in as admin@easycoloc.com to view global platform statistics.

    The Roommate: Create a shared expense and watch balances update for all members in real-time.

    The Penalty: Demonstrate the reputation drop by having a user leave a group while owing money.

    The Safety Net: Show how the system transfers debt to an owner when a debtor is removed.

Author: Mohammed Mehdi Saibat

Institution: YouCode (OCP/Simplon)

Technologies: Laravel 11, MySQL, Tailwind CSS, Mailtrap