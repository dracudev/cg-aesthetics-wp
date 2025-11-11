#!/bin/bash

# =============================================================================
# WordPress + Astro Frontend Backup Script
# Creates ZIP files ready for Hostinger deployment
# =============================================================================

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
BACKUP_DIR="${PROJECT_ROOT}/backups"
TIMESTAMP=$(date +%Y%m%d-%H%M%S)
DATE_ONLY=$(date +%Y%m%d)

echo -e "${BLUE}==============================================================================${NC}"
echo -e "${BLUE}  WordPress + Astro Backup Script${NC}"
echo -e "${BLUE}==============================================================================${NC}"
echo ""

# =============================================================================
# Step 1: Create backup directory
# =============================================================================
echo -e "${YELLOW}[1/5] Creating backup directory...${NC}"
mkdir -p "${BACKUP_DIR}"
echo -e "${GREEN}✓ Backup directory ready: ${BACKUP_DIR}${NC}"
echo ""

# =============================================================================
# Step 2: Export WordPress Database
# =============================================================================
echo -e "${YELLOW}[2/5] Exporting WordPress database...${NC}"

# Check if Docker is running
if ! docker compose ps | grep -q "cg-aesthetics-db.*Up"; then
    echo -e "${RED}✗ Error: Docker containers are not running!${NC}"
    echo -e "${YELLOW}  Please start Docker with: docker compose up -d${NC}"
    exit 1
fi

# Fix MySQL authentication if needed
echo "  → Fixing MySQL authentication method..."
docker compose exec -T db mysql -uroot -prootpassword -e \
    "ALTER USER 'wordpress'@'%' IDENTIFIED WITH mysql_native_password BY 'wordpress'; FLUSH PRIVILEGES;" \
    2>/dev/null || true

# Export database
echo "  → Exporting database..."
docker compose exec -T wpcli wp db export backup.sql --quiet

# Copy database to backup folder
docker compose exec -T wpcli cat backup.sql > "${BACKUP_DIR}/database-${TIMESTAMP}.sql"

# Get database size
DB_SIZE=$(du -h "${BACKUP_DIR}/database-${TIMESTAMP}.sql" | cut -f1)
echo -e "${GREEN}✓ Database exported: database-${TIMESTAMP}.sql (${DB_SIZE})${NC}"
echo ""

# =============================================================================
# Step 3: Create WordPress Content ZIP
# =============================================================================
echo -e "${YELLOW}[3/5] Creating WordPress content ZIP...${NC}"

cd "${PROJECT_ROOT}/wordpress"

echo "  → Packing wp-content folder..."
zip -r "${BACKUP_DIR}/wordpress-content-${DATE_ONLY}.zip" \
    wp-content/themes/cg-aesthetics-headless \
    wp-content/plugins/advanced-custom-fields \
    wp-content/plugins/wp-graphql \
    wp-content/plugins/wordpress-seo \
    wp-content/plugins/ameliabooking \
    wp-content/uploads \
    -x "*.git*" "*/cache/*" "*.DS_Store" "*/.htaccess" \
    -q

WP_SIZE=$(du -h "${BACKUP_DIR}/wordpress-content-${DATE_ONLY}.zip" | cut -f1)
echo -e "${GREEN}✓ WordPress content packed: wordpress-content-${DATE_ONLY}.zip (${WP_SIZE})${NC}"
echo ""

# =============================================================================
# Step 4: Build and ZIP Frontend
# =============================================================================
echo -e "${YELLOW}[4/5] Building Astro frontend...${NC}"

cd "${PROJECT_ROOT}/frontend"

# Clean previous builds
rm -rf dist/

# Build production version
echo "  → Running production build..."
pnpm build --silent

# Create ZIP of build
cd dist
zip -r "${BACKUP_DIR}/frontend-build-${DATE_ONLY}.zip" . -q
cd ..

FRONTEND_SIZE=$(du -h "${BACKUP_DIR}/frontend-build-${DATE_ONLY}.zip" | cut -f1)
echo -e "${GREEN}✓ Frontend built and packed: frontend-build-${DATE_ONLY}.zip (${FRONTEND_SIZE})${NC}"
echo ""

