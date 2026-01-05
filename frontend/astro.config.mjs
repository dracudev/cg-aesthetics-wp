// @ts-check
import { defineConfig } from 'astro/config';

import tailwindcss from '@tailwindcss/vite';
import react from '@astrojs/react';

// https://astro.build/config
export default defineConfig({
  output: 'static',
  site: 'https://carmeng-beauty.com', // Production URL
  // No base needed - htaccess handles routing

  vite: {
    plugins: [tailwindcss()],
  },

  integrations: [react()],
});
