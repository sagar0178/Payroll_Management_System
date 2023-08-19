-- Table: admin
CREATE TABLE IF NOT EXISTS admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL
);

-- Table: employees
CREATE TABLE IF NOT EXISTS employees (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  department VARCHAR(50) NOT NULL,
  employee_type VARCHAR(50) NOT NULL,
  basic_pay DECIMAL(10, 2) NOT NULL,
  contact VARCHAR(20),
  email VARCHAR(100) UNIQUE,
  home_address VARCHAR(200),
  city VARCHAR(50),
  zip VARCHAR(10),
  marital_status VARCHAR(20),
  password VARCHAR(100) NOT NULL
);

-- Table: deductions
CREATE TABLE deductions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT,
    tax_deduction_amount DECIMAL(10, 2),
    FOREIGN KEY (employee_id) REFERENCES employees(id)
);

-- Table: income
CREATE TABLE IF NOT EXISTS income (
  id INT AUTO_INCREMENT PRIMARY KEY,
  employee_id INT NOT NULL,
  basic_pay DECIMAL(10, 2) NOT NULL,
  deductions DECIMAL(10, 2) NOT NULL,
  overtime DECIMAL(10, 2) NOT NULL,
  bonus DECIMAL(10, 2) NOT NULL,
  net_pay DECIMAL(10, 2) NOT NULL,
  total DECIMAL(10, 2) NOT NULL DEFAULT 0,
  FOREIGN KEY (employee_id) REFERENCES employees (id)
);

-- Table: leaves
CREATE TABLE IF NOT EXISTS leaves (
  id INT AUTO_INCREMENT PRIMARY KEY,
  employee_id INT NOT NULL,
  leave_reason VARCHAR(100) NOT NULL,
  address VARCHAR(200) NOT NULL,
  leave_type VARCHAR(50) NOT NULL,
  leave_status VARCHAR(20) NOT NULL,
  FOREIGN KEY (employee_id) REFERENCES employees (id)
);

CREATE TABLE departments (
    department_id INT AUTO_INCREMENT PRIMARY KEY,
    department_name VARCHAR(255) NOT NULL
);


CREATE TABLE overtime_bonus (
  id INT PRIMARY KEY AUTO_INCREMENT,
  employee_id INT NOT NULL,
  overtime_hours DECIMAL(8, 2) NOT NULL,
  bonus_amount DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (employee_id) REFERENCES employees(id)
);


INSERT INTO admin (username, password)
VALUES ('admin', 'password');

