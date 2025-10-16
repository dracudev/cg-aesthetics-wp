/**
 * GraphQL Queries for WordPress Content
 */

import { gql } from '@apollo/client';

// Fragment for Service Details
export const SERVICE_DETAILS_FRAGMENT = gql`
  fragment ServiceDetails on Service {
    id
    title
    slug
    excerpt
    featuredImage {
      node {
        sourceUrl
        altText
        mediaDetails {
          width
          height
          sizes {
            sourceUrl
            width
            height
            name
          }
        }
      }
    }
    serviceDetails {
      serviceDescription
      serviceDuration
      servicePrice
      featuredService
      bookableOnline
      bookingNotes
      serviceBenefits {
        benefitText
      }
      serviceGallery {
        sourceUrl
        altText
      }
    }
    serviceCategories {
      nodes {
        id
        name
        slug
        description
      }
    }
    seo {
      title
      metaDesc
      canonical
      opengraphTitle
      opengraphDescription
      opengraphImage {
        sourceUrl
        altText
      }
      twitterTitle
      twitterDescription
      twitterImage {
        sourceUrl
        altText
      }
      metaRobotsNoindex
      metaRobotsNofollow
      focuskw
    }
    schemaOrg
  }
`;

// Get all services
export const GET_SERVICES = gql`
  ${SERVICE_DETAILS_FRAGMENT}
  query GetServices($first: Int = 100) {
    services(first: $first, where: { orderby: { field: DATE, order: DESC } }) {
      nodes {
        ...ServiceDetails
      }
    }
  }
`;

// Get featured services
export const GET_FEATURED_SERVICES = gql`
  ${SERVICE_DETAILS_FRAGMENT}
  query GetFeaturedServices($first: Int = 4) {
    services(first: $first, where: { orderby: { field: DATE, order: DESC } }) {
      nodes {
        ...ServiceDetails
      }
    }
  }
`;

// Get single service by slug
export const GET_SERVICE_BY_SLUG = gql`
  ${SERVICE_DETAILS_FRAGMENT}
  query GetServiceBySlug($slug: ID!) {
    service(id: $slug, idType: SLUG) {
      ...ServiceDetails
    }
  }
`;

// Get services by category
export const GET_SERVICES_BY_CATEGORY = gql`
  ${SERVICE_DETAILS_FRAGMENT}
  query GetServicesByCategory($categorySlug: String!, $first: Int = 100) {
    serviceCategories(where: { slug: [$categorySlug] }) {
      nodes {
        id
        name
        description
        services(first: $first) {
          nodes {
            ...ServiceDetails
          }
        }
      }
    }
  }
`;

// Get all service categories
export const GET_SERVICE_CATEGORIES = gql`
  query GetServiceCategories {
    serviceCategories {
      nodes {
        id
        name
        slug
        description
        count
      }
    }
  }
`;

// Fragment for Team Member Details
export const TEAM_MEMBER_DETAILS_FRAGMENT = gql`
  fragment TeamMemberDetails on TeamMember {
    id
    title
    featuredImage {
      node {
        sourceUrl
        altText
      }
    }
    teamMemberDetails {
      position
      bioShort
      bioFull
      certifications
      displayOrder
      specialties {
        specialtyName
      }
    }
    seo {
      title
      metaDesc
      canonical
      opengraphImage {
        sourceUrl
        altText
      }
    }
    schemaOrg
  }
`;

// Get all team members
export const GET_TEAM_MEMBERS = gql`
  ${TEAM_MEMBER_DETAILS_FRAGMENT}
  query GetTeamMembers($first: Int = 100) {
    teamMembers(
      first: $first
      where: {
        orderby: { field: META_VALUE_NUM, order: ASC }
        metaKey: "display_order"
      }
    ) {
      nodes {
        ...TeamMemberDetails
      }
    }
  }
`;

// Fragment for Testimonial Details
export const TESTIMONIAL_DETAILS_FRAGMENT = gql`
  fragment TestimonialDetails on Testimonial {
    id
    title
    testimonialDetails {
      clientName
      reviewText
      rating
      featured
      dateSubmitted
      clientPhoto {
        sourceUrl
        altText
      }
      serviceRelated {
        ... on Service {
          id
          title
          slug
        }
      }
    }
    schemaOrg
  }
`;

// Get all testimonials
export const GET_TESTIMONIALS = gql`
  ${TESTIMONIAL_DETAILS_FRAGMENT}
  query GetTestimonials($first: Int = 100) {
    testimonials(
      first: $first
      where: { orderby: { field: DATE, order: DESC } }
    ) {
      nodes {
        ...TestimonialDetails
      }
    }
  }
`;

// Get featured testimonials (simplified without metaQuery)
export const GET_FEATURED_TESTIMONIALS = gql`
  ${TESTIMONIAL_DETAILS_FRAGMENT}
  query GetFeaturedTestimonials($first: Int = 6) {
    testimonials(
      first: $first
      where: { orderby: { field: DATE, order: DESC } }
    ) {
      nodes {
        ...TestimonialDetails
      }
    }
  }
`;

// Get general site settings
export const GET_SITE_SETTINGS = gql`
  query GetSiteSettings {
    generalSettings {
      title
      description
      url
      language
    }
    seoSettings {
      title
      metaDesc
    }
  }
`;
