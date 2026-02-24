USE multivendor_eshop;

-- Users (plain text passwords for development/demo; hashed in production)
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@demo.com', 'admin123', 'admin'),
('Vendor User', 'vendor@demo.com', 'vendor123', 'vendor'),
('Customer User', 'customer@demo.com', 'customer123', 'customer');

-- Vendor linked to Vendor User (user_id=2)
INSERT INTO vendors (user_id, shop_name, description, status) VALUES
(2, 'Tech Galaxy', 'Quality electronics and gadgets from trusted brands.', 'approved');

-- Categories
INSERT INTO categories (name) VALUES
('Electronics'), ('Fashion'), ('Home'), ('Beauty'), ('Sports')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Products (vendor_id=1 refers to the first vendor we inserted)
INSERT INTO products (vendor_id, name, description, category_id, price, stock, images, brand) VALUES
(1, 'Wireless Headphones', 'Comfortable over-ear wireless headphones with noise isolation. Battery up to 30h.', 1, 2999.00, 25, JSON_ARRAY('https://images.unsplash.com/photo-1518440542459-49f74f83a3d8?w=1080&auto=format&fit=crop','https://images.unsplash.com/photo-1518440531234-cd6689802b43?w=1080&auto=format&fit=crop'), 'SoundMax'),
(1, 'Smart Watch', 'Fitness tracking, heart rate monitor, notifications, and water-resistant design.', 1, 4499.00, 40, JSON_ARRAY('https://images.unsplash.com/photo-1511735111819-9a3f66bc09b0?w=1080&auto=format&fit=crop','https://images.unsplash.com/photo-1512446816041-444daef8b4c5?w=1080&auto=format&fit=crop'), 'FitPro'),
(1, 'Bluetooth Speaker', 'Compact speaker with deep bass and 12-hour battery life.', 1, 1999.00, 60, JSON_ARRAY('https://images.unsplash.com/photo-1490376840453-5f616fbebe5b?w=1080&auto=format&fit=crop','https://images.unsplash.com/photo-1585386959984-a41552231620?w=1080&auto=format&fit=crop'), 'BoomBox'),
(1, 'Running Shoes', 'Lightweight and breathable shoes suitable for running and gym.', 5, 2599.00, 50, JSON_ARRAY('https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=1080&auto=format&fit=crop','https://images.unsplash.com/photo-1542293787938-c9e299b8801a?w=1080&auto=format&fit=crop'), 'RunLite');
