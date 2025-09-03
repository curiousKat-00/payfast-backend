# Use an official PHP image with the Apache web server pre-installed.
# Using a specific version is good practice, e.g., 8.2.
FROM php:8.2-apache

# Copy the application files from your repository (payfast.php, notify.php)
# into the public web directory of the Apache server inside the container.
COPY . /var/www/html/