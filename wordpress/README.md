# WordPress Headless CMS Setup

Complete setup instructions for the WordPress backend powering CG Aesthetics. Configured as a headless CMS with GraphQL API.

## Current Status

- WordPress 6.4+ installed via Docker
- Custom post types registered (Services)
- ACF Pro fields configured and GraphQL-enabled
- WPGraphQL API active and tested
- Yoast SEO Premium configured
- Amelia Booking v1.2.34 integrated
- Custom headless theme active

## Prerequisites

**Using Docker (Recommended):**

- Docker & Docker Compose

**Manual Installation:**

- PHP 8.0 or higher
- MySQL 5.7+ or MariaDB 10.3+
- Apache or Nginx web server
- Composer (optional, for plugin management)

## Quick Start (Docker)

**Recommended approach using Docker Compose from project root:**

```bash
cd /home/dracudev/dev/cg-aesthetics-wp

# Start all services (WordPress, MySQL, phpMyAdmin)
docker-compose up -d

# Check containers are running
docker-compose ps

# Services available at:
# - WordPress: http://localhost:8000
# - phpMyAdmin: http://localhost:8080
# - GraphQL: http://localhost:8000/graphql
```

## Installation Steps (Docker)

### 1. Install WordPress Core

```bash
# WordPress core is auto-installed via Docker
# Or manually install using WP-CLI:
docker-compose exec wpcli wp core install \
  --url="http://localhost:8000" \
  --title="CG Aesthetics" \
  --admin_user="admin" \
  --admin_password="SecurePass123!" \
  --admin_email="admin@cg-aesthetics.local" \
  --skip-email
```

### 2. Install Required Plugins

```bash
# Install WPGraphQL
docker-compose exec wpcli wp plugin install wp-graphql --activate

# Install ACF Pro (requires license - upload via wp-admin)
# Or ACF Free version:
docker-compose exec wpcli wp plugin install advanced-custom-fields --activate

# Install Yoast SEO Premium (requires license - upload via wp-admin)
# Or Yoast SEO Free:
docker-compose exec wpcli wp plugin install wordpress-seo --activate

# Install Amelia Booking (requires license - already in wp-content/plugins)
docker-compose exec wpcli wp plugin activate ameliabooking

# Activate custom theme
docker-compose exec wpcli wp theme activate cg-aesthetics-headless

# Flush permalinks
docker-compose exec wpcli wp rewrite structure '/%postname%/' --hard
docker-compose exec wpcli wp rewrite flush
```

### 3. Create Service Categories

```bash
docker-compose exec wpcli wp term create service_category "Soins du Visage" --description="Traitements faciaux et soins de la peau"
docker-compose exec wpcli wp term create service_category "Massages" --description="Massages relaxants et thérapeutiques"
docker-compose exec wpcli wp term create service_category "Soins du Corps" --description="Traitements complets du corps"
docker-compose exec wpcli wp term create service_category "Forfaits Bien-être" --description="Expériences spa complètes"
```

### 4. Test GraphQL Endpoint

Visit **http://localhost:8000/graphql** and run:

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
        serviceDescription
        serviceBenefits {
          benefit
        }
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

## Manual Installation (Without Docker)

### 1. Download WordPress

```bash
cd /path/to/project/wordpress
wget https://wordpress.org/latest.tar.gz
tar -xzf latest.tar.gz
mv wordpress/* .
rm -rf wordpress latest.tar.gz
```

### 2. Database Setup

Create a new MySQL database:

```sql
CREATE DATABASE cg_aesthetics CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'cg_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON cg_aesthetics.* TO 'cg_user'@'localhost';
FLUSH PRIVILEGES;
```

### 3. Configure WordPress

```bash
# Copy the sample config
cp wp-config-sample.php wp-config.php

# Edit wp-config.php with your database credentials
# Or use WP-CLI:
wp config create --dbname=cg_aesthetics --dbuser=cg_user --dbpass=your_secure_password
```

### 4. Install WordPress

Visit `http://localhost:8000` in your browser and complete the installation, or use WP-CLI:

