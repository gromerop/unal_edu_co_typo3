import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const buildDirectory = dirname(fileURLToPath(import.meta.url));

export default {
  build: {
    emptyOutDir: true,
    outDir: resolve(buildDirectory, '../Resources/Public/Build'),
    lib: {
      entry: resolve(
        buildDirectory,
        'Sources/JavaScript/vendor.js'
      ),
      name: 'UnalSkinDefaultVendor',
      formats: ['iife'],
      fileName: () => 'vendor.js',
    },
  },
};