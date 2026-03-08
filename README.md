# AW&H Employee Management System

A web application for employees to view and manage their salary information, built with PHP and MySQL.

## Features
- User registration (stores employee details)
- Login using EIN (Employee Identification Number) – demo only, no password hashing
- Personal dashboard showing all stored fields
- Update your own information
- Built‑in and custom queries (e.g., show BAN, net pay)
- Email functionality using PHPMailer (send salary details to any email)

## Technologies Used
- **Backend**: PHP 8, MySQL
- **Frontend**: HTML, CSS
- **Libraries**: PHPMailer
- **Server**: XAMPP (Apache + MySQL)

## Prerequisites
- [XAMPP](https://www.apachefriends.org/) installed (or any local PHP/MySQL server)
- A Gmail account with 2‑factor authentication enabled (for app password)

## Installation

1. **Clone or download** this repository into your XAMPP `htdocs` folder:
C:\xampp\htdocs\Group5MajorProjectITT307

2. **Start Apache and MySQL** from the XAMPP Control Panel.

3. **Create the database**:
- Open phpMyAdmin: `http://localhost/phpmyadmin`
- Create a database named `AWH_salaries`
- Import the provided SQL file: `Internet Authoring II Major Project Group 5.sql` (or run the SQL below to create the `employees` table):
  ```sql
  CREATE TABLE employees (
      EIN VARCHAR(20) PRIMARY KEY,
      name VARCHAR(100),
      qualification VARCHAR(100),
      salary DECIMAL(10,2),
      deductions DECIMAL(10,2),
      TRN VARCHAR(50),
      bank_branch VARCHAR(50),
      BAN VARCHAR(50)
  );

4. **Insert a sample employee (optional)**:
   ```sql
   INSERT INTO employees VALUES ('12345', 'Jackson', 'MSc. Deg.', 175000.00, 44785.90, '123-456', '12', '12-01');


5. **Configure database connection**:
   - Open `connection.php` and set your MySQL credentials (default XAMPP: username `root`, password empty).

6. **Configure email settings**:
   - Open `settings.php` and enter your Gmail address and **app password**.
   - **How to get a Gmail app password**:
     1. Enable **2‑factor authentication** on your Google account.
     2. Go to [App Passwords](https://myaccount.google.com/apppasswords).
     3. Generate a password for **Mail** and copy the 16‑character code.
     4. Paste it into `settings.php` as the value for `PASSWORD`.

7. **Access the application**:
   - Home page: [http://localhost/Group5MajorProjectITT307/home.html](http://localhost/Group5MajorProjectITT307/home.html)
   - Register a new employee: [http://localhost/Group5MajorProjectITT307/register.php](http://localhost/Group5MajorProjectITT307/register.php)
   - Login with any registered **EIN** (use the EIN as the password).

## File Structure
```
C:\xampp\htdocs\Group5MajorProjectITT307
│   Built-in Queries.php
│   connection.php
│   Custom Queries.php
│   Dashboard.php
│   DBbackground.jpeg
│   DBlogo.png
│   delete.php
│   Email Functionality.php
│   home.html
│   homebg.png
│   Internet Authoring II Major Project Group 5.sql
│   login.php
│   loginbg.jpg
│   logout.php
│   Menu.html
│   register.php
│   registerbg.png
│   settings.php
│   updateprocess.php
│
└───PHPMailer          # Third-party library for sending emails
    ├───language       # Localisation files
    └───src             # Core PHP classes
```

## Screenshots

Here are the key screens of the application in the order a user would typically encounter them:

1. **Registration Page**  
<img width="1910" height="1146" alt="Image" src="https://github.com/user-attachments/assets/9365d14f-c1b2-4379-92d6-1dbe2cea568a" />

   *New employees can register by providing their EIN, name, qualification, salary, deductions, TRN, bank branch, and BAN.*

2. **Login Page**  
<img width="1910" height="915" alt="Image" src="https://github.com/user-attachments/assets/67833d71-1620-4a70-b811-44a49b00f041" />

   *Users log in using their name, EIN (as password), and the database name (`AWH_salaries`).*

3. **Login Success Message**  
![Image](https://github.com/user-attachments/assets/da7c64e2-56eb-4228-92f0-3d668ebc8d64)
   *After successful login, a confirmation message appears before redirecting to the dashboard.*

4. **Dashboard**  
![Image](https://github.com/user-attachments/assets/d178a983-31ff-44c3-9de5-998337567496)
   *The dashboard displays all stored information for the logged‑in employee, with a navigation menu for queries and email.*

5. **Custom Queries Page**  
 ![Image](https://github.com/user-attachments/assets/5f6632a4-817f-4a1c-a826-81956243cc9b)
   *Users can select specific fields to view (e.g., salary, deductions) and execute a custom query.*

6. **Update Information Page**  
<img width="1910" height="1229" alt="Image" src="https://github.com/user-attachments/assets/61afddee-897b-4207-9f91-a94ba1f67345" />
   *Employees can update their own details; the EIN is read‑only.*

7. **Delete Employee Record**  
![Image](https://github.com/user-attachments/assets/64011b0a-7918-4440-a44b-7a5d0a492e2b)
   *A user can delete their own record by entering their EIN.*

8. **Email Form (Empty)**  
<img width="1901" height="815" alt="Image" src="https://github.com/user-attachments/assets/4a06b411-4997-48dd-8caf-bf7b9dee2a3c" />
   *The email interface allows sending salary details to any address.*

9. **Email Form (Filled Example)**  
![Image](https://github.com/user-attachments/assets/f79bfb0b-8d1d-4133-a402-3ef3e3d68d02)
   *Example with EIN `P23`, subject “This is a test”, and a custom message.*

10. **Email Sent Successfully**  
![Image](https://github.com/user-attachments/assets/a12872b2-2b45-4545-abda-197c3eef4aea)
    *Confirmation message after the email is sent.*

11. **Received Email**  
![Image](https://github.com/user-attachments/assets/709e9cde-f1a0-4876-9c84-222e7ae741f3)
    *The actual email received, showing employee details followed by the custom message.*