```bash
wp core install \
  --url="http://localhost:8000" \
  --title="CG Aesthetics" \
  --admin_user="admin" \
  --admin_password="secure_password" \
  --admin_email="admin@cg-aesthetics.local"
```

### 5. Install Required Plugins

#### Via WP-CLI

```bash
# Install WPGraphQL
wp plugin install wp-graphql --activate

# Install ACF (Free or Pro with license)
wp plugin install advanced-custom-fields --activate
# Or upload ACF Pro via wp-admin

# Install Yoast SEO
wp plugin install wordpress-seo --activate

# Activate Amelia (if already uploaded)
wp plugin activate ameliabooking
```

#### Via WP Admin Dashboard

1. Navigate to **Plugins > Add New**
2. Search and install: WPGraphQL, ACF, Yoast SEO
3. Upload premium plugins (ACF Pro, Yoast SEO Premium, Amelia) via **Plugins > Add New > Upload Plugin**

### 6. Activate the Headless Theme

```bash
# Theme is located at: wp-content/themes/cg-aesthetics-headless/
wp theme activate cg-aesthetics-headless
```

### 7. Load ACF Fields

ACF field groups are auto-registered via `acf-fields.php` in the theme.

**Fields are automatically exposed to GraphQL** with manual registration in `functions.php`:

```php
// Already configured in functions.php
register_graphql_field('Service', 'serviceDetails', [...]);
```

**ACF Field Structure:**

- **Service Details** (Field Group)
  - Service Duration (Number)
  - Service Price (Number)
  - Service Description (Textarea)
  - Service Benefits (Repeater)
  - Featured Service (True/False)

### 8. Configure Permalinks

```bash
wp rewrite structure '/%postname%/' --hard
wp rewrite flush
```

### 9. Configure GraphQL

1. Navigate to **GraphQL > Settings** in WordPress admin
2. Enable "Public Introspection" for development
3. Endpoint is automatically set to `/graphql`
4. Test at: `http://localhost:8000/graphql`

### 10. Configure Yoast SEO

1. Navigate to **SEO > General > Features**
2. Enable: XML sitemaps, Breadcrumbs, REST API
3. Configure **SEO > Search Appearance**:
   - Set default meta descriptions
   - Configure Schema.org settings
   - Enable LocalBusiness Schema
4. See `agent-docs/YOAST-SETUP.md` for detailed configuration

### 11. Configure Amelia Booking

1. Navigate to **Amelia > Settings**
2. Set business hours: Monday-Friday 9:00-18:00
3. Configure services and connect to WordPress Services
4. Set up email notifications (SMTP recommended)
5. Test booking flow

## Plugins Summary

| Plugin                      | Version | Purpose                     | Status    | License  |
| --------------------------- | ------- | --------------------------- | --------- | -------- |
| WPGraphQL                   | 2.3.8+  | GraphQL API for WordPress   | Installed | Free     |
| Advanced Custom Fields Pro  | 6.6.0+  | Custom fields management    | Installed | Premium  |
| Yoast SEO Premium           | Latest  | SEO optimization & Schema   | Installed | Premium  |
| Amelia Booking              | 1.2.34+ | Appointment booking system  | Installed | Premium  |
| ~~WPGraphQL for ACF~~       | N/A     | ~~ACF GraphQL integration~~ | Not used  | ~~Free~~ |
| WPGraphQL CORS _(optional)_ | Latest  | Enhanced CORS control       | Optional  | Free     |

**Important Notes:**

- ACF fields are **manually registered to GraphQL** in `functions.php` (no WPGraphQL for ACF plugin needed)
- Premium plugin licenses required for ACF Pro, Yoast SEO Premium, and Amelia
- WPGraphQL CORS only needed for production with different frontend domain

## Content Model

### Custom Post Types

**Services (`spa_service`):**

```php
// Registered in functions.php
register_post_type('spa_service', [
    'show_in_graphql' => true,
    'graphql_single_name' => 'Service',
    'graphql_plural_name' => 'Services',
    // ... additional configuration
]);
```

