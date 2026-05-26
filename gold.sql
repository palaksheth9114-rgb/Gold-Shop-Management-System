-- Gold Shop Management System Database Schema

CREATE DATABASE IF NOT EXISTS gold_shop_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gold_shop_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NULL,
    security_question_id INT NULL,
    security_answer_hash VARCHAR(255) NULL,
    role ENUM('admin', 'manager', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    INDEX idx_username (username),
    UNIQUE KEY uniq_email (email),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Security Questions Table
CREATE TABLE IF NOT EXISTS security_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Customers Table
CREATE TABLE customers (
    id VARCHAR(20) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    address TEXT,
    created_at DATE NOT NULL,
    INDEX idx_phone (phone),
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Employees Table
CREATE TABLE employees (
    id VARCHAR(20) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    role VARCHAR(100) NOT NULL,
    hire_date DATE NOT NULL,
    salary DECIMAL(10,2) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Suppliers Table
CREATE TABLE suppliers (
    id VARCHAR(20) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contact_person VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    address TEXT,
    status ENUM('Active', 'Inactive') DEFAULT 'Active',
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Products Table
CREATE TABLE products (
    id VARCHAR(20) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    weight DECIMAL(10,2) NOT NULL,
    purity INT NOT NULL,
    purchase_price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    INDEX idx_category (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inventory Table
CREATE TABLE inventory (
    id VARCHAR(20) PRIMARY KEY,
    product_id VARCHAR(20) NOT NULL,
    supplier_id VARCHAR(20) NOT NULL,
    quantity DECIMAL(10,2) NOT NULL,
    available_stock DECIMAL(10,2) NOT NULL,
    last_updated DATETIME NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE CASCADE,
    INDEX idx_product (product_id),
    INDEX idx_supplier (supplier_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bills Table
CREATE TABLE bills (
    id VARCHAR(20) PRIMARY KEY,
    customer_id VARCHAR(20) NOT NULL,
    employee_id VARCHAR(20) NOT NULL,
    bill_date DATE NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    gst DECIMAL(10,2) NOT NULL,
    discount DECIMAL(10,2) DEFAULT 0,
    net_payable DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    INDEX idx_bill_date (bill_date),
    INDEX idx_customer (customer_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bill Items Table
CREATE TABLE bill_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bill_id VARCHAR(20) NOT NULL,
    product_id VARCHAR(20) NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    weight DECIMAL(10,2) NOT NULL,
    purity VARCHAR(10) NOT NULL,
    gold_price DECIMAL(10,2) NOT NULL,
    making_charges DECIMAL(10,2) NOT NULL,
    item_total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (bill_id) REFERENCES bills(id) ON DELETE CASCADE,
    INDEX idx_bill (bill_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Regular Orders Table
CREATE TABLE regular_orders (
    id VARCHAR(20) PRIMARY KEY,
    customer_id VARCHAR(20) NOT NULL,
    employee_id VARCHAR(20) NOT NULL,
    order_date DATE NOT NULL,
    weight DECIMAL(10,2) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    status VARCHAR(50) NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_order_date (order_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Advance Orders Table
CREATE TABLE advance_orders (
    id VARCHAR(20) PRIMARY KEY,
    customer_id VARCHAR(20) NOT NULL,
    employee_id VARCHAR(20) NOT NULL,
    order_date DATE NOT NULL,
    delivery_date DATE NOT NULL,
    weight DECIMAL(10,2) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    advance_paid DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    status VARCHAR(50) NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_delivery_date (delivery_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Vyaj Orders Table
CREATE TABLE vyaj_orders (
    id VARCHAR(20) PRIMARY KEY,
    customer_id VARCHAR(20) NOT NULL,
    employee_id VARCHAR(20) NOT NULL,
    order_date DATE NOT NULL,
    due_date DATE NOT NULL,
    weight DECIMAL(10,2) NOT NULL,
    base_amount DECIMAL(10,2) NOT NULL,
    vyaj_rate DECIMAL(5,2) NOT NULL,
    vyaj_amount DECIMAL(10,2) NOT NULL,
    month1_payment DECIMAL(10,2) DEFAULT 0,
    month2_payment DECIMAL(10,2) DEFAULT 0,
    month3_payment DECIMAL(10,2) DEFAULT 0,
    total_price DECIMAL(10,2) NOT NULL,
    paid_amount DECIMAL(10,2) NOT NULL,
    payment_status VARCHAR(50) NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    INDEX idx_status (payment_status),
    INDEX idx_due_date (due_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Gold Sales Table (Gold Sold by Customer)
CREATE TABLE gold_sales (
    id VARCHAR(20) PRIMARY KEY,
    customer_id VARCHAR(20) NOT NULL,
    product_id VARCHAR(20) NOT NULL,
    quantity DECIMAL(10,2) NOT NULL,
    purity INT NOT NULL,
    getting_date DATE NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    payment_to_customer DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_getting_date (getting_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Sample Data

INSERT INTO users (username, password, email, role) VALUES
('admin', 'admin123', 'admin@goldshop.com', 'admin'),
('manager', 'manager123', 'manager@goldshop.com', 'manager'),
('user', 'user123', 'user@goldshop.com', 'user');

-- Seed common security questions
INSERT INTO security_questions (question) VALUES
('What is your mother\'s maiden name?'),
('What was the name of your first pet?'),
('What was the name of your first school?'),
('What city were you born in?');

INSERT INTO customers (id, name, phone, email, address, created_at) VALUES
('CUS0001', 'Rajesh Kumar', '9876543210', 'rajesh@email.com', 'Mumbai, Maharashtra', '2024-01-15'),
('CUS0002', 'Priya Sharma', '9876543211', 'priya@email.com', 'Delhi, India', '2024-02-20'),
('CUS0003', 'Amit Patel', '9876543212', 'amit@email.com', 'Gujarat, India', '2024-03-10');

INSERT INTO employees (id, name, role, hire_date, salary, phone, email) VALUES
('EMP0001', 'Suresh Verma', 'Manager', '2023-01-10', 50000.00, '9123456780', 'suresh@goldshop.com'),
('EMP0002', 'Kavita Singh', 'Salesperson', '2023-06-15', 30000.00, '9123456781', 'kavita@goldshop.com'),
('EMP0003', 'Rahul Gupta', 'Cashier', '2023-09-01', 25000.00, '9123456782', 'rahul@goldshop.com');

INSERT INTO suppliers (id, name, contact_person, phone, email, address, status) VALUES
('SUP0001', 'Golden Suppliers Ltd', 'Mr. Mehta', '9988776655', 'golden@supplier.com', 'Zaveri Bazaar, Mumbai', 'Active'),
('SUP0002', 'Royal Gold Imports', 'Ms. Reddy', '9988776656', 'royal@supplier.com', 'Karol Bagh, Delhi', 'Active'),
('SUP0003', 'Premium Jewels Co', 'Mr. Shah', '9988776657', 'premium@supplier.com', 'Surat, Gujarat', 'Inactive');

INSERT INTO products (id, name, category, weight, purity, purchase_price, stock) VALUES
('PRD0001', 'Gold Necklace Set', 'Necklace', 45.50, 22, 5800.00, 15),
('PRD0002', 'Diamond Ring', 'Ring', 8.20, 18, 6500.00, 25),
('PRD0003', 'Gold Chain', 'Chain', 25.00, 22, 5900.00, 30),
('PRD0004', 'Pearl Earrings', 'Earring', 12.50, 18, 5500.00, 20);

INSERT INTO inventory (id, product_id, supplier_id, quantity, available_stock, last_updated) VALUES
('INV0001', 'PRD0001', 'SUP0001', 500.00, 450.00, '2024-10-20 10:30:00'),
('INV0002', 'PRD0002', 'SUP0002', 200.00, 180.00, '2024-10-21 14:15:00'),
('INV0003', 'PRD0003', 'SUP0001', 750.00, 700.00, '2024-10-22 09:45:00');