# =============================================================================
# Step 5: Create deployment guide
# =============================================================================
echo -e "${YELLOW}[5/5] Generating deployment information...${NC}"

cat > "${BACKUP_DIR}/BACKUP-INFO-${DATE_ONLY}.txt" << EOF
=============================================================================
BACKUP INFORMATION
=============================================================================

Generated: $(date '+%Y-%m-%d %H:%M:%S')
Project: CG Aesthetics (Headless WordPress + Astro)

=============================================================================
BACKUP FILES
=============================================================================

1. database-${TIMESTAMP}.sql (${DB_SIZE})
   - Complete WordPress database dump
   - Includes: posts, pages, services, settings, users
   - Upload to: phpMyAdmin in Hostinger

2. wordpress-content-${DATE_ONLY}.zip (${WP_SIZE})
   - Custom theme: cg-aesthetics-headless
   - Plugins: ACF, WPGraphQL, Yoast SEO, Amelia Booking
   - Media uploads from wp-content/uploads
   - Upload and extract manually via FTP or File Manager

3. frontend-build-${DATE_ONLY}.zip (${FRONTEND_SIZE})
   - Astro production build
   - Optimized and ready for deployment
   - Deploy to: Vercel (recommended) or public_html/

=============================================================================
DEPLOYMENT STEPS
=============================================================================

BACKEND (WordPress on Hostinger):
1. Create MySQL database in hPanel
2. Install WordPress via Auto Installer (PHP 8.2, WordPress 6.8)
3. Upload wordpress-content-${DATE_ONLY}.zip via FTP/File Manager
4. Extract and manually move folders to correct locations
5. Import database-${TIMESTAMP}.sql via phpMyAdmin
6. Edit wp-config.php with your database credentials
7. Update URLs in database (see DEPLOYMENT-GUIDE.md)
8. Login to /wp-admin and verify plugins/theme are active

FRONTEND (Astro):
Option A - Vercel (Recommended):
  $ cd frontend
  $ vercel --prod
  
Option B - Hostinger:
  - Extract frontend-build-${DATE_ONLY}.zip to public_html/
  - Configure .htaccess for routing

=============================================================================
REQUIRED HOSTINGER SETTINGS
=============================================================================

PHP Version: 8.2
WordPress Version: 6.8
MySQL Version: 8.0

Database Credentials (example):
  DB_NAME: u123456_cgaesthetics
  DB_USER: u123456_wp
  DB_PASSWORD: [your-secure-password]
  DB_HOST: localhost

=============================================================================
IMPORTANT NOTES
=============================================================================

- Backup created from local development environment
- All URLs need to be updated from localhost to production
- SSL certificate should be enabled (Let's Encrypt in Hostinger)
- Configure CORS if frontend/backend are on different domains
- Test GraphQL endpoint: https://yourdomain.com/graphql

For detailed instructions, see: DEPLOYMENT-GUIDE.md

=============================================================================
EOF

echo -e "${GREEN}✓ Deployment information saved: BACKUP-INFO-${DATE_ONLY}.txt${NC}"
echo ""

# =============================================================================
# Summary
# =============================================================================
echo -e "${BLUE}==============================================================================${NC}"
echo -e "${GREEN}  ✓ BACKUP COMPLETED SUCCESSFULLY${NC}"
echo -e "${BLUE}==============================================================================${NC}"
echo ""
echo -e "Backup location: ${BACKUP_DIR}"
echo ""
echo "Files created:"
echo "  1. database-${TIMESTAMP}.sql (${DB_SIZE})"
echo "  2. wordpress-content-${DATE_ONLY}.zip (${WP_SIZE})"
echo "  3. frontend-build-${DATE_ONLY}.zip (${FRONTEND_SIZE})"
echo "  4. BACKUP-INFO-${DATE_ONLY}.txt"
echo ""
echo -e "${YELLOW}Total backup size:${NC}"
du -sh "${BACKUP_DIR}" | awk '{print "  " $1}'
echo ""
echo -e "${GREEN}Ready to deploy to Hostinger!${NC}"
echo -e "See ${BACKUP_DIR}/DEPLOYMENT-GUIDE.md for detailed instructions."
echo ""
