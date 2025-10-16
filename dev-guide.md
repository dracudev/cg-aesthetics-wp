# CG Aesthetics Website - Project Scope Document

## Executive Summary

**Project Name:** CG Aesthetics Website  
**Project Goal:** Launch a modern, fast website using Headless WordPress and Astro to increase online bookings  
**Current Status:** Phase 4 Complete - All Core Pages Implemented  
**Technology Stack:** Headless WordPress (Backend/CMS) + Astro (Frontend) + GraphQL API

---

## Recent Achievements (October 2025)

### Completed Features

✅ **All Core Pages Implemented:**

- Homepage with hero, featured services, testimonials, and CTAs
- Services listing and individual service detail pages
- Booking/reservation page with Amelia integration
- About Us page with founder profile and company values
- Contact page with form, business info, and Google Maps

✅ **UI/UX Enhancements:**

- Card component with smart padding system (noTopPadding prop)
- Label component with built-in spacing (mb-2)
- Button component with cursor pointer
- All navigation buttons properly wrapped in anchor tags
- Improved spacing in contact cards and form elements

✅ **Content & Business Information:**

- Business hours updated (Monday-Friday 9:00-18:00)
- Contact information verified and integrated
- Schema.org structured data for all pages
- SEO metadata for all pages

✅ **Design System:**

- Complete implementation across all pages
- OKLCH color system with luxury spa aesthetic
- Fluid typography with responsive scaling
- Consistent spacing and shadows
- Interactive element styling

---

## Project Overview

This project aims to deliver a high-performance, SEO-optimized website for CG Aesthetics that showcases services, builds trust through testimonials, and facilitates seamless online booking. The headless architecture will provide editorial flexibility while ensuring optimal frontend performance.

---

## Minimum Viable Product (MVP) Scope

### Website Pages

1. **Homepage**

   - Hero section with compelling imagery
   - Featured services showcase
   - Customer testimonials carousel
   - Call-to-action for booking

2. **Services Page**

   - Detailed list of all treatments
   - Service descriptions, duration, and pricing
   - Filterable by category (Facials, Massages, etc.)
   - Individual service detail views

3. **About Us Page**

   - Spa philosophy and values
   - Team member profiles with photos and bios
   - Brand story

4. **Contact Page**

   - Physical address and business hours
   - Embedded Google Maps
   - Contact form
   - Phone number and email

5. **Booking System**
   - Multi-step booking process
   - Service selection
   - Date and time picker
   - Customer information form
   - Confirmation page

---

## Project Phases & Tasks

### **Phase 1: Planning & Architecture (Week 1)**

#### Tasks

- [x] Finalize design requirements and wireframes
- [x] Define WordPress content model architecture
- [x] Select and evaluate booking system plugins
- [x] Set up development environment
- [x] Create project repository and version control structure
- [x] Define API schema and data flow
- [x] Document technical architecture

#### Deliverables

- Content model documentation
- Technical architecture diagram
- Development environment setup guide
- Project timeline and milestones

---

### **Phase 2: Backend Setup - WordPress Configuration (Week 2-3)**

#### 2.1 WordPress Installation & Core Setup

- [x] Install WordPress on hosting/local environment (Docker)
- [x] Configure WordPress for headless mode
- [x] Install and configure WPGraphQL plugin
- [x] Install and configure Advanced Custom Fields (ACF)
- [x] ~~Install WPGraphQL for ACF extension~~ (Manual ACF GraphQL registration due to plugin bug)
- [x] Configure CORS policies for API access

#### 2.2 Content Model Development

- [x] Create Custom Post Type: **Services**
  - Fields: Title, Description, Duration, Price, Category (taxonomy), Featured Image, Gallery
- [x] Create Custom Post Type: **Team Members**
  - Fields: Name, Position, Bio, Photo, Specialties
- [x] Create Custom Post Type: **Testimonials**
  - Fields: Client Name, Review Text, Rating, Photo (optional), Service Related To
- [x] Create Taxonomy: **Service Categories**
  - Terms: Facials, Massages, Body Treatments, Wellness Packages
- [x] Create ACF Field Groups for each CPT
- [x] Configure GraphQL schema exposure for all fields (manually registered in functions.php)

#### 2.3 Booking System Integration

