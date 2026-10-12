
CREATE DATABASE IF NOT EXISTS europebycar
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE europebycar;

CREATE TABLE IF NOT EXISTS vehicles (
    vehicle_id INT AUTO_INCREMENT PRIMARY KEY,
    brand VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    category VARCHAR(50) NOT NULL,
    price_per_day DECIMAL(10,2) NOT NULL,
    fuel_type VARCHAR(30),
    transmission VARCHAR(30),
    seats INT,
    doors INT,
    image VARCHAR(255),
    description TEXT
);

CREATE TABLE IF NOT EXISTS bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    pickup_location VARCHAR(100) NOT NULL,
    return_location VARCHAR(100) NOT NULL,
    pickup_date DATE NOT NULL,
    return_date DATE NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status VARCHAR(30) DEFAULT 'confirmed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS booking_items (
    booking_item_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    vehicle_id INT NOT NULL,
    price_per_day DECIMAL(10,2) NOT NULL,
    number_of_days INT NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (booking_id)
        REFERENCES bookings(booking_id),
    FOREIGN KEY (vehicle_id)
        REFERENCES vehicles(vehicle_id)
);

INSERT INTO vehicles
    (brand, model, category, price_per_day, fuel_type,
     transmission, seats, doors, image, description)
SELECT 'Volkswagen', 'T-Cross', 'Subcompact', 55.00,
       'Petrol', 'Automatic', 5, 5, 't-cross.jpg',
       'A subcompact car for everyday city rides and long-distance adventures.'
WHERE NOT EXISTS (
    SELECT 1 FROM vehicles
    WHERE brand = 'Volkswagen' AND model = 'T-Cross'
);

INSERT INTO vehicles
    (brand, model, category, price_per_day, fuel_type,
     transmission, seats, doors, image, description)
SELECT 'Porsche', 'Taycan', 'Full-size', 200.00,
       'Battery electric', 'Automatic', 4, 4, 'porschetaycan.jpg',
       'Luxury electric car suitable for longer journeys.'
WHERE NOT EXISTS (
    SELECT 1 FROM vehicles
    WHERE brand = 'Porsche' AND model = 'Taycan'
);

INSERT INTO vehicles
    (brand, model, category, price_per_day, fuel_type,
     transmission, seats, doors, image, description)
SELECT 'Audi', 'Q5', 'SUV', 95.00,
       'Petrol', 'Automatic', 5, 5, 'audiq5.jpg',
       'A spacious SUV offering comfort and practicality at every km.'
WHERE NOT EXISTS (
    SELECT 1 FROM vehicles
    WHERE brand = 'Audi' AND model = 'Q5'
);

INSERT INTO vehicles
    (brand, model, category, price_per_day, fuel_type,
     transmission, seats, doors, image, description)
SELECT 'Fiat', '500', 'Subcompact', 35.00,
       'Petrol', 'Manual', 4, 3, 'fiat500.jpg',
       'An economical and compact car suitable for city driving.'
WHERE NOT EXISTS (
    SELECT 1 FROM vehicles
    WHERE brand = 'Fiat' AND model = '500'
);

INSERT INTO vehicles
    (brand, model, category, price_per_day, fuel_type,
     transmission, seats, doors, image, description)
SELECT 'Mercedes-Benz', 'Sprinter', 'Full-size Van', 170.00,
       'Diesel', 'Automatic', 9, 4, 'sprinter.jpg',
       'A spacious full-size van, perfect for big groups or family.'
WHERE NOT EXISTS (
    SELECT 1 FROM vehicles
    WHERE brand = 'Mercedes-Benz' AND model = 'Sprinter'
);
