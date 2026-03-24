#!/usr/bin/env bash

# Enable WebP conversion for all image styles
# Run this script when your site is ready to convert all image styles to WebP (AVIF with WebP fallback).

set -e

echo "========================================="
echo "Optimize Image Styles (AVIF + WebP)"
echo "========================================="
echo ""

# Check if Drush is available
if [ ! -f "vendor/bin/drush" ]; then
    echo "❌ Drush not found. Run 'composer install' first."
    exit 1
fi

# Enable WebP module
echo "Step 1: Enabling WebP module..."
vendor/bin/drush en webp -y
echo ""

# Optimize all image styles with AVIF+WebP
echo "Step 2: Optimizing all image styles with AVIF (WebP fallback)..."
vendor/bin/drush image-styles:optimize
echo ""

# Clear caches
echo "Step 3: Clearing caches..."
vendor/bin/drush cr
echo ""

echo "========================================="
echo "✓ Done!"
echo "========================================="
echo ""
echo "All image styles now use AVIF with WebP fallback."
echo "New images will automatically be optimized."
echo ""
echo "Format served based on browser support:"
echo "  • AVIF → Modern browsers (best compression)"
echo "  • WebP → Older modern browsers (good compression)"
echo "  • Original → Legacy browsers"
echo ""
echo "To regenerate existing images:"
echo "  drush image-flush --all"
echo ""
