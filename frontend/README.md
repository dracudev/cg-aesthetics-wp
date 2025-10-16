# CG Aesthetics - Frontend (Astro)

Modern, performant frontend built with Astro 4.x, TypeScript, Tailwind CSS, and GraphQL. Luxury spa aesthetic with optimal SEO and user experience.

## Features

- **Astro 4.x** - Static Site Generation with TypeScript strict mode
- **Tailwind CSS 4.x** - OKLCH color space with custom design tokens
- **shadcn/ui** - Adapted components for Astro (Button, Card, Input, etc.)
- **GraphQL** - Apollo Client with WordPress headless CMS
- **SEO Optimized** - Schema.org, OpenGraph, sitemap, robots.txt
- **Accessible** - Semantic HTML, ARIA labels, keyboard navigation
- **Responsive** - Mobile-first design with Tailwind breakpoints
- **Fast** - Optimized images, lazy loading, minimal JavaScript

## Quick Start

```bash
# Install dependencies
pnpm install

# Start development server (http://localhost:4321)
pnpm dev

# Build for production
pnpm build

# Preview production build
pnpm preview

# Type checking
pnpm check
```

## Configuration

Create `.env` file in the frontend directory:

```env
PUBLIC_WORDPRESS_URL=http://localhost:8000
PUBLIC_GRAPHQL_ENDPOINT=http://localhost:8000/graphql
```

**Production example:**

```env
PUBLIC_WORDPRESS_URL=https://admin.cg-aesthetics.ch
PUBLIC_GRAPHQL_ENDPOINT=https://admin.cg-aesthetics.ch/graphql
```

## Project Structure

```
frontend/
├── src/
│   ├── components/           # Reusable UI components
│   │   ├── ui/              # shadcn/ui adapted components
│   │   │   ├── button.tsx
│   │   │   ├── card.tsx
│   │   │   ├── input.tsx
│   │   │   ├── label.tsx
│   │   │   ├── textarea.tsx
│   │   │   ├── sheet.tsx
│   │   │   └── separator.tsx
│   │   ├── SEO.astro         # SEO meta tags + Schema.org
│   │   ├── Navbar.tsx        # Navigation with mobile menu
│   │   ├── Footer.tsx        # Footer with links and info
│   │   └── OptimizedImage.astro  # Responsive image component
│   ├── layouts/
│   │   └── Layout.astro      # Base layout with SEO and fonts
│   ├── pages/                # File-based routing
│   │   ├── index.astro       # Homepage
│   │   ├── a-propos.astro    # About page
│   │   ├── contact.astro     # Contact page
│   │   ├── reserver.astro    # Booking page
│   │   └── services/
│   │       ├── index.astro   # Services listing
│   │       └── [slug].astro  # Dynamic service details
│   ├── lib/
│   │   ├── apollo-client.ts  # GraphQL client setup
│   │   ├── queries.ts        # GraphQL queries
│   │   ├── seo.ts            # Schema.org helpers
│   │   └── utils.ts          # Utility functions (cn, etc.)
│   ├── styles/
│   │   └── global.css        # Tailwind + custom CSS variables
│   └── types/
│       └── wordpress.ts      # TypeScript definitions for WP data
├── public/
│   ├── robots.txt            # Search engine directives
│   └── site.webmanifest      # PWA manifest
├── astro.config.mjs          # Astro configuration
├── tailwind.config.mjs       # Tailwind CSS config
├── tsconfig.json             # TypeScript config (strict mode)
├── components.json           # shadcn/ui configuration
└── package.json              # Dependencies and scripts
```

## Design System

**Typography:**

- **Headings:** Cormorant Garamond (elegant serif)
- **Body:** Montserrat (clean sans-serif)
- **Loaded via:** Google Fonts (preconnect optimization)

**Colors (OKLCH):**

```css
--rose-gold: oklch(0.78 0.07 45); /* #d4af8e */
--mauve: oklch(0.65 0.12 15); /* #a67c7c */
--blush-pink: oklch(0.92 0.05 25); /* #f4d7d7 */
--cream: oklch(0.97 0.02 85); /* #f9f8f6 */
--charcoal: oklch(0.3 0.01 260); /* #3a3a3a */
```

