# Use the Gitpod full environment as the base
FROM gitpod/workspace-full

# Install MySQL client for CLI database access
USER root
RUN apt-get update && apt-get install -y mysql-client && apt-get clean && rm -rf /var/cache/apt/* && rm -rf /var/lib/apt/lists/* && rm -rf /tmp/*
# Set up default config file for CLI to connect to the project DB
RUN echo "[mysql]" > /etc/mysql/conf.d/mysql.cnf
RUN echo "host=0.0.0.0" >> /etc/mysql/conf.d/mysql.cnf
RUN echo "user=uberflip" >> /etc/mysql/conf.d/mysql.cnf
RUN echo "password=pass123" >> /etc/mysql/conf.d/mysql.cnf
RUN echo "database=university" >> /etc/mysql/conf.d/mysql.cnf

# Install the newest version of Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN echo "alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'" >> ~/.bashrc
