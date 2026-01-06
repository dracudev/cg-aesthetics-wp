/**
 * WordPress Data Caching Script
 * Fetches all required data from WordPress and saves it to a local JSON file
 * Run this before building to cache WordPress data and enable offline builds
 */

import {
  ApolloClient,
  InMemoryCache,
  HttpLink,
  ApolloLink,
} from '@apollo/client';
import { removeTypenameFromVariables } from '@apollo/client/link/remove-typename';
import {
  GET_SERVICES,
  GET_SERVICE_CATEGORIES,
  GET_TEAM_MEMBERS,
  GET_TESTIMONIALS,
  GET_SITE_SETTINGS,
  GET_HERO_IMAGES,
} from '../src/lib/queries.ts';
import type {
  ServicesResponse,
  ServiceCategoriesResponse,
  TeamMembersResponse,
  TestimonialsResponse,
  SiteSettingsResponse,
  HeroImagesResponse,
} from '../src/types/wordpress';
import { writeFileSync, mkdirSync } from 'fs';
import { fileURLToPath } from 'url';
import { dirname, join } from 'path';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

// Get GraphQL endpoint from environment
const GRAPHQL_ENDPOINT =
  process.env.PUBLIC_GRAPHQL_ENDPOINT || 'http://localhost:8000/graphql';

console.log('🔄 Fetching WordPress data from:', GRAPHQL_ENDPOINT);

// Create Apollo Client
const removeTypenameLink = removeTypenameFromVariables();

const httpLink = new HttpLink({
  uri: GRAPHQL_ENDPOINT,
  credentials: 'same-origin',
  useGETForQueries: false,
  fetchOptions: {
    method: 'POST',
  },
});

const link = ApolloLink.from([removeTypenameLink, httpLink]);

const client = new ApolloClient({
  link,
  cache: new InMemoryCache(),
  defaultOptions: {
    query: {
      fetchPolicy: 'network-only',
      errorPolicy: 'all',
    },
  },
});

interface CachedData {
  services: any;
  serviceCategories: any;
  teamMembers: any;
  testimonials: any;
  siteSettings: any;
  heroImages: any;
  cachedAt: string;
  wordpressUrl: string;
}

async function cacheWordPressData() {
  try {
    const cachedData: CachedData = {
      services: null,
      serviceCategories: null,
      teamMembers: null,
      testimonials: null,
      siteSettings: null,
      heroImages: null,
      cachedAt: new Date().toISOString(),
      wordpressUrl: process.env.PUBLIC_WORDPRESS_URL || 'http://localhost:8000',
    };

    // Fetch all services
    console.log('📦 Fetching services...');
    const servicesResult = await client.query<ServicesResponse>({
      query: GET_SERVICES,
      variables: { first: 100 },
    });
    cachedData.services = servicesResult.data;
    if (servicesResult.data) {
      console.log(
        `✅ Cached ${servicesResult.data.services.nodes.length} services`
      );
    }

    // Fetch service categories
    console.log('📦 Fetching service categories...');
    const categoriesResult = await client.query<ServiceCategoriesResponse>({
      query: GET_SERVICE_CATEGORIES,
    });
    cachedData.serviceCategories = categoriesResult.data;
    if (categoriesResult.data) {
      console.log(
        `✅ Cached ${categoriesResult.data.serviceCategories.nodes.length} categories`
      );
    }

    // Fetch team members
    console.log('📦 Fetching team members...');
    const teamResult = await client.query<TeamMembersResponse>({
      query: GET_TEAM_MEMBERS,
      variables: { first: 100 },
    });
    cachedData.teamMembers = teamResult.data;
    if (teamResult.data) {
      console.log(
        `✅ Cached ${teamResult.data.teamMembers.nodes.length} team members`
      );
    }

    // Fetch testimonials
    console.log('📦 Fetching testimonials...');
    const testimonialsResult = await client.query<TestimonialsResponse>({
      query: GET_TESTIMONIALS,
      variables: { first: 100 },
    });
    cachedData.testimonials = testimonialsResult.data;
    if (testimonialsResult.data) {
      console.log(
        `✅ Cached ${testimonialsResult.data.testimonials.nodes.length} testimonials`
      );
    }

    // Fetch site settings
    console.log('📦 Fetching site settings...');
    const settingsResult = await client.query<SiteSettingsResponse>({
      query: GET_SITE_SETTINGS,
    });
    cachedData.siteSettings = settingsResult.data;
    console.log('✅ Cached site settings');

    // Fetch hero images
    console.log('📦 Fetching hero images...');
    const heroImagesResult = await client.query<HeroImagesResponse>({
      query: GET_HERO_IMAGES,
    });
    cachedData.heroImages = heroImagesResult.data;
    console.log('✅ Cached hero images');

    // Create data directory if it doesn't exist
    const dataDir = join(__dirname, '..', 'src', 'data');
    mkdirSync(dataDir, { recursive: true });

    // Write cache file
    const cacheFile = join(dataDir, 'wp-cache.json');
    writeFileSync(cacheFile, JSON.stringify(cachedData, null, 2), 'utf-8');

    console.log('\n✨ Successfully cached WordPress data to:', cacheFile);
    console.log(`📅 Cache timestamp: ${cachedData.cachedAt}`);
    console.log('\n🎉 You can now build offline using the cached data!');

    return cachedData;
  } catch (error) {
    console.error('❌ Error caching WordPress data:', error);
    process.exit(1);
  }
}

// Run the cache function
cacheWordPressData();
