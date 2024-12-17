---

# **Ecomaze Solutions**  

## **Project Overview**  
Ecomaze Solutions is a female-focused e-commerce platform designed to provide women and girls with **affordable, eco-friendly menstrual care products**. This platform bridges the gap in accessibility, offering sustainable solutions like biodegradable pads, tampons, and reusable liners.  

The website features a **user-friendly shopping experience** for customers and an **admin panel** for managing products, orders, and users efficiently.  

---

## **Key Features**  

### **1. Customer Features**  
- Browse eco-friendly femcare products.  
- Add products to the shopping cart.  
- View cart details, adjust quantities, and proceed to checkout.  
- Update personal account details.  

### **2. Admin Features**  
- Manage products: Add, update, or delete products.  
- View and monitor orders dynamically.  
- Manage user accounts: Edit or delete user information.  

### **3. Core Functionalities**  
- **Dynamic Product Management**: Products and orders are fetched from the database and displayed in real-time.  
- **Shopping Cart**: Customers can add products to the cart and proceed to checkout seamlessly.  
- **Order Tracking**: Orders are saved in the database for admin monitoring.  
- **User Account Management**: Users can update their information, enhancing personalization.  

---

## **Technologies Used**  

### **Front-End**  
- **HTML/CSS**: Page structure and styling.  
- **JavaScript**: Interactivity (e.g., add to cart, filtering products).  

### **Back-End**  
- **PHP**: Handles server-side logic and connects the website to the database.  

### **Database**  
- **MySQL**: Stores product details, orders, and user account information.  

### **Tools & Frameworks**  
- **XAMPP**: Local development environment for Apache, PHP, and MySQL.  
- **Git & GitHub**: Version control and project management.  

---

## **Project Setup Instructions**  

Follow these steps to run the Ecomaze Solutions website on your local machine:

### **1. Clone the Repository**  
Clone the project from GitHub to your local computer using the following command:  
```bash
git clone https://github.com/your-username/ecomaze_solutions.git
```

### **2. Install XAMPP**  
- Download and install XAMPP from [Apache Friends](https://www.apachefriends.org/).  
- Ensure that **Apache** and **MySQL** services are running.  

### **3. Set Up the Database**  
1. Open **phpMyAdmin** from XAMPP control panel.  
2. Create a new database named `ecomaze_solutions`.  
3. Import the `ecomaze_solutions.sql` file from the project folder into the database.  

### **4. Configure Database Connection**  
Update the database connection settings in the `db/database.php` file:  
```php
<?php
$host = "localhost";
$user = "root"; // Default XAMPP user
$password = ""; // Default XAMPP password is empty
$database = "ecomaze_solutions";

$db = new mysqli($host, $user, $password, $database);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
```

### **5. Run the Website**  
1. Place the project folder in the `htdocs` directory of your XAMPP installation.  
2. Open your browser and navigate to:  
   ```
   http://localhost/ecomaze_solutions/
   ```

---

## **File Structure**  

```
ecomaze_solutions/
│
├── actions/                  # Backend actions
│   ├── add_product.php       # Add a new product
│   ├── add_to_cart.php       # Add items to cart
│   ├── cart_count.php        # Get cart count
│   ├── checkout.php          # Checkout functionality
│   ├── delete_product.php    # Delete a product
│   ├── delete_user.php       # Delete a user
│   ├── edit_product.php      # Edit product details
│   ├── edit_user.php         # Edit user details
│   ├── get_ordered_products.php # Fetch ordered products
│   ├── get_products.php      # Fetch product list
│   ├── get_user.php          # Fetch user information
│   ├── login.php             # User login functionality
│   ├── logout.php            # User logout functionality
│   ├── signup.php            # User signup functionality
│   └── update_account.php    # Update user account details
│
├── assets/                   # Static files (CSS, images)
│   ├── uploads/              # Uploaded assets
│   │   ├── faith.jpg
│   │   ├── inez.jpg
│   │   └── selorm.jpg
│   ├── about.css             # About page styles
│   ├── account.css           # Account management styles
│   ├── admin.css             # Admin panel styles
│   ├── cart.css              # Cart page styles
│   ├── forms.css             # Forms styling
│   ├── index.css             # Home page styling
│   ├── login.css             # Login page styles
│   └── signup.css            # Signup page styles
│
├── db/                       # Database connection and functions
│   ├── auth_functions.php    # Authentication helper functions
│   ├── database_functions.php # General database functions
│   └── validation_functions.php # Input validation functions
│
├── utils/                    # Utility helper files
│   ├── constants.php         # Project constants
│   ├── errorHandler.php      # Error handling functions
│   └── sessionHelper.php     # Session management helper
│
├── view/                     # Front-end pages
│   ├── admin/                # Admin-specific pages
│   │   ├── products.php      # Admin product management
│   │   └── about.php         # Admin about page
│   ├── about.php             # About page for users
│   ├── account.php           # Account page for users
│   ├── cart.php              # Shopping cart page
│   ├── checkout.php          # Checkout process page
│   ├── login.php             # Login page
│   ├── products.php          # Product display page
│   └── signup.php            # Signup page
│
├──index.php                 # Main entry point of the website
---README.md                 # Project documentation

```

## **How to Contribute**  

We welcome contributions to improve the platform!  

1. **Fork the repository**.  
2. Create a new branch:  
   ```bash
   git checkout -b feature-name
   ```  
3. Commit your changes:  
   ```bash
   git commit -m "Add your feature or fix"
   ```  
4. Push the changes and create a pull request:  
   ```bash
   git push origin feature-name
   ```

---

## **Contact**  
For any inquiries or support, please contact:  
**Developer**: Faith Ruto  
**Email**: [faith.ruto@ashesi.edu.gh](mailto:faith.ruto@ashesi.edu.gh)  

---

## **License**  
This project is licensed under the **MIT License**.  

---
