/**
 * Cache utilities for managing WordPress data cache
 */

import type {
  ServicesResponse,
  ServiceCategoriesResponse,
  TeamMembersResponse,
  TestimonialsResponse,
  SiteSettingsResponse,
  HeroImagesResponse,
} from '../types/wordpress';

export interface WordPressCacheData {
  services: ServicesResponse | null;
  serviceCategories: ServiceCategoriesResponse | null;
  teamMembers: TeamMembersResponse | null;
  testimonials: TestimonialsResponse | null;
  siteSettings: SiteSettingsResponse | null;
  heroImages: HeroImagesResponse | null;
  cachedAt: string;
  wordpressUrl: string;
}

let cachedData: WordPressCacheData | null = null;

/**
 * Load cached WordPress data from JSON file
 */
export async function loadCache(): Promise<WordPressCacheData | null> {
  if (cachedData) {
    return cachedData;
  }

  try {
    const cacheData = await import('./wp-cache.json').catch(() => null);
    if (!cacheData) {
      console.warn(
        '⚠️ No cache file found. Run "pnpm cache:wp" to create cache.'
      );
      return null;
    }

    // JSON import may have structural differences; cast via unknown to satisfy TS
    let data = cacheData.default as unknown as WordPressCacheData;

    // Replace localhost URLs with production URLs if needed
    const PRODUCTION_URL =
      process.env.PUBLIC_WORDPRESS_URL || 'https://carmeng-beauty.com';
    if (PRODUCTION_URL && !PRODUCTION_URL.includes('localhost')) {
      data = replaceLocalhostUrls(data, PRODUCTION_URL);
    }

    cachedData = data;
    console.log(
      '✅ Loaded WordPress data from cache (cached at:',
      cachedData.cachedAt,
      ')'
    );
    return cachedData;
  } catch (error) {
    console.warn(
      '⚠️ Error loading cache file. Run "pnpm cache:wp" to create cache.'
    );
    return null;
  }
}

/**
 * Replace localhost URLs with production URLs in cached data
 */
function replaceLocalhostUrls(data: any, productionUrl: string): any {
  const dataStr = JSON.stringify(data);
  // Replace any localhost URL (http or https) with optional port
  const replacedStr = dataStr.replace(
    /https?:\/\/localhost(?::\d+)?/g,
    productionUrl
  );
  return JSON.parse(replacedStr);
}

/**
 * Check if cache exists
 */
export function isCacheAvailable(): boolean {
  return cachedData !== null;
}

/**
 * Get cache timestamp
 */
export function getCacheTimestamp(): string | null {
  return cachedData?.cachedAt || null;
}

/**
 * Fallback data for missing content
 */
export const FALLBACK_DATA = {
  service: {
    title: 'Service',
    excerpt: 'Service description',
    featuredImage: {
      node: {
        sourceUrl:
          'https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=2670',
        altText: 'Service image',
        mediaDetails: {
          width: 2670,
          height: 1440,
          sizes: [],
        },
      },
    },
    serviceDetails: {
      serviceDescription: '',
      serviceDuration: '',
      servicePrice: '',
      featuredService: false,
      bookableOnline: false,
      bookingNotes: '',
      serviceBenefits: '',
      serviceGallery: [],
    },
    serviceCategories: {
      nodes: [],
    },
    seo: {
      title: '',
      metaDesc: '',
      canonical: '',
      opengraphTitle: '',
      opengraphDescription: '',
      opengraphImage: null,
      twitterTitle: '',
      twitterDescription: '',
      twitterImage: null,
      metaRobotsNoindex: 'index',
      metaRobotsNofollow: 'follow',
      focuskw: '',
    },
    schemaOrg: null,
  },
  heroImage:
    'https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=2670&auto=format&fit=crop',
  siteSettings: {
    title: 'Carmen Gómez - Institut de Beauté',
    description: 'Institut de beauté de luxe à Montreux, Suisse',
    url: 'https://carmeng-beauty.com',
    language: 'fr-FR',
  },
};

/**
 * Get fallback image URL
 */
export function getFallbackImage(
  type: 'hero' | 'service' | 'testimonial' = 'hero'
): string {
  const images = {
    hero: 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=2670&auto=format&fit=crop',
    service:
      'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=2670&auto=format&fit=crop',
    testimonial:
      'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=2670&auto=format&fit=crop',
  };
  return images[type];
}

/**
 * Safely get nested property with fallback
 */
export function safeGet<T>(obj: any, path: string, fallback: T): T {
  return (
    path.split('.').reduce((current, prop) => current?.[prop], obj) ?? fallback
  );
}