- [x] Research and select booking plugin (Amelia Booking selected)
- [x] Install and configure booking plugin (Amelia v1.2.34 installed)
- [x] Set up service availability and scheduling rules (manual configuration in WordPress admin)
- [ ] Configure email notifications (manual configuration in WordPress admin)
- [x] Test booking system admin functionality
- [x] Expose booking data via API (Hybrid approach: iframe/widget embedding - free version)
- [x] Document booking API endpoints and authentication (see BOOKING-HYBRID-INTEGRATION.md)

#### 2.4 Content Population

- [x] Create sample services (minimum 6-8)
- [x] Upload and optimize media assets
- [x] Configure SEO metadata with Yoast SEO
  - [x] Install Yoast SEO plugin
  - [x] Create SEO components and utilities
  - [x] Implement Schema.org structured data
  - [x] Set up image optimization
  - [x] Configure robots.txt and sitemap
  - [x] Integrate SEO data with GraphQL
  - [x] Create comprehensive SEO documentation

#### Deliverables

- [x] Fully configured WordPress backend
- [x] GraphQL API accessible and tested
- [x] Sample content populated
- [x] Booking system functional in WordPress admin

---

### **Phase 3: Frontend Development - Astro Setup (Week 4-5)**

#### 3.1 Astro Project Initialization

- [x] Initialize Astro project with appropriate template
- [x] Configure Astro for SSG/SSR hybrid rendering
- [x] Set up TypeScript configuration (strict mode)
- [x] Install and configure Tailwind CSS 4.x
- [x] Set up GraphQL client (Apollo Client with persisted queries fix)
- [x] Configure environment variables for WordPress API
- [x] Set up routing structure

#### 3.2 Core Component Development

- [x] Create layout components (Header, Footer, Navigation)
  - [x] Navbar with mobile responsive menu
  - [x] Footer with contact info and social links
- [x] Develop reusable UI components:
  - [x] Button variants (shadcn/ui with cursor pointer)
  - [x] Card components (shadcn/ui with noTopPadding prop)
  - [x] Form inputs (shadcn/ui)
  - [x] Sheet/Drawer (mobile menu)
  - [x] Separator component
  - [x] Label (with mb-2 spacing) and Textarea components
- [x] Implement responsive navigation with mobile menu (Sheet component)
- [x] Create SEO component for meta tags (SEO.astro)
- [x] Create OptimizedImage component for responsive images
- [x] Develop comprehensive design system
  - [x] CSS custom properties in OKLCH color space
  - [x] Typography system (Cormorant Garamond + Montserrat)
  - [x] Color palette (Rose-gold, Mauve, Blush pink)
  - [x] Spacing and shadow tokens
  - [x] Fluid typography with clamp()
  - [x] Responsive breakpoints
  - [x] Animation and transition utilities
  - [x] Interactive element styling (cursor pointers)

#### 3.3 GraphQL Integration Layer

- [x] Set up GraphQL queries for:
  - Services (all and by category)
  - Team members
  - Testimonials
  - Page content
- [x] Create TypeScript types from GraphQL schema
- [x] Implement data fetching utilities
- [x] Add error handling and retry logic
- [x] Set up caching strategy

#### Deliverables

- [x] Functional Astro project structure
- [ ] Reusable component library (partial)
- [x] GraphQL integration layer
- [x] Development server running

---

### **Phase 4: Page Development (Week 6-7)** ← **COMPLETED**

#### 4.1 Homepage

- [x] Develop hero section component
  - [x] Dynamic background image from Unsplash
  - [x] Headline and subheadline
  - [x] Primary and Secondary CTA buttons with proper links
  - [x] Spa-themed imagery
- [x] Create featured services section
  - [x] Query and display top services
  - [x] Service cards with images and basic info
  - [x] Proper image handling with noTopPadding prop
- [x] Build testimonials carousel
  - [x] Fetch testimonials from WordPress
  - [x] Display ratings and client names
- [x] Add secondary CTA section with working links
- [x] Optimize images with Astro's Image component
- [x] Implement smooth scrolling and animations
- [x] Fix button visibility issues (proper contrast)
- [x] Design system integration complete
- [x] All navigation buttons wrapped in anchor tags
- [x] Cursor pointer on all interactive elements

#### 4.2 Services Pages

- [x] Create services listing page (/services/index.astro)
  - [x] Fetch all services via GraphQL
  - [x] Display as grid layout with cards
  - [x] Spa-themed hero background image
  - [x] "Why Choose Us" benefits section
  - [x] CTA section with booking buttons
  - [x] All links properly implemented