**ACF Fields for Services:**

- `serviceDuration` (Number) - Duration in minutes
- `servicePrice` (Number) - Price in CHF
- `serviceDescription` (Textarea) - Detailed description
- `serviceBenefits` (Repeater) - List of benefits
- `featuredService` (True/False) - Display on homepage

### Taxonomies

**Service Categories (`service_category`):**

```php
// Hierarchical taxonomy for organizing services
register_taxonomy('service_category', 'spa_service', [
    'show_in_graphql' => true,
    'graphql_single_name' => 'ServiceCategory',
    'graphql_plural_name' => 'ServiceCategories',
]);
```

## Docker Commands

```bash
# Start/stop services
docker-compose up -d
docker-compose down

# View logs
docker-compose logs -f wordpress

# Access WP-CLI
docker-compose exec wpcli wp --info

# Backup database
docker-compose exec wpcli wp db export - > backup_$(date +%Y%m%d).sql

# Import database
docker-compose exec -T wpcli wp db import - < backup.sql

# Access container shell
docker-compose exec wordpress bash

# Rebuild containers
docker-compose down
docker-compose up -d --build
```

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

## Configuration

### CORS Setup

CORS headers are configured in `functions.php`:

```php
// Allow frontend domain
$allowed_origins = ['http://localhost:4321'];
if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
}
```

**For production**, add your frontend domain to `$allowed_origins`.

### Environment Variables

Set in `docker-compose.yml`:

```yaml
environment:
  WORDPRESS_DB_HOST: db:3306
  WORDPRESS_DB_NAME: cg_aesthetics
  WORDPRESS_DB_USER: wordpress
  WORDPRESS_DB_PASSWORD: wordpress
  FRONTEND_URL: 'http://localhost:4321'
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

## Verification Checklist

After setup, verify everything works:

- [ ] WordPress admin accessible at `http://localhost:8000/wp-admin`
- [ ] Custom theme `cg-aesthetics-headless` is active
- [ ] WPGraphQL plugin active and GraphiQL IDE accessible
- [ ] ACF fields visible in service post editor
- [ ] Service post type appears in admin menu
- [ ] Service categories can be created
- [ ] GraphQL query returns services with custom fields
- [ ] Yoast SEO settings configured
- [ ] Amelia booking plugin configured
- [ ] CORS headers allow frontend requests

## Next Steps

1. WordPress core configured
2. All required plugins installed
3. Custom post types and taxonomies registered
4. ACF fields configured and GraphQL-enabled
5. SEO and booking systems integrated
6. **Proceed to frontend setup** - See `../frontend/README.md`
7. **Add content** - Create services, configure Amelia
8. **Test integration** - Verify frontend displays WordPress content

## Useful WP-CLI Commands

```bash
# With Docker (add docker-compose exec wpcli prefix)
docker-compose exec wpcli wp core version
docker-compose exec wpcli wp plugin list
docker-compose exec wpcli wp theme list

# Check WordPress installation
wp core version

# List all post types
wp post-type list

# List all taxonomies
wp taxonomy list

# Export/import database
wp db export backup.sql
wp db import backup.sql

# Search and replace URLs (for migration)
wp search-replace 'http://localhost:8000' 'https://cg-aesthetics.ch' --dry-run

# Clear cache
wp cache flush

# Regenerate permalinks
wp rewrite flush

# Check plugin status
wp plugin list --status=active

# Update all plugins
wp plugin update --all
```

## Development Resources

- **[WPGraphQL Documentation](https://www.wpgraphql.com/docs/introduction)** - GraphQL API reference
- **[ACF Documentation](https://www.advancedcustomfields.com/resources/)** - Custom fields guide
- **[Yoast SEO](https://yoast.com/wordpress/plugins/seo/)** - SEO optimization
- **[Amelia Documentation](https://wpamelia.com/documentation/)** - Booking system guide
- **[WordPress Codex](https://codex.wordpress.org/)** - WordPress core reference
- **[Project Dev Guide](../dev-guide.md)** - Complete implementation guide

---
