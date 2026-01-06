/**
 * GraphQL Client Configuration
 * Apollo Client setup for WordPress GraphQL API with cache support
 */

import {
  ApolloClient,
  InMemoryCache,
  HttpLink,
  ApolloLink,
  type DocumentNode,
} from '@apollo/client';
import { removeTypenameFromVariables } from '@apollo/client/link/remove-typename';
import { loadCache, type WordPressCacheData } from '../data/cache-utils';
import {
  GET_SERVICES,
  GET_SERVICE_BY_SLUG,
  GET_SERVICE_CATEGORIES,
  GET_TEAM_MEMBERS,
  GET_TESTIMONIALS,
  GET_FEATURED_TESTIMONIALS,
  GET_SITE_SETTINGS,
  GET_HERO_IMAGES,
  GET_FEATURED_SERVICES,
} from './queries';

const GRAPHQL_ENDPOINT =
  import.meta.env.PUBLIC_GRAPHQL_ENDPOINT || 'http://localhost:8000/graphql';

// Check if we should use cached data (for builds)
const USE_CACHE = import.meta.env.PUBLIC_USE_WP_CACHE === 'true';

// Remove __typename from variables
const removeTypenameLink = removeTypenameFromVariables();

// Create HTTP Link with explicit POST method
const httpLink = new HttpLink({
  uri: GRAPHQL_ENDPOINT,
  credentials: 'same-origin',
  // Force POST to avoid persisted queries issues
  useGETForQueries: false,
  fetchOptions: {
    method: 'POST',
  },
});

// Combine links
const link = ApolloLink.from([removeTypenameLink, httpLink]);

// Create Apollo Client instance
export const client = new ApolloClient({
  link,
  cache: new InMemoryCache(),
  // Disable persisted queries
  defaultOptions: {
    watchQuery: {
      fetchPolicy: 'cache-and-network',
    },
    query: {
      fetchPolicy: 'network-only',
      errorPolicy: 'all',
    },
  },
});

// Cache instance
let cache: WordPressCacheData | null = null;

/**
 * Map query to cached data
 */
function getCachedDataForQuery(queryDoc: DocumentNode, variables?: any): any {
  if (!cache) return null;

  switch (queryDoc) {
    case GET_SERVICES:
      return cache.services;
    case GET_FEATURED_SERVICES:
      // Return limited services for featured query
      if (cache.services?.services?.nodes) {
        const limit = variables?.first || 4;
        return {
          services: {
            nodes: cache.services.services.nodes
              .filter((s: any) => s.serviceDetails?.featuredService)
              .slice(0, limit),
          },
        };
      }
      return null;
    case GET_SERVICE_BY_SLUG:
      if (cache.services?.services?.nodes && variables?.slug) {
        const service = cache.services.services.nodes.find(
          (s: any) => s.slug === variables.slug
        );
        return service ? { service } : null;
      }
      return null;
    case GET_SERVICE_CATEGORIES:
      return cache.serviceCategories;
    case GET_TEAM_MEMBERS:
      return cache.teamMembers;
    case GET_TESTIMONIALS:
      return cache.testimonials;
    case GET_FEATURED_TESTIMONIALS:
      // Return limited testimonials for featured query
      if (cache.testimonials?.testimonials?.nodes) {
        const limit = variables?.first || 6;
        return {
          testimonials: {
            nodes: cache.testimonials.testimonials.nodes
              .filter((t: any) => t.testimonialDetails?.featured)
              .slice(0, limit),
          },
        };
      }
      return null;
    case GET_SITE_SETTINGS:
      return cache.siteSettings;
    case GET_HERO_IMAGES:
      return cache.heroImages;
    default:
      console.warn('No cached data mapping for query');
      return null;
  }
}

// Helper function to execute queries with cache support
export async function query<T>(queryDoc: any, variables?: any): Promise<T> {
  // Try to use cached data if enabled
  if (USE_CACHE) {
    if (!cache) {
      cache = await loadCache();
    }

    if (cache) {
      const cachedResult = getCachedDataForQuery(queryDoc, variables);
      if (cachedResult) {
        console.log('📦 Using cached data for query');
        return cachedResult as T;
      }
    }
  }

  // Fallback to live GraphQL query
  try {
    const result = await client.query({
      query: queryDoc,
      variables,
    });

    if (result.error) {
      console.error('GraphQL Error:', result.error);
      throw new Error(result.error.message || 'GraphQL query failed');
    }

    return result.data as T;
  } catch (error) {
    console.error('Query Error:', error);

    // If live query fails and we have cache, try to use it as fallback
    if (!USE_CACHE && !cache) {
      cache = await loadCache();
    }

    if (cache) {
      const cachedResult = getCachedDataForQuery(queryDoc, variables);
      if (cachedResult) {
        console.warn('⚠️ Live query failed, using cached data as fallback');
        return cachedResult as T;
      }
    }

    throw error;
  }
}

// Helper function to execute mutations
export async function mutate<T>(mutation: any, variables?: any): Promise<T> {
  try {
    const result = await client.mutate({
      mutation,
      variables,
    });

    if (result.error) {
      console.error('GraphQL Errors:', result.error);
      throw new Error(result.error.message || 'GraphQL mutation failed');
    }

    return result.data as T;
  } catch (error) {
    console.error('Mutation Error:', error);
    throw error;
  }
}
