# Serenity Spa - WordPress Headless CMS + Astro Frontend

Modern spa website built with Headless WordPress (GraphQL API) and Astro for optimal performance.

## 🚀 Project Structure

```tree
serenity-spa-wp/
├── docker-compose.yml          # Docker setup for WordPress + MySQL
├── wordpress/                  # WordPress backend (Headless CMS)
│   ├── wp-content/
│   │   ├── themes/
│   │   │   └── serenity-spa-headless/  # Custom headless theme
│   │   ├── plugins/            # WordPress plugins (WPGraphQL, ACF)
│   │   └── uploads/            # Media uploads
│   └── README.md               # WordPress setup instructions
├── frontend/                   # Astro frontend application
│   ├── src/
│   │   ├── components/         # Reusable UI components
│   │   ├── layouts/            # Page layouts
│   │   ├── pages/              # Route pages
│   │   └── lib/                # Utilities and GraphQL client
│   ├── public/                 # Static assets
│   └── package.json
└── PROJECT_SCOPE.md            # Complete project documentation
```

## 📋 Prerequisites

- **Docker Desktop** (recommended) or Docker + Docker Compose
- **Node.js** 18+ and **pnpm**
- **Git**

## ✅ Current Status

**Phase 2.4** - Content Population in progress

- ✅ Docker environment running
- ✅ WordPress installed and configured
- ✅ Custom post types and taxonomies created
- ✅ ACF fields manually registered to GraphQL
- ✅ Astro frontend connected to WordPress
- 📝 Ready for content creation

## 🛠️ Quick Start

### 1. Clone and Setup

```bash
cd /home/dracudev/dev/serenity-spa-wp
```

### 2. Start WordPress with Docker

```bash
# Start all services (WordPress, MySQL, phpMyAdmin)
docker-compose up -d

# Check if containers are running
docker-compose ps
```

Services will be available at:

- **WordPress:** <http://localhost:8000>
- **phpMyAdmin:** <http://localhost:8080>
- **GraphQL Endpoint:** <http://localhost:8000/graphql> (after plugin installation)

### 3. Install WordPress

Visit <http://localhost:8000> and complete the installation:

- **Site Title:** Serenity Spa
- **Username:** admin
- **Password:** (choose a secure password)
- **Email:** <your-email@example.com>

Or use WP-CLI:

```bash
# Run WordPress installation via WP-CLI
docker-compose exec wpcli wp core install \
  --url="http://localhost:8000" \
  --title="Serenity Spa" \
  --admin_user="admin" \
  --admin_password="SecurePass123!" \
  --admin_email="admin@serenityspa.local" \
  --skip-email
```

### 4. Install Required Plugins

```bash
# Install WPGraphQL
docker-compose exec wpcli wp plugin install wp-graphql --activate

# Install ACF (free version - Pro requires license)
docker-compose exec wpcli wp plugin install advanced-custom-fields --activate

# Activate custom theme
docker-compose exec wpcli wp theme activate serenity-spa-headless

# Flush permalinks
docker-compose exec wpcli wp rewrite structure '/%postname%/' --hard
docker-compose exec wpcli wp rewrite flush
```

**Note:**

- ✅ **ACF fields are manually registered to GraphQL** in `functions.php` (no WPGraphQL for ACF plugin needed due to compatibility issues)
- If you have ACF Pro license, you can install it from <https://www.advancedcustomfields.com/my-account/>

### 5. Create Service Categories

```bash
docker-compose exec wpcli wp term create service_category "Facials" --description="Facial treatments and skincare"
docker-compose exec wpcli wp term create service_category "Massages" --description="Relaxing massage therapies"
docker-compose exec wpcli wp term create service_category "Body Treatments" --description="Full body wellness treatments"
docker-compose exec wpcli wp term create service_category "Wellness Packages" --description="Complete spa experiences"
```

### 6. Test GraphQL Endpoint

Visit <http://localhost:8000/graphql> and run this test query:

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
    }
  }
}
```

### 7. Setup Astro Frontend

```bash
cd frontend

# Install dependencies with pnpm
pnpm install

# Start development server
pnpm dev
```

The frontend will be available at: <http://localhost:4321>

## 🐳 Docker Commands

```bash
# Start services
docker-compose up -d

# Stop services
docker-compose down

# View logs
docker-compose logs -f wordpress

# Restart services
docker-compose restart

# Run WP-CLI commands
docker-compose exec wpcli wp --info

# Access WordPress container shell
docker-compose exec wordpress bash

# Backup database
docker-compose exec wpcli wp db export - > backup.sql

# Import database
docker-compose exec -T wpcli wp db import - < backup.sql

# Remove all containers and volumes (CAUTION: Deletes all data)
docker-compose down -v
```

## 📦 Frontend Development (pnpm)

```bash
cd frontend

# Install dependencies
pnpm install

# Development server
pnpm dev

# Build for production
pnpm build

# Preview production build
pnpm preview

# Add Astro integrations
pnpm astro add tailwind
pnpm astro add react

