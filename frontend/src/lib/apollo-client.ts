/**
 * GraphQL Client Configuration
 * Apollo Client setup for WordPress GraphQL API
 */

import {
  ApolloClient,
  InMemoryCache,
  HttpLink,
  ApolloLink,
} from '@apollo/client';
import { removeTypenameFromVariables } from '@apollo/client/link/remove-typename';

const GRAPHQL_ENDPOINT =
  import.meta.env.PUBLIC_GRAPHQL_ENDPOINT || 'http://localhost:8000/graphql';

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

// Helper function to execute queries
export async function query<T>(query: any, variables?: any): Promise<T> {
  try {
    const result = await client.query({
      query,
      variables,
    });

    if (result.error) {
      console.error('GraphQL Error:', result.error);
      throw new Error(result.error.message || 'GraphQL query failed');
    }

    return result.data as T;
  } catch (error) {
    console.error('Query Error:', error);
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