- [x] Build individual service detail pages ([slug].astro)
  - [x] Dynamic routing for each service
  - [x] Full-height hero with image overlay
  - [x] Elevated info cards (duration/price with icons)
  - [x] Display full description and benefits
  - [x] Gallery grid with hover effects
  - [x] "Book Now" CTA sections
  - [x] Design system integration
  - [x] Fixed React icon style prop errors
- [x] Add breadcrumb navigation
- [x] Implement responsive layouts

#### 4.3 Booking/Reservation Page

- [x] Create booking page (/reserver.astro)
  - [x] Hero section with design system gradient
  - [x] Trust signal cards (availability, confirmation, security)
  - [x] Amelia booking iframe integration
  - [x] Contact alternative cards (phone, email, location)
  - [x] "How It Works" 3-step process
  - [x] Responsive iframe with auto-resize
  - [x] Design system integration

#### 4.4 About Us Page (/a-propos.astro)

- [x] **COMPLETED** - Create comprehensive about page
  - [x] Hero section with serene salon interior image
  - [x] Mission statement (3 paragraphs in French)
  - [x] Core values section (4 value cards: Passion, Excellence, Innovation, Personnalisation)
  - [x] Founder profile section
    - [x] Carmen Gómez profile card with image
    - [x] Role: Fondatrice & Esthéticienne Principale
    - [x] Comprehensive biography (3 paragraphs)
    - [x] Statistics showcase (15+ years, 1000+ clients, 5★ ratings)
  - [x] CTA section with service discovery and booking buttons
  - [x] SEO metadata and Schema.org Person structured data
  - [x] Design system integration complete
  - [x] Responsive layout with proper card spacing

#### 4.5 Contact Page (/contact.astro)

- [x] **COMPLETED** - Create comprehensive contact page
  - [x] Hero section with spa reception imagery
  - [x] Contact form with validation
    - [x] First Name, Last Name fields
    - [x] Email (required)
    - [x] Phone (optional)
    - [x] Subject (required)
    - [x] Message textarea (required)
    - [x] Form submission handler with JavaScript
    - [x] Label spacing fixed (mb-2 built-in)
  - [x] Business information cards
    - [x] Opening hours card (Monday-Friday 9h00-18h00)
    - [x] Contact details card (address, phone, email)
    - [x] Social media links (Instagram, Facebook)
    - [x] Proper spacing between card elements
  - [x] Google Maps integration
    - [x] Embedded interactive map
    - [x] Location: Avenue des Alpes, 60, Montreux
    - [x] Transportation information
  - [x] CTA section with booking buttons
  - [x] SEO metadata and Schema.org LocalBusiness structured data
  - [x] Design system integration complete
  - [x] All links properly implemented

#### Deliverables (Phase 4)

- [x] Homepage fully functional with design system
- [x] Services listing page complete
- [x] Service detail pages complete
- [x] Booking/reservation page complete
- [x] About Us page complete
- [x] Contact page complete
- [x] Content dynamically loaded from WordPress
- [x] Responsive design across all devices
- [x] Optimized images and performance
- [x] All navigation links working correctly
- [x] Cursor pointer on all interactive elements

---

### **Phase 5: Booking System Integration (Week 8-9)**

#### 5.1 Booking Flow Development

- [x] Design multi-step booking UI/UX
  - Amelia booking system provides complete flow
  - Embedded via iframe on /reserver page
- [x] Create booking page layout with trust signals
  - [x] Hero section
  - [x] Trust signal cards
  - [x] "How It Works" section
  - [x] Contact alternatives
- [x] Implement booking iframe integration
  - [x] Responsive iframe with auto-resize
  - [x] Cross-origin postMessage handling
  - [x] Environment variable configuration

#### 5.2 Calendar & Availability

- [x] Booking calendar handled by Amelia plugin
  - Real-time availability from WordPress
  - Time slot management
  - Service duration handling
  - (Configuration done in WordPress admin)

#### 5.3 Customer Information & Confirmation

- [x] Customer information forms (Amelia)
- [x] Booking confirmation (Amelia)
- [x] Email notification setup (pending manual config)
- [ ] Complete email template customization

#### 5.4 Authentication & User Accounts (Optional for MVP)

- [ ] Evaluate need for user accounts
- [x] Guest checkout implemented (Amelia default)
- [ ] Add "save my information" functionality

#### Deliverables (Phase 5)

- [x] Functional booking interface on /reserver page
- [x] Integration with Amelia WordPress plugin
- [ ] Email confirmations fully configured
- [x] Error handling and responsive design

