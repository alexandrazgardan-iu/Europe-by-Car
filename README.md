# Europe by Car

**A Web-Based Car Rental E-Commerce Application**

## Project Overview

Europe by Car is a fictional car rental platform developed as an e-commerce web application. It simulates the online car rental process, allowing users to browse available vehicles, view vehicle details, add vehicles to a shopping cart, enter rental information, and receive a booking confirmation.

The application was developed as an academic project for the IU Web Programming course.

## Main Features

- Vehicle catalogue with vehicle information
- Search and filtering by brand, model, category, and fuel type
- Individual vehicle detail pages
- Shopping cart managed using PHP sessions
- AJAX functionality for adding vehicles to the cart
- Checkout form for customer and rental information
- Server-side booking and price calculation
- Booking confirmation page
- MySQL database for vehicle and booking data

## Technologies Used

- HTML5
- CSS3
- Bootstrap
- JavaScript
- PHP
- AJAX
- MySQL

## Project Structure

```text
EuropebyCar/
├── frontend/
│   ├── catalog.php
│   ├── vehicle_details.php
│   ├── add_to_cart.php
│   ├── shopping_cart.php
│   ├── checkout.php
│   ├── place_order.php
│   ├── order_confirmation.php
│   ├── clear_cart.php
│   └── header.php
├── backend/
│   ├── db.php
│   └── test_connection.php
├── database/
│   └── schema.sql
├── docs/
│   ├── Europe_by_Car_ERD.png
│   ├── Vehicle_Catalog_Wireframe.png
│   ├── Vehicle_Details_Wireframe.png
│   ├── Shopping_Cart_Wireframe.png
│   └── Booking_Confirmation_Wireframe.png
├── assets/
│   └── Vehicle images
├── index.php
└── README.md
```

## Installation and Setup

### Requirements

- XAMPP with Apache and MySQL
- A modern web browser
- Git (optional)

### Setup Instructions

1. Copy or clone the project into `C:\xampp\htdocs\EuropebyCar`.
2. Start Apache and MySQL in the XAMPP Control Panel.
3. Open phpMyAdmin at `http://localhost/phpmyadmin`.
4. Import `database/schema.sql` using the Import tab.
5. Confirm that the database is named `europebycar`.
6. Open the application at:

   `http://localhost/EuropebyCar/frontend/catalog.php`

### Database Configuration

The database connection is configured in `backend/db.php`.

Default local XAMPP settings:

- Host: `localhost`
- Database: `europebycar`
- Username: `root`
- Password: empty (default local configuration)

If your MySQL credentials are different, update `backend/db.php` accordingly.

## Documentation

The `docs/` directory contains the Entity-Relationship Diagram (ERD) and wireframes illustrating the main pages of the application.

## Project Limitations

- User registration and login are not implemented.
- Real payment processing is not implemented.
- Bookings are simulated for demonstration purposes.