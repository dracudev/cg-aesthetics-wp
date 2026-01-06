# WordPress Data Caching System

This project implements a local caching system for WordPress data to enable reliable offline builds and prevent build failures due to network issues.

## Overview

Instead of querying WordPress GraphQL API during every build, you can:

1. Fetch all data once and save it as JSON
2. Build your site using the cached data
3. Work offline with cached data and production image URLs

## Quick Start

### 1. Cache WordPress Data

Fetch all data from WordPress and save it locally:

```bash
pnpm cache:wp
```

This creates `src/data/wp-cache.json` with all services, testimonials, settings, etc.

### 2. Build with Cached Data

Build your site using the cached data (no internet required):

```bash
pnpm build:cached
```

Or combine both steps:

```bash
pnpm cache:build
```

### 3. Regular Build (Live Data)

To build with live WordPress data:

```bash
pnpm build
```

## Available Scripts

| Command             | Description                                |
| ------------------- | ------------------------------------------ |
| `pnpm cache:wp`     | Fetch all WordPress data and save to cache |
| `pnpm build:cached` | Build using cached WordPress data          |
| `pnpm cache:build`  | Cache data then build (one command)        |
| `pnpm build`        | Build with live WordPress data             |
| `pnpm dev`          | Development server (uses live data)        |

## How It Works

### Data Fetching

The caching script (`scripts/cache-wordpress-data.ts`) fetches:

- All services and service categories
- Team members
- Testimonials
- Site settings (title, description, etc.)
- Hero images

### Cache Storage

Data is stored in `src/data/wp-cache.json` with:

- All WordPress content
- Timestamp of when it was cached
- WordPress URL for reference

### Build Process

When building with cached data:

1. Apollo client checks `PUBLIC_USE_WP_CACHE` environment variable
2. If enabled, it loads data from `wp-cache.json`
3. **Localhost URLs are automatically replaced with production URLs** from `PUBLIC_WORDPRESS_URL`
4. Queries are mapped to cached data instead of making API calls
5. Images use production URLs (work offline)
6. Fallback data is provided for missing fields

### URL Replacement

**Important:** If you cache data from localhost (`http://localhost:8000`), the system automatically replaces these URLs with your production URL when building:

- Cache source: `http://localhost:8000/wp-content/uploads/image.jpg`
- Build output: `https://carmeng-beauty.com/wp-content/uploads/image.jpg`

This ensures images work in production even if cached from local development.

### Fallbacks

The system includes fallbacks for:

- Missing images (uses Unsplash placeholders)
- Missing fields (empty strings or default values)
- Network failures (automatically falls back to cache)

## Configuration

### Enable Caching Globally

Edit `.env` to enable cached builds by default:

```env
PUBLIC_USE_WP_CACHE=true
```

### Cache Location

Cache file: `src/data/wp-cache.json`

This file is gitignored by default but can be committed for deployment caching.

## Production Deployment

### Option 1: Cache During Build

Most CI/CD platforms have internet access, so you can cache during deployment:

```bash
pnpm cache:build
```

### Option 2: Commit Cache

For faster builds or limited CI environments:

1. Remove `src/data/wp-cache.json` from `.gitignore`
2. Cache locally: `pnpm cache:wp`
3. Commit the cache file
4. Deploy using: `pnpm build:cached`

### Option 3: Hybrid Approach

Use live data in CI but have cache as backup:

```bash
pnpm build || pnpm build:cached
```

## Benefits

✅ **Reliable Builds**: No more build failures from WordPress timeouts  
✅ **Offline Development**: Work without internet connection  
✅ **Faster Builds**: No network latency during build  
✅ **Cost Savings**: Reduced API calls to WordPress server  
✅ **Consistent Builds**: Same data across multiple builds  
✅ **Easy Rollback**: Commit cache files for reproducible builds

## Cache Validation

Check cache status:

```bash
ls -lh src/data/wp-cache.json
```

View cache timestamp and data:

```bash
cat src/data/wp-cache.json | grep -A 2 "cachedAt"
```

## Troubleshooting

### "No cache file found" Error

Run `pnpm cache:wp` to create the cache.

### Build Still Queries WordPress

Ensure `PUBLIC_USE_WP_CACHE=true` is set when running build:

```bash
PUBLIC_USE_WP_CACHE=true pnpm build
```

Or use the dedicated command:

```bash
pnpm build:cached
```

### Cache Data is Stale

Re-cache to get latest data:

```bash
pnpm cache:wp
```

### Images Not Loading

Images use production URLs from cache. Ensure `PUBLIC_WORDPRESS_URL` is set correctly in `.env`.

## Best Practices

1. **Regular Updates**: Re-cache after content changes in WordPress
2. **Version Control**: Consider committing cache for deployment consistency
3. **CI/CD**: Use `cache:build` in deployment pipelines
4. **Development**: Use live data (`pnpm dev`) during development
5. **Production**: Use cached data (`pnpm build:cached`) for deployments

## Technical Details

### Query Mapping

Queries are automatically mapped to cached data:

- `GET_SERVICES` → `cache.services`
- `GET_SERVICE_BY_SLUG` → Filtered from `cache.services.nodes`
- `GET_FEATURED_SERVICES` → Filtered featured services
- `GET_TESTIMONIALS` → `cache.testimonials`
- `GET_SITE_SETTINGS` → `cache.siteSettings`
- `GET_HERO_IMAGES` → `cache.heroImages`

### Fallback Strategy

1. Try cached data (if `PUBLIC_USE_WP_CACHE=true`)
2. If no cache, query WordPress live
3. If live query fails, try cache as fallback
4. If all fails, use fallback placeholders

### Image Handling

- Production URLs are preserved in cache
- Images work offline (served from WordPress server)
- Fallback images (Unsplash) for missing images
- Image optimization params preserved

## Example Workflow

```bash
# 1. Fetch latest WordPress content
pnpm cache:wp

# 2. Test build with cache
pnpm build:cached

# 3. Preview
pnpm preview

# 4. Deploy
git add src/data/wp-cache.json
git commit -m "Update WordPress cache"
git push
```

## Support

For issues or questions, check:

- Cache file exists: `ls src/data/wp-cache.json`
- Environment variables: `cat .env`
- Build logs for error messages
