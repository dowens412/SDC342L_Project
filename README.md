# Project Name: Customer Complaint Management System

## Project Description

Customer Complaint Management System is a PHP and MySQL web application designed to help customers submit complaints, allow administrators to assign complaints to technicians, and allow technicians to update and resolve assigned complaints. The application includes authentication, role-based authorization, database support using PHP model classes, image upload support, and activity logging.

The system supports three main user roles: customers, technicians, and administrators. Customers can log in, submit complaints, upload images related to the issue, and view complaint status and resolution notes. Administrators can view complaint information, view technician workloads, and assign unassigned complaints to technicians. Technicians can view assigned complaints, add technician notes, and mark complaints as resolved with resolution notes.

## Project Tasks

* **Task 1: Plan the application**

  * Review project requirements
  * Design the database structure
  * Plan customer, technician, and administrator workflows
  * Create the project plan

* **Task 2: Create the database**

  * Create a MySQL database named `complaint_system`
  * Create related tables for customers, employees, products/services, complaint types, complaints, and complaint notes
  * Add primary keys and foreign key relationships
  * Insert starter data for products/services, complaint types, customers, technicians, and administrators

* **Task 3: Build the PHP application framework**

  * Create the project folder structure
  * Add reusable header and footer files
  * Add CSS styling
  * Create a database connection file
  * Confirm the PHP application can connect to the MySQL database

* **Task 4: Represent the database using PHP objects**

  * Create model classes for customers, employees, products/services, complaint types, complaints, and complaint notes
  * Add CRUD-style methods for reading, creating, updating, and deleting records
  * Update the homepage to display data using model classes

* **Task 5: Implement authentication and authorization**

  * Create login and logout functionality
  * Add session management
  * Verify passwords using password hashing
  * Create protected dashboards for customers, technicians, and administrators
  * Restrict pages based on user role

* **Task 6: Add complaint management features**

  * Allow customers to create complaints
  * Allow customers to upload images with complaints
  * Allow administrators to assign complaints to technicians
  * Allow technicians to add notes and resolve complaints
  * Allow customers to view complaint status and resolution notes

* **Task 7: Add file support**

  * Store uploaded complaint images in the uploads folder
  * Save image paths in the database
  * Add text-file activity logging for complaint creation, assignment, and resolution

* **Task 8: Test the application**

  * Test customer login and complaint creation
  * Test image upload support
  * Test administrator complaint assignment
  * Test technician complaint updates and resolution
  * Test role-based authorization
  * Test logout and protected page access

* **Task 9: Finalize the project**

  * Push final code to GitHub
  * Create final GitHub tag
  * Complete final project plan
  * Complete testing document
  * Complete retrospective document
  * Add screen recording link

## Project Features

* Customer login using email and password
* Employee login using user ID and password
* Role-based dashboards for customers, technicians, and administrators
* Customer complaint submission
* Product/service selection for complaints
* Complaint type selection
* Complaint description entry
* Image upload for complaints
* Customer complaint history
* Complaint status display
* Resolution notes display
* Technician assigned complaint list
* Technician note entry
* Technician complaint resolution
* Administrator view of open complaints
* Administrator view of unassigned complaints
* Administrator technician workload counts
* Administrator complaint assignment
* Activity log text file support
* MySQL relational database backend
* PHP model classes for database support

## Project Skills Learned

* PHP server-side development
* MySQL database design
* phpMyAdmin database management
* Database relationships with primary keys and foreign keys
* PDO database connection in PHP
* CRUD-style database methods
* MVC-style organization using PHP model classes
* User authentication
* Role-based authorization
* PHP session management
* Password hashing and verification
* File upload handling
* Text-file logging
* Git and GitHub version control
* Project planning and weekly status tracking
* Application testing and debugging

## Languages and Technologies Used

* **PHP**: Server-side application logic
* **MySQL**: Database backend
* **HTML**: Page structure
* **CSS**: Application styling
* **SQL**: Database creation, relationships, and seed data
* **phpMyAdmin**: Database management
* **MAMP/XAMPP local server environment**: Local development and testing
* **Git and GitHub**: Version control and project submission

## Development Process Used

* **Iterative Development Process**: The project was developed in weekly phases. Each week focused on a different part of the application, starting with planning, then database setup, PHP object support, security, file handling, and final testing.

## Local Setup Instructions

1. Start the local server environment.
2. Open phpMyAdmin.
3. Create or import the `complaint_system` database.
4. Import the provided `complaint_system.sql` file.
5. Place the project folder inside the local server `htdocs` folder.
6. Confirm the database connection settings in:

```php
config/database.php
```

7. Open the application in the browser:

```text
http://localhost:8888/sdc342l_project/login.php
```

Depending on the local server setup, the port may need to be adjusted.

## Test Login Accounts

### Customer Login

```text
Account Type: Customer
Email/User ID: customer1@example.com
Password: Password123!
```

```text
Account Type: Customer
Email/User ID: customer2@example.com
Password: Password123!
```

### Technician Login

```text
Account Type: Employee
Email/User ID: tech01
Password: Password123!
```

```text
Account Type: Employee
Email/User ID: tech02
Password: Password123!
```

### Administrator Login

```text
Account Type: Employee
Email/User ID: admin01
Password: Password123!
```

## Screen Recording

A screen recording demonstration of the project is available here:

```text
Add YouTube link here
```

## Link to Project

[Customer Complaint Management System Repository](https://github.com/dowens412/SDC342L_Project)

## Final GitHub Tag

[Final Project Tag](https://github.com/dowens412/SDC342L_Project/releases/tag/Final)

## Project Summary

The Customer Complaint Management System is a complete PHP and MySQL web application that supports customer complaint submission, administrator complaint assignment, and technician complaint resolution. The project includes a relational database, PHP model classes, authentication, role-based authorization, image upload support, and text-file activity logging. This project helped demonstrate how to build a server-side application with database support, secure user access, and multiple user workflows.
