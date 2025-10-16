/**
 * TypeScript Type Definitions for WordPress Content
 */

// SEO Types
export interface SEO {
  title?: string;
  metaDesc?: string;
  canonical?: string;
  opengraphTitle?: string;
  opengraphDescription?: string;
  opengraphImage?: {
    sourceUrl: string;
    altText?: string;
  };
  twitterTitle?: string;
  twitterDescription?: string;
  twitterImage?: {
    sourceUrl: string;
    altText?: string;
  };
  metaRobotsNoindex?: string;
  metaRobotsNofollow?: string;
  focuskw?: string;
  breadcrumbs?: Breadcrumb[];
  schema?: string;
}

export interface Breadcrumb {
  text: string;
  url: string;
}

// Service Types
export interface Service {
  id: string;
  title: string;
  slug: string;
  excerpt?: string;
  featuredImage?: {
    node: {
      sourceUrl: string;
      altText: string;
      mediaDetails?: {
        width: number;
        height: number;
      };
    };
  };
  serviceDetails: {
    serviceDescription: string;
    serviceDuration: number;
    servicePrice: string;
    featuredService: boolean;
    bookableOnline: boolean;
    bookingNotes?: string;
    serviceBenefits?: string[]; // Changed from Array<{ benefitText: string }> to string[]
    serviceGallery?: Array<{
      sourceUrl: string;
      altText: string;
    }>;
  };
  serviceCategories: {
    nodes: ServiceCategory[];
  };
  seo?: SEO;
  schemaOrg?: string;
}

export interface ServiceCategory {
  id: string;
  name: string;
  slug: string;
  description?: string;
  count?: number;
}

// Team Member Types
export interface TeamMember {
  id: string;
  title: string;
  featuredImage?: {
    node: {
      sourceUrl: string;
      altText: string;
    };
  };
  teamMemberDetails: {
    position: string;
    bioShort: string;
    bioFull: string;
    certifications?: string;
    displayOrder: number;
    specialties?: Array<{
      specialtyName: string;
    }>;
  };
  seo?: SEO;
  schemaOrg?: string;
}

// Testimonial Types
export interface Testimonial {
  id: string;
  title: string;
  testimonialDetails: {
    clientName: string;
    reviewText: string;
    rating: number;
    featured: boolean;
    dateSubmitted?: string;
    clientPhoto?: {
      sourceUrl: string;
      altText: string;
    };
    serviceRelated?: {
      id: string;
      title: string;
      slug: string;
    };
  };
  schemaOrg?: string;
}

// Site Settings
export interface SiteSettings {
  title: string;
  description: string;
  url: string;
  language: string;
}

// GraphQL Response Types
export interface ServicesResponse {
  services: {
    nodes: Service[];
  };
}

export interface ServiceResponse {
  service: Service;
}

export interface ServiceCategoriesResponse {
  serviceCategories: {
    nodes: ServiceCategory[];
  };
}

export interface TeamMembersResponse {
  teamMembers: {
    nodes: TeamMember[];
  };
}

export interface TestimonialsResponse {
  testimonials: {
    nodes: Testimonial[];
  };
}

export interface SiteSettingsResponse {
  generalSettings: SiteSettings;
  seoSettings?: SEO;
}
