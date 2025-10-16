# CG Aesthetics Website - Project Scope Document

## Executive Summary

**Project Name:** CG Aesthetics Website  
**Project Goal:** Launch a modern, fast website using Headless WordPress and Astro to increase online bookings  
**Target Launch Date:** TBD  
**Technology Stack:** Headless WordPress (Backend/CMS) + Astro (Frontend) + GraphQL API

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

#### 2.4 Content Population ← **CURRENT PHASE**

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

- [ ] Create layout components (Header, Footer, Navigation) - Basic structure
- [ ] Develop reusable UI components:
  - Button variants
  - Card components
  - Form inputs
  - Modal/Dialog
  - Loading states
  - Error boundaries
- [ ] Implement responsive navigation with mobile menu
- [ ] Create SEO component for meta tags

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

### **Phase 4: Page Development (Week 6-7)**

#### 4.1 Homepage

- [ ] Develop hero section component
  - Dynamic background image from WordPress
  - Headline and subheadline
  - Primary CTA button
- [ ] Create featured services section
  - Query and display top 3-4 services
  - Service cards with images and basic info
- [ ] Build testimonials carousel
  - Fetch testimonials from WordPress
  - Implement slider/carousel functionality
  - Display ratings and client names
- [ ] Add secondary CTA section
- [ ] Optimize images with Astro's Image component
- [ ] Implement smooth scrolling and animations

#### 4.2 Services Page

- [ ] Create services listing page
  - Fetch all services via GraphQL
  - Display as grid layout
- [ ] Implement category filter
  - Dynamic filter buttons from taxonomy
  - Client-side or server-side filtering
- [ ] Build individual service detail pages
  - Dynamic routing for each service
  - Display full description, pricing, duration
  - Related services suggestion
  - "Book Now" CTA
- [ ] Add breadcrumb navigation
- [ ] Implement loading skeletons

#### 4.3 About Us Page

- [ ] Create spa philosophy section
  - Rich text content from WordPress
- [ ] Build team members grid
  - Fetch team members from WordPress
  - Photo, name, position, short bio
  - Modal or expanded view for full bio
- [ ] Add brand story section
- [ ] Include gallery or video (if available)

#### 4.4 Contact Page

- [ ] Display contact information
  - Address, phone, email, hours
  - Pull from WordPress options or ACF
- [ ] Embed Google Maps
  - Dynamic coordinates from WordPress
- [ ] Build contact form
  - Client-side validation
  - Server-side submission handling
  - Success/error messages
  - Spam protection (reCAPTCHA or Turnstile)
- [ ] Add social media links

#### Deliverables

- All core pages fully functional
- Content dynamically loaded from WordPress
- Responsive design across all devices
- Optimized images and performance

---

### **Phase 5: Booking System Integration (Week 8-9)**

#### 5.1 Booking Flow Development

- [ ] Design multi-step booking UI/UX
  - Step 1: Service selection
  - Step 2: Date and time selection
  - Step 3: Customer information
  - Step 4: Confirmation and payment (if applicable)
- [ ] Create booking wizard component
  - Progress indicator
  - Step navigation
  - Form state management
- [ ] Implement service selection interface
  - Display available services with pricing
  - Search/filter functionality
  - Service selection confirmation

#### 5.2 Calendar & Availability

- [ ] Integrate date picker component
  - Fetch available dates from booking API
  - Block unavailable dates
  - Show available time slots
- [ ] Implement time slot selection
  - Display real-time availability
  - Handle timezone considerations
  - Show service duration

#### 5.3 Customer Information & Confirmation

- [ ] Build customer information form
  - Name, email, phone (with validation)
  - Special requests/notes field
  - Terms and conditions checkbox
- [ ] Create booking confirmation page
  - Summary of selected service, date, time
  - Edit functionality
  - Submit booking to WordPress API
- [ ] Handle booking submission
  - API integration with WordPress booking plugin
  - Error handling and validation
  - Success confirmation
  - Email confirmation trigger

#### 5.4 Authentication & User Accounts (Optional for MVP)

- [ ] Evaluate need for user accounts
- [ ] Implement guest checkout
- [ ] Add "save my information" functionality

#### Deliverables

- Fully functional booking system
- Seamless integration with WordPress backend
- Email confirmations working
- Error handling and edge cases covered

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
  - WPGraphQL
  - WPGraphQL for ACF
  - Advanced Custom Fields Pro
  - Booking System TBD (Amelia/Bookly)
  - Yoast SEO or Rank Math
  - WP Rocket (caching - optional)

### Frontend

- **Framework:** Astro 4.x
- **Styling:** Tailwind CSS
- **GraphQL Client:** Apollo Client or urql
- **Form Handling:** React Hook Form (in React islands)
- **Date Picker:** react-datepicker or @internationalized/date
- **Icons:** Heroicons or Lucide
- **Animations:** Framer Motion (optional)

### Hosting & Deployment

- **WordPress Hosting:** TBD (Suggested: Kinsta, WP Engine, or DigitalOcean)
- **Astro Hosting:** Vercel or Netlify
- **CDN:** Cloudflare or integrated with hosting
- **Version Control:** Git (GitHub/GitLab)

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

## Approval & Sign-Off

**Project Sponsor:** \***\*\*\*\*\***\_\***\*\*\*\*\***  
**Date:** \***\*\*\*\*\***\_\***\*\*\*\*\***

**Project Manager:** \***\*\*\*\*\***\_\***\*\*\*\*\***  
**Date:** \***\*\*\*\*\***\_\***\*\*\*\*\***

**Technical Lead:** \***\*\*\*\*\***\_\***\*\*\*\*\***  
**Date:** \***\*\*\*\*\***\_\***\*\*\*\*\***

---

## Revision History

| Version | Date       | Author          | Description                    |
| ------- | ---------- | --------------- | ------------------------------ |
| 1.0     | 2025-10-15 | Project Manager | Initial project scope document |

---

**Document Status:** Draft  
**Next Review Date:** TBD  
**Distribution:** Project Team, Stakeholders
