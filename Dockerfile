# Stage 1: Build assets with Node.js
FROM node:18 as node_assets

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Setup PHP environment with Apache
FROM heroku/php-apache2

# Copy application code
COPY . /app/
WORKDIR /app/

# Copy built assets from the node_assets stage
COPY --from=node_assets /app/public/build /app/public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port and start Apache
EXPOSE 80
CMD ["heroku-php-apache2", "public/"]