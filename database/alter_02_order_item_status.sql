USE multivendor_eshop;

ALTER TABLE order_items
  ADD COLUMN status ENUM('pending','shipped','completed') NOT NULL DEFAULT 'pending' AFTER price;