# Type checking
pnpm check
```

## 🔧 Configuration

### WordPress Configuration

WordPress environment variables are set in `docker-compose.yml`. To modify:

```yaml
environment:
  WORDPRESS_DB_HOST: db:3306
  WORDPRESS_DB_NAME: serenity_spa
  WORDPRESS_DB_USER: wordpress
  WORDPRESS_DB_PASSWORD: wordpress
  FRONTEND_URL: 'http://localhost:4321'
```

### Frontend Configuration

Create `frontend/.env`:

```env
PUBLIC_WORDPRESS_URL=http://localhost:8000
PUBLIC_GRAPHQL_ENDPOINT=http://localhost:8000/graphql
```

## 📚 Content Model

### Custom Post Types

1. **Services** (`spa_service`)

   - Title, Description, Duration, Price
   - Categories, Gallery, Booking options

2. **Team Members** (`team_member`)

   - Name, Position, Bio, Photo
   - Specialties, Certifications

3. **Testimonials** (`testimonial`)
   - Client Name, Review Text, Rating
   - Related Service, Featured status

### Taxonomies

- **Service Categories** (`service_category`)
  - Hierarchical taxonomy for organizing services

## 🔌 WordPress Plugins

| Plugin                 | Purpose                      | Status         | Notes                    |
| ---------------------- | ---------------------------- | -------------- | ------------------------ |
| WPGraphQL              | GraphQL API                  | ✅ Installed   | v2.3.8                   |
| Advanced Custom Fields | Custom field management      | ✅ Installed   | v6.6.0 (Free)            |
| ~~WPGraphQL for ACF~~  | Expose ACF fields to GraphQL | ❌ Not needed  | Manual registration used |
| Yoast SEO or Rank Math | SEO optimization             | 🔵 Recommended | Not yet installed        |
| Amelia or Bookly       | Booking system               | 📅 Phase 2.3   | Future phase             |

## 🎨 Tech Stack

**Backend:**

- WordPress 6.4+ (Headless CMS)
- MySQL 8.0
- PHP 8.0+
- WPGraphQL

**Frontend:**

- Astro 4.x
- TypeScript (Strict mode)
- Tailwind CSS
- Apollo Client (GraphQL)
- React (for interactive components)

**DevOps:**

- Docker & Docker Compose
- pnpm (Package manager)
- Git

## 📖 Development Workflow

1. **Backend Development:**

   - Modify theme files in `wordpress/wp-content/themes/serenity-spa-headless/`
   - Changes are automatically reflected (volume mounted)
   - Test GraphQL queries at <http://localhost:8000/graphql>

2. **Frontend Development:**

   - Work in `frontend/src/`
   - Hot reload enabled with `pnpm dev`
   - Build and preview before deployment

3. **Content Management:**
   - Log into WordPress admin at <http://localhost:8000/wp-admin>
   - Create services, team members, testimonials
   - Content is immediately available via GraphQL

## 🚨 Troubleshooting

### WordPress container won't start

```bash
# Check logs
docker-compose logs wordpress

# Rebuild containers
docker-compose down
docker-compose up -d --build
```

### GraphQL not working

```bash
# Flush permalinks
docker-compose exec wpcli wp rewrite flush

# Check plugin status
docker-compose exec wpcli wp plugin list

# Reinstall WPGraphQL
docker-compose exec wpcli wp plugin deactivate wp-graphql
docker-compose exec wpcli wp plugin activate wp-graphql
```

### Permission issues with uploads

```bash
# Fix file permissions
docker-compose exec wordpress chown -R www-data:www-data /var/www/html/wp-content/uploads
```

### Frontend can't connect to WordPress

- Check `frontend/.env` has correct `PUBLIC_GRAPHQL_ENDPOINT`
- Verify CORS settings in `functions.php`
- Test GraphQL endpoint in browser: <http://localhost:8000/graphql>

## 🔐 Security Notes

- Change default database passwords in production
- Use strong WordPress admin password
- Don't commit `.env` files with sensitive data
- Enable HTTPS in production
- Use WordPress security plugins
- Keep all plugins and WordPress core updated

## 📄 Alternative: Local WP / WordPress Studio

If you prefer a GUI tool instead of Docker:

1. Download **Local WP** (by WP Engine): <https://localwp.com/>
2. Create new site: "Serenity Spa"
3. Copy theme from `wordpress/wp-content/themes/serenity-spa-headless/` to Local WP's themes folder
4. Install plugins via Local WP admin panel
5. Update `frontend/.env` with Local WP's URL (e.g., <http://serenity-spa.local>)

## 📚 Documentation

- [PROJECT_SCOPE.md](./PROJECT_SCOPE.md) - Complete project scope and phases
- [wordpress/README.md](./wordpress/README.md) - WordPress setup details
- [WPGraphQL Docs](https://www.wpgraphql.com/)
- [Astro Docs](https://docs.astro.build/)
- [ACF Docs](https://www.advancedcustomfields.com/resources/)

## 🤝 Contributing

1. Create feature branch
2. Make changes
3. Test thoroughly
4. Submit pull request

## 📝 License

Private project for Serenity Spa

## 🆘 Support

For issues or questions, refer to:

- Project documentation in `PROJECT_SCOPE.md`
- WordPress README in `wordpress/README.md`
- Contact project lead

---
