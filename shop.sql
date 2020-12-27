CREATE TABLE users (
id INT auto_increment PRIMARY KEY,
name VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL UNIQUE KEY,
password VARCHAR(255) NOT NULL,
money INT DEFAULT 0,
isAdmin INT DEFAULT 0,
created_at datetime DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_info (
id INT auto_increment PRIMARY KEY,
user_id INT,
order_id INT,
country VARCHAR(255),
firstname VARCHAR(255),
lastname VARCHAR(255),
address1 VARCHAR(255),
address2 VARCHAR(255),
state VARCHAR(255),
company VARCHAR(255),
phone VARCHAR(255),
city VARCHAR(255),
zip VARCHAR(255),
FOREIGN KEY (user_id)
REFERENCES users (id)
ON DELETE CASCADE
);

CREATE TABLE products (
id INT auto_increment PRIMARY KEY,
name VARCHAR(255) NOT NULL,
description text NOT NULL,
image_path VARCHAR(255),
price INT DEFAULT 0,
stock INT DEFAULT 0,
created_at datetime DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
id INT auto_increment PRIMARY KEY,
user_id INT,
total_price VARCHAR(255),
order_status ENUM("Order Placed", "Shipping", "Delivery Completed"),
payment_mode ENUM("Cash", "Card", "Paypal"),
created_at datetime DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
id INT auto_increment PRIMARY KEY,
order_id INT,
product_id INT,
product_price VARCHAR(255),
product_qty INT
);

CREATE TABLE wishList (
id INT auto_increment PRIMARY KEY,
product_id INT,
user_id INT,
created_at datetime DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (user_id)
REFERENCES users (id)
ON DELETE CASCADE,
FOREIGN KEY (product_id)
REFERENCES products (id)
ON DELETE CASCADE
);

CREATE TABLE logs (
uu INT,
pv INT,
admin_page INT,
products_page INT,
users_page INT,
wishlists_page INT,
orders_page INT,
order_count INT,
product_ranking VARCHAR(255),
date VARCHAR(255) UNIQUE KEY
);