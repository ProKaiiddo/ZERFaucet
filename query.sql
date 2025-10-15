-- Create settings table
CREATE TABLE settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    faucet_reward DECIMAL(20,8) NOT NULL DEFAULT 0.00001,
    claim_cooldown INT NOT NULL DEFAULT 86400, -- 24 hours in seconds
    private_key VARCHAR(255) NOT NULL,
    api_key VARCHAR(255) NOT NULL,
    fees DECIMAL(20,8) NOT NULL DEFAULT 0.00000001,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create claims table
CREATE TABLE claims (
    id INT PRIMARY KEY AUTO_INCREMENT,
    wallet_address VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    amount DECIMAL(20,8) NOT NULL,
    transaction_hash VARCHAR(255),
    status ENUM('pending', 'success', 'failed') DEFAULT 'pending',
    claim_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    next_claim_time TIMESTAMP NULL,
    INDEX idx_wallet (wallet_address),
    INDEX idx_ip (ip_address),
    INDEX idx_time (next_claim_time)
);

-- Insert default settings
INSERT INTO settings (faucet_reward, claim_cooldown, private_key, api_key, fees) 
VALUES (0.00001, 86400, 'private-key', 'api-key', 0.00000001); 
