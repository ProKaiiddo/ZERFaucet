# ZERFaucet

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)
[![ZER Blockchain](https://img.shields.io/badge/Blockchain-ZER-yellow)](https://zerochain.info/)

A simple and secure cryptocurrency faucet for distributing free ZER tokens. Built with PHP and MySQL, this faucet allows users to claim a small amount of ZER every 24 hours while implementing robust security measures to prevent abuse.

## Features

### Core Functionality
- **Free ZER Claims**: Users can claim 0.00001 ZER tokens every 24 hours
- **Wallet Validation**: Strict validation for ZER wallet addresses (must start with "t1" and be 34 characters)
- **Anti-Abuse Protection**:
  - IP-based claim limits (configurable)
  - Cooldown period enforcement
  - Rate limiting per wallet address
- **Real-time Statistics**: Track total distributed ZER, claim counts, and active users
- **Recent Payouts**: Public ledger of recent successful claims

### Security Features
- **Database Encryption**: Secure storage with encryption keys
- **Input Sanitization**: Protection against XSS and injection attacks
- **Security Headers**: Comprehensive HTTP security headers
- **Anti-Tampering**: Client-side security checks to prevent unauthorized modifications
- **CORS Protection**: Restricted origins for API access

### User Experience
- **Responsive Design**: Mobile-friendly interface using Bootstrap 5
- **Real-time Countdown**: Visual timer showing next claim availability
- **Donation Support**: Built-in donation modal to support faucet maintenance
- **Ad Integration**: Placeholder slots for advertisements
- **Modern UI**: Clean, professional design with Geist font

### Technical Features
- **API Integration**: Direct integration with ZER blockchain API
- **Database Logging**: Complete transaction history
- **Error Handling**: Graceful handling of API failures and database issues
- **Performance Optimization**: Gzip compression and caching headers
- **URL Rewriting**: Clean URLs without .php extensions

## Requirements

- **Web Server**: Apache with mod_rewrite enabled (recommended: XAMPP)
- **PHP**: Version 7.4 or higher
- **MySQL**: Version 5.7 or higher
- **Extensions**:
  - PDO (PHP Data Objects)
  - cURL (for API calls)
  - OpenSSL (for encryption)
- **ZER Wallet**: Private key and API key for transaction signing

## Installation

### Step 1: Download and Setup XAMPP
1. Download XAMPP from [apachefriends.org](https://www.apachefriends.org/)
2. Install XAMPP on your system
3. Start Apache and MySQL services from the XAMPP control panel

### Step 2: Clone or Download the Project
1. Create a new folder `ZERFaucet` in your XAMPP htdocs directory:
   ```
   C:\xampp\htdocs\ZERFaucet\  (Windows)
   /opt/lampp/htdocs/ZERFaucet/  (Linux)
   ```
2. Copy all project files (`index.php`, `config.php`, `db.sql`, `.htaccess`) into this folder

### Step 3: Create Database
1. Open phpMyAdmin (usually at `http://localhost/phpmyadmin`)
2. Create a new database named `zerfaucet`
3. Import the `db.sql` file:
   - Go to the "Import" tab
   - Select the `db.sql` file
   - Click "Go" to execute

### Step 4: Configure Settings
1. Open `config.php` in a text editor
2. Update the database credentials if different from defaults:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'zerfaucet');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```
3. **Important**: Obtain ZER API credentials:
   - Get your private key from your ZER wallet
   - Obtain API key from ZER blockchain service
   - Update these in the database settings table (see Configuration section)

### Step 5: Insert Initial Settings
After creating the database, insert the initial configuration:
```sql
INSERT INTO settings (faucet_reward, claim_cooldown, private_key, api_key, fees) 
VALUES (0.00001, 86400, 'your_private_key_here', 'your_api_key_here', 0.00000001);
```
You can do this via phpMyAdmin or command line.

### Step 6: Set Permissions (Linux/Mac)
If running on Linux/Mac, ensure proper permissions:
```bash
chmod 755 /path/to/ZERFaucet
chmod 644 /path/to/ZERFaucet/*.php
```

### Step 7: Access the Faucet
1. Open your web browser
2. Navigate to: `http://localhost/ZERFaucet`
3. The faucet should now be running!

## Configuration

### Database Settings
Edit `config.php` to match your database setup:
- `DB_HOST`: Database server address
- `DB_NAME`: Database name (default: zerfaucet)
- `DB_USER`: Database username
- `DB_PASS`: Database password

### Security Settings
- `MAX_CLAIMS_PER_IP`: Maximum claims allowed per IP per day (default: 1)
- `ENCRYPTION_KEY`: Key for data encryption (change for production)
- `ALLOWED_ORIGINS`: Array of allowed domains for CORS

### Faucet Settings
Configure via database `settings` table:
- `faucet_reward`: Amount of ZER to distribute per claim
- `claim_cooldown`: Cooldown period in seconds (default: 86400 = 24 hours)
- `private_key`: Your ZER wallet private key
- `api_key`: ZER API key for transaction signing
- `fees`: Transaction fees

### API Configuration
- `ZER_API_URL`: ZER blockchain API endpoint
- `API_TIMEOUT`: API request timeout in seconds

## Usage

### For Users
1. Visit the faucet URL
2. Enter your ZER wallet address (format: t1...)
3. Click "Claim" to receive free ZER
4. Wait 24 hours before claiming again

### For Administrators
- Monitor statistics in the dashboard
- View recent payouts in the table
- Check logs for any errors
- Update settings via database

## Troubleshooting

### Common Issues

**Database Connection Error**
- Ensure MySQL is running in XAMPP
- Check database credentials in `config.php`
- Verify database name exists

**API Payment Failed**
- Verify your private key and API key are correct
- Check ZER API status
- Ensure sufficient balance in your wallet

**403 Forbidden Error**
- Check `.htaccess` file permissions
- Ensure mod_rewrite is enabled in Apache

**Claim Button Disabled**
- Check database connection
- Verify settings table has valid data
- Check browser console for JavaScript errors

### Debug Mode
Enable error reporting by adding to `config.php`:
```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

## Security Considerations

- **Production Deployment**: 
  - Use HTTPS with SSL certificate
  - Change default database credentials
  - Update encryption key
  - Restrict file permissions

- **Regular Maintenance**:
  - Monitor logs for suspicious activity
  - Keep PHP and MySQL updated
  - Backup database regularly

- **Rate Limiting**: Consider implementing additional rate limiting at server level

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For support and questions:
- Create an issue on GitHub
- Contact the developer: ParallaxStudio

---

**Disclaimer**: This faucet is provided as-is. Users are responsible for their own security and should verify all transactions. The developers are not responsible for any lost funds or security breaches.
