# WordPress Setup Instructions

## Prerequisites

- PHP 8.0 or higher
- MySQL 5.7+ or MariaDB 10.3+
- Apache or Nginx web server
- Composer (optional, for plugin management)

## Installation Steps

### 1. Download WordPress

```bash
cd /home/dracudev/dev/carmen-estetica-wp/wordpress
wget https://wordpress.org/latest.tar.gz
tar -xzf latest.tar.gz
mv wordpress/* .
rm -rf wordpress latest.tar.gz
```

### 2. Database Setup

Create a new MySQL database:

```sql
CREATE DATABASE serenity_spa_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'serenity_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON serenity_spa_db.* TO 'serenity_user'@'localhost';
FLUSH PRIVILEGES;
```

### 3. Configure WordPress

```bash
# Copy the sample config
cp wp-config-sample.php wp-config.php

# Edit wp-config.php with your database credentials
# Or use WP-CLI:
wp config create --dbname=serenity_spa_db --dbuser=serenity_user --dbpass=your_secure_password
```

### 4. Install WordPress

Visit `http://localhost:8000` in your browser and complete the WordPress installation, or use WP-CLI:

```bash
wp core install \
  --url="http://localhost:8000" \
  --title="Serenity Spa" \
  --admin_user="admin" \
  --admin_password="secure_password" \
  --admin_email="admin@serenityspa.com"
```

### 5. Install Required Plugins

#### Via WP Admin Dashboard

1. Navigate to **Plugins > Add New**
2. Install and activate the following plugins:
   - **WPGraphQL** (by WPGraphQL)
   - **WPGraphQL for Advanced Custom Fields** (by WPGraphQL)
   - **Advanced Custom Fields PRO** (requires license)

#### Via WP-CLI

```bash
# Install WPGraphQL
wp plugin install wp-graphql --activate

# Install WPGraphQL for ACF
wp plugin install https://github.com/wp-graphql/wpgraphql-acf/archive/refs/heads/main.zip --activate

# Install ACF Pro (requires license key)
# Download from https://www.advancedcustomfields.com/my-account/
# Then upload via wp-admin or:
wp plugin install /path/to/advanced-custom-fields-pro.zip --activate
```

### 6. Activate the Headless Theme

```bash
# Copy the custom theme (already in place)
# The theme is located at: wp-content/themes/serenity-spa-headless/

# Activate the theme
wp theme activate serenity-spa-headless
```

### 7. Load ACF Fields

The ACF field groups are defined in `wp-content/themes/serenity-spa-headless/acf-fields.php`.

To load them, add this to your theme's `functions.php` (already included):

```php
require_once get_template_directory() . '/acf-fields.php';
```

Or import via ACF admin panel: **Custom Fields > Tools > Import Field Groups**

### 8. Create Initial Categories

```bash
# Create service categories
wp term create service_category "Facials" --description="Facial treatments and skincare"
wp term create service_category "Massages" --description="Relaxing massage therapies"
wp term create service_category "Body Treatments" --description="Full body treatments"
wp term create service_category "Wellness Packages" --description="Complete wellness experiences"
```

### 9. Configure Permalinks

Set permalinks to "Post name" for clean URLs:

```bash
wp rewrite structure '/%postname%/' --hard
wp rewrite flush
```

### 10. Configure GraphQL

1. Navigate to **GraphQL > Settings** in WordPress admin
2. Enable "Public Introspection" for development
3. Set the GraphQL endpoint to `/graphql`
4. Test the GraphQL endpoint at: `http://localhost:8000/graphql`

### 11. Test GraphQL Queries

Open the GraphiQL IDE at `http://localhost:8000/graphql` and test:

```graphql
query GetServices {
  services {
    nodes {
      id
      title
      slug
      serviceDetails {
        serviceDuration
        servicePrice
        featuredService
      }
      serviceCategories {
        nodes {
          name
          slug
        }
      }
    }
  }
}
```

## Required Plugins Summary

| Plugin                 | Version  | Purpose                          | Status           | License   |
| ---------------------- | -------- | -------------------------------- | ---------------- | --------- |
| WPGraphQL              | 2.3.8    | GraphQL API for WordPress        | ✅ Installed     | Free      |
| Advanced Custom Fields | 6.6.0    | Custom fields for content types  | ✅ Installed     | Free      |
| ~~WPGraphQL for ACF~~  | ~~2.0+~~ | ~~Expose ACF fields to GraphQL~~ | ❌ Not installed | ~~Free~~  |
| Yoast SEO or Rank Math | Latest   | SEO optimization                 | 📝 Recommended   | Free/Paid |

**Note:** ACF fields are manually registered to GraphQL in `functions.php` due to compatibility issues with WPGraphQL for ACF plugin.

## Optional Recommended Plugins

- **WPGraphQL CORS** - Enhanced CORS control
- **WPGraphQL JWT Authentication** - Secure API authentication
- **WP Rocket** - Caching and performance
- **Imagify** - Image optimization
- **Amelia** or **Bookly** - Booking system (Phase 2)

## Security Hardening

```bash
# Disable file editing
echo "define('DISALLOW_FILE_EDIT', true);" >> wp-config.php

# Set proper file permissions
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;

# Protect wp-config.php
chmod 600 wp-config.php
```

## CORS Configuration

For local development, CORS headers are automatically added in `functions.php`.

For production, update the `FRONTEND_URL` constant in `wp-config.php`:

```php
define('FRONTEND_URL', 'https://serenityspa.com');
```

## Troubleshooting

### GraphQL endpoint not working

```bash
# Flush rewrite rules
wp rewrite flush --hard

# Check if WPGraphQL is active
wp plugin list
```

### ACF fields not showing in GraphQL

1. Ensure "Show in GraphQL" is enabled for each field group
2. Clear any caching plugins
3. Check the GraphiQL IDE schema documentation

### Theme not appearing

```bash
# Verify theme files
ls -la wp-content/themes/serenity-spa-headless/

# Check theme status
wp theme list
```

## Next Steps

After completing the WordPress setup:

1. ✅ WordPress is installed and configured
2. ✅ Custom post types are registered
3. ✅ ACF fields are configured
4. ✅ GraphQL API is accessible
5. ➡️ Proceed to Frontend (Astro) setup
6. ➡️ Add sample content
7. ➡️ Integrate booking system

See `../frontend/README.md` for Astro setup instructions.

## Useful Commands

```bash
# Check WordPress installation
wp core version

# List all post types
wp post-type list

# List all taxonomies
wp taxonomy list

# Export database
wp db export backup.sql

# Import database
wp db import backup.sql

# Search and replace URLs
wp search-replace 'http://localhost:8000' 'https://production.com' --dry-run
```

## Development Workflow

1. Make changes to theme files
2. Test in GraphQL IDE
3. Clear cache if needed: `wp cache flush`
4. Test queries from Astro frontend
5. Commit changes to version control

## Support Resources

- [WPGraphQL Documentation](https://www.wpgraphql.com/docs/introduction)
- [ACF Documentation](https://www.advancedcustomfields.com/resources/)
- [WordPress Codex](https://codex.wordpress.org/)