---

### **Phase 6: Testing & Quality Assurance (Week 10)**

#### 6.1 Functional Testing

- [ ] Test all page navigation and links
- [ ] Verify all WordPress content displays correctly
- [ ] Test service filtering and search
- [ ] Complete end-to-end booking flow testing
- [ ] Test contact form submissions
- [ ] Verify email notifications
- [ ] Test error states and edge cases

#### 6.2 Cross-Browser & Device Testing

- [ ] Test on Chrome, Firefox, Safari, Edge
- [ ] Mobile device testing (iOS and Android)
- [ ] Tablet responsiveness
- [ ] Test on various screen sizes
- [ ] Verify touch interactions

#### 6.3 Performance Optimization

- [ ] Run Lighthouse audits
- [ ] Optimize Core Web Vitals (LCP, FID, CLS)
- [ ] Image optimization and lazy loading
- [ ] Code splitting and bundle optimization
- [ ] Implement caching strategies
- [ ] CDN configuration

#### 6.4 SEO & Accessibility

- [ ] Verify meta tags and OpenGraph data
- [ ] Test structured data (Schema.org)
- [ ] Run accessibility audit (WCAG 2.1 AA)
- [ ] Keyboard navigation testing
- [ ] Screen reader testing
- [ ] Alt text verification for images
- [ ] Semantic HTML validation

#### 6.5 Security Testing

- [ ] Test form validation and sanitization
- [ ] Verify CORS policies
- [ ] Check for exposed sensitive data
- [ ] Test rate limiting on API endpoints
- [ ] Verify SSL/HTTPS configuration

#### Deliverables

- Testing report with issues documented
- Performance optimization results
- Accessibility compliance report
- Bug fixes implemented

---

### **Phase 7: Deployment & Launch (Week 11)**

#### 7.1 Pre-Launch Preparation

- [ ] Final content review and approval
- [ ] Set up production hosting environment
- [ ] Configure production environment variables
- [ ] Set up database backup strategy
- [ ] Configure CDN (Cloudflare, Vercel, Netlify)
- [ ] Set up monitoring and analytics
  - Google Analytics or Plausible
  - Error monitoring (Sentry)
  - Uptime monitoring

#### 7.2 Deployment Process

- [ ] Deploy WordPress to production
- [ ] Migrate content to production database
- [ ] Deploy Astro frontend to hosting (Vercel/Netlify)
- [ ] Configure domain and DNS
- [ ] Set up SSL certificates
- [ ] Test production deployment
- [ ] Set up automated deployments (CI/CD)

#### 7.3 Launch Activities

- [ ] Final smoke testing on production
- [ ] Monitor error logs
- [ ] Performance monitoring
- [ ] Submit sitemap to search engines
- [ ] Set up Google Search Console
- [ ] Configure robots.txt

#### 7.4 Documentation & Training

- [ ] Create content editor guide for WordPress
- [ ] Document booking management procedures
- [ ] Create maintenance documentation
- [ ] Train spa staff on content updates
- [ ] Provide booking system admin training

#### Deliverables

- Live production website
- Documentation package
- Training materials
- Monitoring dashboards configured

---

### **Phase 8: Post-Launch Support (Week 12+)**

#### 8.1 Monitoring & Optimization

- [ ] Monitor website performance and uptime
- [ ] Track user behavior and booking conversions
- [ ] Analyze user feedback
- [ ] Address any post-launch issues
- [ ] Make minor adjustments based on data

#### 8.2 Maintenance Plan

- [ ] Schedule regular WordPress updates
- [ ] Schedule regular dependency updates
- [ ] Plan for content audits
- [ ] Set up backup verification
- [ ] Establish support ticketing process

#### Deliverables

- Performance reports
- Maintenance schedule
- Support documentation

---

## WordPress Content Model Specification

### Custom Post Types

#### 1. Services (CPT: `spa_service`)

```
ACF Field Groups:
├── Service Details
│   ├── service_description (WYSIWYG)
│   ├── service_duration (Number - minutes)
│   ├── service_price (Number/Text)
│   ├── service_category (Taxonomy relationship)
│   ├── featured_service (True/False)
│   ├── service_benefits (Repeater)
│   │   └── benefit_text (Text)
│   └── gallery (Gallery)
└── Booking Settings
    ├── bookable_online (True/False)
    └── booking_notes (Text Area)

GraphQL Exposure: Enabled
Supports: Title, Editor, Thumbnail, Excerpt
```

