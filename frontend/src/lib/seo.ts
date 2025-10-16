/**
 * SEO Utility Functions
 *
 * Helper functions for generating SEO metadata from WordPress data
 */

export interface WordPressSEO {
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
}

export interface SEOMetadata {
  title: string;
  description: string;
  canonical?: string;
  image?: string;
  imageAlt?: string;
  noindex: boolean;
  nofollow: boolean;
  keywords?: string;
}

/**
 * Generate SEO metadata from WordPress SEO data
 */
export function generateSEOMetadata(
  wpSeo: WordPressSEO | null | undefined,
  fallbackTitle: string,
  fallbackDescription: string,
  fallbackImage?: string
): SEOMetadata {
  const title = wpSeo?.opengraphTitle || wpSeo?.title || fallbackTitle;
  const description =
    wpSeo?.opengraphDescription || wpSeo?.metaDesc || fallbackDescription;
  const image = wpSeo?.opengraphImage?.sourceUrl || fallbackImage;
  const imageAlt = wpSeo?.opengraphImage?.altText || title;

  return {
    title,
    description,
    canonical: wpSeo?.canonical,
    image,
    imageAlt,
    noindex: wpSeo?.metaRobotsNoindex === '1',
    nofollow: wpSeo?.metaRobotsNofollow === '1',
    keywords: wpSeo?.focuskw,
  };
}

/**
 * Truncate text to specified length with ellipsis
 */
export function truncateText(text: string, maxLength: number = 160): string {
  if (!text || text.length <= maxLength) return text || '';
  return text.substring(0, maxLength - 3) + '...';
}

/**
 * Strip HTML tags from string
 */
export function stripHtml(html: string): string {
  if (!html) return '';
  return html.replace(/<[^>]*>/g, '');
}

/**
 * Generate meta description from content
 */
export function generateMetaDescription(
  content: string,
  excerpt?: string,
  maxLength: number = 160
): string {
  if (excerpt) {
    return truncateText(stripHtml(excerpt), maxLength);
  }

  if (content) {
    return truncateText(stripHtml(content), maxLength);
  }

  return '';
}

/**
 * Generate SEO-friendly slug
 */
export function generateSlug(text: string): string {
  return text
    .toLowerCase()
    .trim()
    .replace(/[^\w\s-]/g, '')
    .replace(/[\s_-]+/g, '-')
    .replace(/^-+|-+$/g, '');
}

/**
 * Build breadcrumb structured data
 */
export function buildBreadcrumbSchema(
  breadcrumbs: Array<{ text: string; url: string }>
) {
  return {
    '@context': 'https://schema.org',
    '@type': 'BreadcrumbList',
    itemListElement: breadcrumbs.map((crumb, index) => ({
      '@type': 'ListItem',
      position: index + 1,
      name: crumb.text,
      item: crumb.url,
    })),
  };
}

/**
 * Build service schema
 */
export function buildServiceSchema(service: {
  title: string;
  description: string;
  price?: string;
  duration?: number;
  image?: string;
  url: string;
}) {
  const schema: any = {
    '@context': 'https://schema.org',
    '@type': 'Service',
    name: service.title,
    description: stripHtml(service.description),
    url: service.url,
    provider: {
      '@type': 'BeautySalon',
      name: 'CG Aesthetics',
      address: {
        '@type': 'PostalAddress',
        streetAddress: 'Avenue des Alpes, 60',
        addressLocality: 'Montreux',
        addressRegion: 'Vaud',
        postalCode: '1820',
        addressCountry: 'CH',
      },
      telephone: '+41763999732',
    },
  };

  if (service.image) {
    schema.image = service.image;
  }

  if (service.price) {
    schema.offers = {
      '@type': 'Offer',
      price: service.price.replace(/[^0-9.]/g, ''),
      priceCurrency: 'CHF',
    };
  }

  if (service.duration) {
    schema.duration = `PT${service.duration}M`;
  }

  return schema;
}

/**
 * Build person/team member schema
 */
export function buildPersonSchema(person: {
  name: string;
  jobTitle?: string;
  description?: string;
  image?: string;
  url: string;
}) {
  return {
    '@context': 'https://schema.org',
    '@type': 'Person',
    name: person.name,
    jobTitle: person.jobTitle,
    description: person.description ? stripHtml(person.description) : undefined,
    image: person.image,
    url: person.url,
    worksFor: {
      '@type': 'BeautySalon',
      name: 'CG Aesthetics',
      address: {
        '@type': 'PostalAddress',
        streetAddress: 'Avenue des Alpes, 60',
        addressLocality: 'Montreux',
        addressCountry: 'CH',
      },
    },
  };
}

/**
 * Build review schema
 */
export function buildReviewSchema(review: {
  author: string;
  rating: number;
  reviewBody: string;
  datePublished?: string;
}) {
  return {
    '@context': 'https://schema.org',
    '@type': 'Review',
    author: {
      '@type': 'Person',
      name: review.author,
    },
    reviewRating: {
      '@type': 'Rating',
      ratingValue: review.rating,
      bestRating: 5,
      worstRating: 1,
    },
    reviewBody: review.reviewBody,
    datePublished: review.datePublished,
    itemReviewed: {
      '@type': 'BeautySalon',
      name: 'CG Aesthetics',
      address: {
        '@type': 'PostalAddress',
        streetAddress: 'Avenue des Alpes, 60',
        addressLocality: 'Montreux',
        addressCountry: 'CH',
      },
    },
  };
}

/**
 * Build aggregate rating schema from testimonials
 */
export function buildAggregateRatingSchema(
  ratings: number[],
  reviewCount: number
) {
  const averageRating =
    ratings.reduce((sum, rating) => sum + rating, 0) / ratings.length;

  return {
    '@context': 'https://schema.org',
    '@type': 'AggregateRating',
    ratingValue: averageRating.toFixed(1),
    reviewCount: reviewCount,
    bestRating: 5,
    worstRating: 1,
  };
}

/**
 * Optimize image URL with parameters
 */
export function optimizeImageUrl(
  url: string,
  width?: number,
  height?: number,
  quality: number = 85
): string {
  if (!url) return '';

  // If WordPress image, add query parameters for optimization
  const urlObj = new URL(url);

  if (width) urlObj.searchParams.set('w', width.toString());
  if (height) urlObj.searchParams.set('h', height.toString());
  urlObj.searchParams.set('q', quality.toString());

  return urlObj.toString();
}

/**
 * Generate responsive image srcset
 */
export function generateSrcSet(baseUrl: string, sizes: number[]): string {
  if (!baseUrl) return '';

  return sizes
    .map((size) => `${optimizeImageUrl(baseUrl, size)} ${size}w`)
    .join(', ');
}

/**
 * Get responsive image sizes attribute
 */
export function getImageSizes(
  mobile: string = '100vw',
  tablet: string = '50vw',
  desktop: string = '33vw'
): string {
  return `(max-width: 640px) ${mobile}, (max-width: 1024px) ${tablet}, ${desktop}`;
}