**Component Patterns:**

- All buttons wrapped in `<a>` tags for navigation
- Card components with optional `noTopPadding` prop
- Labels with built-in `mb-2` spacing
- Buttons with `cursor-pointer` and disabled states

## Components

**shadcn/ui Adapted:**

- `Button` - Variants: default, destructive, outline, secondary, ghost, link
- `Card` - CardHeader, CardTitle, CardDescription, CardContent, CardFooter
- `Input` - Form input with proper styling
- `Label` - Form label with spacing
- `Textarea` - Multi-line text input
- `Sheet` - Mobile menu drawer
- `Separator` - Visual divider

**Custom Components:**

- `SEO.astro` - Meta tags, OpenGraph, Schema.org structured data
- `Navbar.tsx` - Responsive navigation with mobile sheet menu
- `Footer.tsx` - Site footer with contact info and links
- `OptimizedImage.astro` - Responsive images with srcset

## GraphQL Integration

**Apollo Client Setup:**

```typescript
// src/lib/apollo-client.ts
const client = new ApolloClient({
  uri: import.meta.env.PUBLIC_GRAPHQL_ENDPOINT,
  cache: new InMemoryCache(),
});
```

**Query Examples:**

```typescript
// Fetch all services
const { data } = await client.query({
  query: GET_ALL_SERVICES,
});

// Fetch single service by slug
const { data } = await client.query({
  query: GET_SERVICE_BY_SLUG,
  variables: { slug },
});
```

**Custom Fields (ACF):**

- `serviceDuration` - Duration in minutes
- `servicePrice` - Price in CHF
- `serviceDescription` - Detailed description
- `serviceBenefits` - List of benefits (repeater)
- `featuredService` - Boolean for homepage display

## SEO Implementation

**Meta Tags:**

- Title, description, canonical URL
- OpenGraph (og:title, og:image, og:type)
- Twitter Cards (twitter:card, twitter:title)

**Schema.org Structured Data:**

- `LocalBusiness` - Business information
- `Service` - Individual service offerings
- `Person` - Founder profile
- `AggregateRating` - Reviews and ratings

**Sitemap & Robots:**

- XML sitemap auto-generated by Astro
- `robots.txt` configured for search engines
- Canonical URLs for duplicate content

## Performance

**Optimization Strategies:**

- Static site generation (SSG) for all pages
- Optimized images with responsive srcset
- Minimal JavaScript (only for interactivity)
- Lazy loading for below-the-fold content
- Preconnect to Google Fonts
- Inline critical CSS

**Build Output:**

```bash
pnpm build
# Output: dist/ directory ready for deployment
```

## Development Scripts

```bash
# Development with hot reload
pnpm dev

# Type checking
pnpm check

# Build for production
pnpm build

# Preview production build locally
pnpm preview

# Add Astro integration
pnpm astro add [integration]
```

## Resources

- **[Astro Documentation](https://docs.astro.build/)** - Official Astro docs
- **[Tailwind CSS](https://tailwindcss.com/)** - Utility-first CSS framework
- **[shadcn/ui](https://ui.shadcn.com/)** - Re-usable components
- **[Apollo Client](https://www.apollographql.com/docs/react/)** - GraphQL client
- **[Project Dev Guide](../dev-guide.md)** - Complete implementation guide
- **[WordPress Setup](../wordpress/README.md)** - Backend configuration

## Troubleshooting

**GraphQL connection issues:**

```bash
# Verify environment variables
cat .env

# Test GraphQL endpoint
curl -X POST $PUBLIC_GRAPHQL_ENDPOINT \
  -H "Content-Type: application/json" \
  -d '{"query":"{ services(first: 1) { nodes { title } } }"}'
```

**Build errors:**

```bash
# Clear Astro cache
rm -rf .astro node_modules/.vite

# Reinstall dependencies
pnpm install

# Try building again
pnpm build
```

**Type errors:**

```bash
# Run type checking
pnpm check

# Regenerate TypeScript definitions if needed
```

---