#### 2. Team Members (CPT: `team_member`)

```
ACF Field Groups:
├── Team Member Info
│   ├── position (Text)
│   ├── bio_short (Text Area - 150 chars)
│   ├── bio_full (WYSIWYG)
│   ├── photo (Image)
│   ├── specialties (Repeater)
│   │   └── specialty_name (Text)
│   ├── certifications (Text Area)
│   └── display_order (Number)

GraphQL Exposure: Enabled
Supports: Title
```

#### 3. Testimonials (CPT: `testimonial`)

```
ACF Field Groups:
├── Testimonial Details
│   ├── client_name (Text)
│   ├── review_text (Text Area)
│   ├── rating (Number - 1-5)
│   ├── client_photo (Image - optional)
│   ├── service_related (Post Object - relationship to Services)
│   ├── featured (True/False)
│   └── date_submitted (Date Picker)

GraphQL Exposure: Enabled
Supports: Title (internal use)
```

### Taxonomies

#### Service Categories (Taxonomy: `service_category`)

```
Hierarchical: Yes
Post Types: spa_service
GraphQL Exposure: Enabled

Suggested Terms:
├── Facials
├── Massages
│   ├── Swedish Massage
│   ├── Deep Tissue
│   └── Hot Stone
├── Body Treatments
├── Skincare
└── Wellness Packages
```

---

## Technology Stack Details

### Backend

- **CMS:** WordPress 6.4+
- **Plugins:**
  - WPGraphQL v1.26.0
  - Advanced Custom Fields Pro (manual GraphQL registration)
  - Amelia Booking v1.2.34 (free version with iframe integration)
  - Yoast SEO (with custom SEO integration)

### Frontend

- **Framework:** Astro 4.x
- **Styling:** Tailwind CSS 4.x with custom design system
  - CSS custom properties in OKLCH color space
  - Fluid typography system
  - Design tokens for colors, spacing, shadows
- **UI Components:** shadcn/ui adapted for Astro
  - Button, Card, Input, Label, Textarea
  - Sheet (mobile menu), Separator
- **GraphQL Client:** Apollo Client with persisted queries fix
- **Icons:** Lucide React (Calendar, Clock, Star, CheckCircle2, etc.)
- **Typography:**
  - Headings: Cormorant Garamond (Google Fonts)
  - Body: Montserrat (Google Fonts)
- **Image Optimization:** Astro Image component with responsive loading

### Design System

