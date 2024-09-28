
CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    amount DECIMAL(10, 2) NOT NULL,
    user_id INT NOT NULL,
    tracking_id VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    UNIQUE KEY (user_id,tracking_id),
    CONSTRAINT USERTackingIDUnique UNIQUE (user_id,tracking_id)
);