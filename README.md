# CG Aesthetics Website

Modern luxury spa website built with Headless WordPress (GraphQL API) and Astro for optimal performance, SEO, and user experience.

## Project Structure

```
cg-aesthetics-wp/
├── docker-compose.yml          # Docker setup for WordPress + MySQL
├── dev-guide.md                # Complete development guide & progress tracking
├── wordpress/                  # WordPress backend (Headless CMS)
│   ├── wp-content/
│   │   ├── themes/
│   │   │   └── cg-aesthetics-headless/  # Custom headless theme
│   │   ├── plugins/            # WPGraphQL, ACF Pro, Amelia, Yoast SEO
│   │   └── uploads/            # Media uploads
│   └── README.md               # WordPress setup instructions
├── frontend/                   # Astro 4.x frontend application
│   ├── src/
│   │   ├── components/         # shadcn/ui adapted components + custom
│   │   ├── layouts/            # Layout.astro with SEO
│   │   ├── pages/              # 5 core pages (index, services, about, contact, booking)
│   │   ├── lib/                # Apollo Client, queries, utils, SEO helpers
│   │   ├── styles/             # Tailwind CSS with custom design tokens
│   │   └── types/              # TypeScript definitions
│   ├── public/                 # robots.txt, sitemap, manifest
│   └── package.json
└── agent-docs/                 # Implementation guides & SEO documentation
```

## Prerequisites

- **Docker + Docker Compose**
- **Node.js** 18+ and **pnpm**
- **Git**

## Quick Start

### 1. Clone and Setup

```bash
git clone https://github.com/dracudev/cg-aesthetics-wp.git
cd cg-aesthetics-wp
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

- **Site Title:** CG Aesthetics
- **Username:** admin
- **Password:** (choose a secure password)
- **Email:** <your-email@example.com>

Or use WP-CLI:

```bash
# Run WordPress installation via WP-CLI
docker-compose exec wpcli wp core install \
  --url="http://localhost:8000" \
  --title="CG Aesthetics" \
  --admin_user="admin" \
  --admin_password="SecurePass123!" \
  --admin_email="admin@cg-aesthetics.local" \
  --skip-email
```

### 4. Install Required Plugins

```bash
# Install WPGraphQL
docker-compose exec wpcli wp plugin install wp-graphql --activate

# Install ACF (free version - Pro requires license)
docker-compose exec wpcli wp plugin install advanced-custom-fields --activate

# Activate custom theme
docker-compose exec wpcli wp theme activate cg-aesthetics-headless

# Flush permalinks
docker-compose exec wpcli wp rewrite structure '/%postname%/' --hard
docker-compose exec wpcli wp rewrite flush
```

**Note:**

- **ACF fields are manually registered to GraphQL** in `functions.php` (no WPGraphQL for ACF plugin needed due to compatibility issues)
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

## Docker Commands

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

## Frontend Development (pnpm)

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

## Configuration

### WordPress Configuration

WordPress environment variables are set in `docker-compose.yml`. To modify:

```yaml
environment:
  WORDPRESS_DB_HOST: db:3306
  WORDPRESS_DB_NAME: cg_aesthetics
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

## Content Model

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

## WordPress Plugins

| Plugin                      | Purpose                      | Version | Status    | Notes                          |
| --------------------------- | ---------------------------- | ------- | --------- | ------------------------------ |
| WPGraphQL                   | GraphQL API                  | 2.3.8+  | Installed | Core headless functionality    |
| Advanced Custom Fields Pro  | Custom field management      | 6.6.0+  | Installed | Manual GraphQL registration    |
| Yoast SEO Premium           | SEO optimization             | Latest  | Installed | Schema.org, XML sitemaps       |
| Amelia Booking              | Appointment booking system   | 1.2.34+ | Installed | Integrated with services       |
| ~~WPGraphQL for ACF~~       | Expose ACF fields to GraphQL | N/A     | Not used  | Fields registered in functions |
| WPGraphQL CORS _(optional)_ | Enhanced CORS control        | Latest  | Optional  | For production deployment      |

## Tech Stack

**Backend:**

- WordPress 6.4+ (Headless CMS)
- MySQL 8.0
- PHP 8.0+
- WPGraphQL 2.3.8+
- ACF Pro 6.6.0+
- Yoast SEO Premium
- Amelia Booking v1.2.34+

**Frontend:**

- Astro 4.x (Static Site Generation)
- TypeScript (Strict mode)
- Tailwind CSS 4.x with OKLCH color space
- shadcn/ui components (adapted for Astro)
- Apollo Client (GraphQL)
- React 18+ (for interactive components)
- Lucide React (icons)

**Design System:**

- Typography: Cormorant Garamond (headings) + Montserrat (body)
- Colors: Rose gold (#d4af8e), Mauve (#a67c7c), Blush pink (#f4d7d7)
- Responsive: Mobile-first with Tailwind breakpoints
- Components: Button, Card, Input, Label, Textarea, Sheet, Separator

**DevOps:**

- Docker & Docker Compose
- pnpm (Package manager)
- Git (version control)

## Development Workflow

1. **Backend Development:**

   - Modify theme files in `wordpress/wp-content/themes/cg-aesthetics-headless/`
   - Update ACF fields, custom post types, taxonomies
   - Changes are automatically reflected (Docker volume mounted)
   - Test GraphQL queries at <http://localhost:8000/graphql>
   - Configure Yoast SEO settings and Schema.org

2. **Frontend Development:**

   - Work in `frontend/src/` (components, pages, layouts)
   - Hot reload enabled with `pnpm dev` at <http://localhost:4321>
   - Component development with shadcn/ui patterns
   - Type-safe GraphQL queries with TypeScript
   - Build and preview before deployment: `pnpm build && pnpm preview`

3. **Content Management:**

   - WordPress admin: <http://localhost:8000/wp-admin>
   - Create/edit services with ACF custom fields
   - Manage Amelia booking appointments
   - Optimize SEO with Yoast (meta titles, descriptions, Schema.org)
   - Content is immediately available via GraphQL API

4. **Documentation:**
   - See `dev-guide.md` for complete implementation details
   - Review `frontend/README.md` for Astro-specific documentation

## License

Private project for CG Aesthetics

---