- **Color Palette:**
  - Primary: Rose-gold (#d4af8e / oklch 0.71 0.07 42)
  - Secondary: Mauve (#a67c7c / oklch 0.59 0.03 25)
  - Accent: Blush pink (#f4d7d7 / oklch 0.88 0.04 15)
  - Neutral: Grays in OKLCH
- **Typography Scale:** Fluid with clamp() for responsive sizing
- **Spacing System:** CSS custom properties (--space-\*)
- **Shadow Tokens:** Colored shadows (rose-gold, blush, mauve)
- **Border Radius:** --radius-\* system with pill shape support
- **Transitions:** Elegant easing curves with CSS custom properties

### Hosting & Deployment

- **WordPress Hosting:** Docker (local development)
- **Astro Hosting:** Development server (production TBD - Vercel/Netlify)
- **CDN:** TBD (Cloudflare recommended)
- **Version Control:** Git (GitHub)

---

### Known Issues

1. **Email Configuration:**

   - Amelia booking email notifications need manual configuration in WordPress admin
   - Email templates customization pending

2. **Form Submission:**
   - Contact form currently logs to console (backend integration pending)
   - No spam protection implemented yet

### Next Steps (Priority Order)

1. **Email Notifications:**

   - Configure Amelia email templates
   - Set up SMTP for reliable email delivery
   - Test booking confirmation emails

2. **Contact Form Backend:**

   - Implement server-side form submission handling
   - Add spam protection (reCAPTCHA or Turnstile)
   - Set up email delivery for contact form

3. **UI/UX Component Enhancements:**

   - [x] Fix Card component padding for images (noTopPadding prop)
   - [x] Fix label and input spacing (mb-2 built-in)
   - [x] Fix coordonnées card element spacing
   - [x] Add cursor pointer to all buttons
   - [x] Wrap all CTA buttons in anchor tags for proper navigation

4. **Business Information Updates:**

   - [x] Update business hours (Monday-Friday 9:00-18:00, weekends closed)
   - [x] Verify contact information accuracy
   - [x] Update Schema.org structured data

5. **Performance Optimization:**

   - Run Lighthouse audits
   - Optimize images further with next-gen formats
   - Implement lazy loading where appropriate
   - Add loading states for async operations

6. **Testing:**

   - Cross-browser testing
   - Mobile device testing
   - Accessibility audit (WCAG 2.1 AA)
   - Form validation testing
   - Booking flow end-to-end testing

7. **SEO Enhancement:**
   - Submit sitemap to search engines
   - Configure Google Search Console
   - Verify all meta tags and structured data
   - Optimize for Core Web Vitals

### File Structure Reference

```
frontend/
├── src/
│   ├── components/
│   │   ├── Footer.tsx (Contact info, social links)
│   │   ├── Navbar.tsx (Navigation with mobile menu)
│   │   ├── SEO.astro (Meta tags, Schema.org)
│   │   ├── OptimizedImage.astro (Image optimization)
│   │   └── ui/ (shadcn/ui components)
│   ├── layouts/
│   │   └── Layout.astro (Base layout with SEO, Navbar, Footer)
│   ├── pages/
│   │   ├── index.astro (Homepage)
│   │   ├── reserver.astro (Booking page)
│   │   └── services/
│   │       ├── index.astro (Services listing)
│   │       └── [slug].astro (Service detail pages)
│   ├── styles/
│   │   └── global.css (Design system tokens)
│   ├── lib/
│   │   ├── apollo-client.ts (GraphQL client)
│   │   ├── queries.ts (GraphQL queries)
│   │   ├── seo.ts (SEO utilities)
│   │   └── utils.ts (Utility functions)
│   └── types/
│       └── wordpress.ts (TypeScript types)
└── public/ (Static assets)
```

### Environment Variables

Required in `/frontend/.env`:

```bash
PUBLIC_WORDPRESS_URL=http://localhost:8000
WORDPRESS_GRAPHQL_ENDPOINT=http://localhost:8000/graphql
```

### Development Commands

```bash
# Start WordPress (Docker)
cd /home/dracudev/dev/cg-aesthetics-wp
docker-compose up -d

# Start Astro dev server
cd frontend
pnpm dev

# Build for production
pnpm build

# Preview production build
pnpm preview
```

---

## Success Metrics

### Performance Targets

- Lighthouse Performance Score: 90+
- First Contentful Paint (FCP): < 1.5s
- Largest Contentful Paint (LCP): < 2.5s
- Time to Interactive (TTI): < 3.5s

### Business Metrics

- Increase online bookings by 50% within 3 months
- Reduce booking abandonment rate to < 20%
- Achieve 40% of total bookings through website

### SEO Targets

- Page 1 ranking for primary local keywords within 6 months
- Organic traffic increase of 100% year-over-year

---

## Risk Management

### Potential Risks & Mitigation

1. **Booking Plugin Compatibility**

   - Risk: Selected plugin may not integrate well with GraphQL
   - Mitigation: Evaluate multiple options early; consider custom REST API endpoints

2. **Content Migration Issues**

   - Risk: Delays due to content preparation
   - Mitigation: Start content collection in Phase 1; provide templates

3. **Performance Issues**

   - Risk: Heavy media assets impact load times
   - Mitigation: Implement image optimization pipeline; use modern formats (WebP/AVIF)

4. **Browser Compatibility**

   - Risk: Booking system may not work on older browsers
   - Mitigation: Test early and often; implement polyfills where necessary

5. **Timeline Delays**
   - Risk: Phases may extend beyond estimates
   - Mitigation: Build buffer time; prioritize MVP features

---

## Assumptions

1. Client will provide all content (text, images, branding) in a timely manner
2. Booking system will integrate with WordPress via API
3. Domain and hosting accounts will be accessible
4. Client has rights to all media assets provided
5. Design mockups/wireframes will be approved before development begins
6. Third-party services (Google Maps, email) are properly configured

---

## Out of Scope (Future Enhancements)

The following items are not included in the MVP but may be considered for future phases:

- E-commerce functionality for product sales
- Gift card purchase and management
- Mobile app development
- Multiple language support (i18n)
- Customer portal with booking history
- Loyalty program integration
- Blog/content marketing section
- Advanced analytics dashboard
- Social media integration feeds
- Live chat support
- Payment processing integration
- Membership/subscription packages

---
