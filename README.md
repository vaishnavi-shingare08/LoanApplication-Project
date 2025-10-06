# QuickLoan - Online Loan Application System

> A professional loan application platform built with PHP, Nginx, and MySQL, deployed on AWS infrastructure. This system enables users to apply for various types of loans through a clean, responsive web interface.

## Features

- **Multiple Loan Products**: Home, Gold, Vehicle, and Personal Loans
- **Responsive Design**: Mobile-friendly interface
- **Real-time Validation**: Form validation for better user experience
- **Secure Database**: AWS RDS MySQL for reliable data storage
- **Fast Performance**: Nginx + PHP-FPM for optimal speed
- **Professional UI**: Clean and modern design

## Tech Stack

| Component | Technology | Version |
|-----------|-----------|---------|
| **Frontend** | HTML5, CSS3 | - |
| **Backend** | PHP | 8.2.29 |
| **Web Server** | Nginx | 1.28.0 |
| **Database** | MySQL (AWS RDS) | 8.0.42 |
| **Process Manager** | PHP-FPM | 8.2 |
| **Operating System** | Amazon Linux | 2023 |
| **Cloud Provider** | AWS | EC2 + RDS |

## Project Structure

```
quickloan-app/
├── index.html              # Landing page
├── apply.php               # Loan application form
├── submit_application.php  # Form processing script
├── styles.css              # Main stylesheet
├── images/                 # Image assets
│   ├── quickloan_logo.png
│   ├── home_loan.jpg
│   ├── gold_loan.jpg
│   ├── vehicle_loan.jpg
│   └── personal_loan.jpg
├── includes/               # PHP includes
│   └── db_connect.php     # Database configuration
└── nginx/                  # Server configuration
    └── quickloan.conf     # Nginx configuration file
```

## Deployment Guide

### Prerequisites
- AWS Account
- EC2 Instance (Amazon Linux 2023)
- RDS MySQL Instance
- SSH access to EC2

### Step 1: System Setup

```bash
# Update system packages
sudo dnf update -y

# Install and configure Nginx
sudo dnf install nginx -y
sudo systemctl start nginx
sudo systemctl enable nginx
```

### Step 2: Install PHP 8.2

```bash
# Install PHP and required extensions
sudo dnf install php8.2 -y
sudo dnf install php-fpm php-mysqlnd php-pdo php-mbstring -y

# Start and enable PHP-FPM
sudo systemctl start php-fpm
sudo systemctl enable php-fpm
```

### Step 3: Install MySQL Client

```bash
# Install MariaDB client for MySQL connectivity
sudo yum install mariadb105 -y

# Verify installation
mysql --version
```

### Step 4: Configure Database

```bash
# Connect to RDS MySQL
mysql -h loan-app.c3a8yqwa6p76.ap-south-1.rds.amazonaws.com -P 3306 -u admin -p
```

```sql
-- Create database
CREATE DATABASE quickloan_db;

-- Use database
USE quickloan_db;

-- Create applications table
CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contact VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    loan_type VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Step 5: Deploy Application

```bash
# Navigate to web root
cd /usr/share/nginx/html/

# Deploy your files (upload via SCP or Git)
# Set proper permissions
sudo chown -R nginx:nginx /usr/share/nginx/html/
sudo chmod -R 755 /usr/share/nginx/html/

# Copy Nginx configuration
sudo cp nginx/quickloan.conf /etc/nginx/conf.d/

# Test Nginx configuration
sudo nginx -t

# Restart Nginx
sudo systemctl restart nginx
```

### Step 6: Configure Database Connection

Edit `includes/db_connect.php`:

```php
<?php
$servername = "loan-app.c3a8yqwa6p76.ap-south-1.rds.amazonaws.com";
$username = "admin";
$password = "your_password";
$dbname = "quickloan_db";
$port = 3306;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

## Nginx Configuration

```nginx
server {
    listen 80;
    server_name loan.3utilities.com;
    root /usr/share/nginx/html;
    index index.html index.php;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php-fpm/www.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## Database Schema

### `applications` Table

| Column | Type | Attributes |
|--------|------|------------|
| id | INT | PRIMARY KEY, AUTO_INCREMENT |
| name | VARCHAR(255) | NOT NULL |
| contact | VARCHAR(20) | NOT NULL |
| email | VARCHAR(255) | NOT NULL |
| loan_type | VARCHAR(50) | NOT NULL |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP |

## Security Features

- Database credentials stored separately
- Input validation and sanitization
- Prepared statements for SQL queries
- AWS Security Groups configured
- RDS instance in private subnet
- SSL/TLS for database connections

## Performance Optimizations

- **Nginx + PHP-FPM**: Efficient request handling
- **AWS RDS**: Managed database with automatic backups
- **Optimized Queries**: Indexed database fields
- **Static Asset Caching**: Configured in Nginx

## Testing

```bash
# Check Nginx status
sudo systemctl status nginx

# Check PHP-FPM status
sudo systemctl status php-fpm

# Test database connection
mysql -h loan-app.c3a8yqwa6p76.ap-south-1.rds.amazonaws.com -P 3306 -u admin -p

# Verify application data
USE quickloan_db;
SELECT * FROM applications;
```

## Usage

1. Visit the homepage at `http://your-domain.com`
2. Browse available loan products
3. Click on desired loan type
4. Fill out the application form
5. Submit the application
6. Data is stored securely in the database

## Troubleshooting

### Common Issues

**Issue: Cannot connect to database**
```bash
# Check RDS security group allows EC2 instance
# Verify credentials in db_connect.php
```

**Issue: PHP files download instead of executing**
```bash
# Ensure PHP-FPM is running
sudo systemctl status php-fpm

# Check Nginx PHP configuration
sudo nginx -t
```

**Issue: Permission denied errors**
```bash
# Fix file permissions
sudo chown -R nginx:nginx /usr/share/nginx/html/
sudo chmod -R 755 /usr/share/nginx/html/
```

## Future Enhancements

- Add user authentication
- Email notifications for applications
- Admin dashboard for managing applications
- Document upload functionality
- SMS verification
- Loan calculator
- Application status tracking
- Payment integration

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is open source and available under the MIT License.

## Author

**Vaishnavi Shingare**

- GitHub: [@vaishnavi-shingare08](https://github.com/vaishnavi-shingare08)
- Email: shingarevaishnavi97@gmail.com

## Acknowledgments

- Built as part of internship project
- Deployed on AWS infrastructure
- Inspired by modern loan application systems
- Thanks to the open-source community

## Support

For support, email shingarevaishnavi97@gmail.com or create an issue in this repository.

---

Made with care by Vaishnavi Shingare
