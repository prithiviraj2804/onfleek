# Use the official PHP image with Apache
FROM php:7.3-apache


# Set the environment variable for non-interactive installations
ENV DEBIAN_FRONTEND=noninteractive

# Update package repository and install WireGuard
RUN apt update 
RUN apt install -y wireguard sudo net-tools openssh-server iptables iproute2\
    && docker-php-ext-install mysqli

# Copy application code to the container

# Copy the startup script and WireGuard configuration
COPY startup.sh /usr/local/bin/start-server.sh
COPY wg0.conf /etc/wireguard

# Make the startup script executable
RUN chmod +x /usr/local/bin/start-server.sh

# Create a user called mechtool with a password mechtool@321
RUN adduser mechtool --gecos "" --disabled-password
RUN echo "mechtool:mechtool@321" | sudo chpasswd
RUN usermod -aG sudo mechtool
RUN mkdir /home/mechtool/htdocs
COPY . /home/mechtool/htdocs
# Enable .htaccess and set permisssssssssions, and enable Apache mod_rewrite
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# Set the default command to run the startup script
CMD ["/usr/local/bin/start-server.sh"]
