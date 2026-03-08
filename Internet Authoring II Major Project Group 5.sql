-- Create the database
CREATE DATABASE IF NOT EXISTS AWH_salaries;

-- Switch to the database
USE AWH_salaries;

-- Create table for employees
CREATE TABLE IF NOT EXISTS employees (
    EIN VARCHAR(10) PRIMARY KEY,
    name VARCHAR(50),
    qualification VARCHAR(50),
    salary DECIMAL(10,2),
    deductions DECIMAL(10,2),
    TRN VARCHAR(20),
    bank_branch VARCHAR(20),
    BAN VARCHAR(20),
    Databasename VARCHAR(50) DEFAULT 'AWH_salaries'
);

-- Insert sample data for employees
INSERT INTO employees (EIN, name, qualification, salary, deductions, TRN, bank_branch, BAN) VALUES
('P23', 'Jackson', 'MSc. Deg.', 164991.98, 44785.90, '123-456', '12', '12-01'),
('M12', 'Jennings', 'PhD. Deg.', 312980.03, 159082.78, '987-654', '34', '34-87'),
('L01', 'Johnson', 'ASc. Deg.', 79980.18, 23001.98, '234-567', '29', '29-18'),
('A09', 'James', 'BSc. Deg.', 101034.41, 37998.29, '934-112', '12', '12-12');

-- Update salary for employee with EIN 'P23'
UPDATE employees
SET salary = 175000.00
WHERE EIN = 'P23';

-- Insert a new employee
INSERT INTO employees (EIN, name, qualification, salary, deductions, TRN, bank_branch, BAN) 
VALUES ('B22', 'Smith', 'BSc. Deg.', 90000.00, 20000.00, '345-678', '45', '45-09');

-- Select all employees
SELECT * FROM employees;

-- Delete employee with EIN ''
DELETE FROM employees WHERE EIN = 'A56';

-- Show their current BAN
SELECT BAN FROM employees WHERE EIN = 'B22';

-- Show the current branch for their bank
SELECT bank_branch FROM employees WHERE EIN = 'B22';

-- Give the total monies to be received for net pay
SELECT (salary - deductions) AS net_pay FROM employees WHERE EIN = 'B22';

-- Show their current highest qualification
SELECT MAX(qualification) AS highest_qualification FROM employees WHERE EIN = 'B22';

