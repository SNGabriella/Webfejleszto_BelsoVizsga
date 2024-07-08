CREATE DATABASE Z_TECH;
USE Z_TECH;

CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    telephone VARCHAR(20) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP()
);

CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    serial_number VARCHAR(255) NOT NULL UNIQUE,
    manufacturer VARCHAR(100) NOT NULL,
    model VARCHAR(100) NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP()
);

CREATE TABLE service_statuses (
    status_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    status VARCHAR(100) NOT NULL,
    change_of_status timestamp DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products (product_id)
);

CREATE TABLE customer_products (
    customer_product_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    product_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers (customer_id),
    FOREIGN KEY (product_id) REFERENCES products (product_id)
);

SELECT * FROM customers c
WHERE c.email = 'kislajos@gmail.com';

SELECT * FROM customer_products cp
WHERE cp.customer_id = 1;

SELECT 
    c.customer_id,
    c.first_name,
    c.last_name,
    p.product_id,
    p.serial_number,
    p.manufacturer,
    p.model
FROM customers c
JOIN customer_products cp
  ON c.customer_id = cp.customer_id
JOIN products p 
  ON cp.product_id = p.product_id
WHERE 
    cp.product_id = 3;

SELECT 
  p.serial_number,
  p.manufacturer,
  p.model,
  ss.status,
  ss.change_of_status
FROM service_statuses ss
JOIN products p ON ss.product_id = p.product_id
WHERE
    ss.status != 'Kész' OR (ss.status = 'Kész' AND DATE(ss.change_of_status) = CURDATE())
ORDER BY 
FIELD(ss.status, 'Beérkezett', 'Hibafeltárás', 'Alkatrész beszerzés alatt', 'Javítás', 'Kész'), ss.change_of_status ASC;

SELECT 
    p.product_id,
    c.last_name,
    c.first_name
FROM 
    products p
JOIN 
    customer_products cp ON cp.product_id = p.product_id
JOIN 
    customers c ON c.customer_id = cp.customer_id
WHERE 
    p.product_id = 5;







     

