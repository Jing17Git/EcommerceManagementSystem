#!/bin/bash

# Railway Post-Deployment Script
# This runs after every deployment

echo "🚀 Running post-deployment tasks..."

# Run migrations
echo "📦 Running migrations..."
php artisan migrate --force

# Create admin account if not exists
echo "👤 Creating admin account..."
php artisan db:seed --class=CreateAdminAccountSeeder --force

echo "✅ Deployment complete!"
