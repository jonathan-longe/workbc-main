workbc-main
===========

This is the WorkBC site on Drupal.

[![Lifecycle:Experimental](https://img.shields.io/badge/Lifecycle-Experimental-339999)](https://github.com/bcgov/workbc-ssot)

# Development
- Start the environment: `docker-compose up`
- In a separate terminal, install the latest dependencies: `docker-compose exec php composer install`. If you run into timeout issues while it's installing/unzipping PHP, try the following:
  - `docker-compose exec php composer config --global process-timeout 600`
  - `docker-compose exec php composer install --prefer-dist --no-dev`
- Adjust file permissions: `docker-compose exec php sudo chown www-data /var/www/html/private`
- Enable needed PostgreSQL extension: `docker-compose exec postgres psql -U workbc -d workbc -c "CREATE EXTENSION IF NOT EXISTS pg_trgm;"`
- Import a Drupal data dump: `docker-compose exec -T postgres psql --username workbc workbc < /path/to/workbc-dump.sql` (in Windows PowerShell: `cmd /c "docker-compose exec -T postgres psql --username workbc workbc < /path/to/workbc-dump.sql"`)
- Import a SSoT data dump: `docker-compose exec -T postgres psql --username workbc ssot < /path/to/ssot-dump.sql` (in Windows PowerShell: `cmd /c "docker-compose exec -T postgres psql --username workbc ssot < /path/to/ssot-dump.sql"`)
- Edit your `hosts` file to add the following line:
```
127.0.0.1       workbc.docker.localhost
```
- Open http://workbc.docker.localhost:8000/ to view the site and login as `admin` (obtain the password from your admin)
- Open http://localhost:8080/ to view the SSoT API

## Windows
If you are experiencing errors running the prototype on a Windows computer (ie. white screen of death) this is likely due to issues with WSL 2. Try unchecking "Use the WSL 2 based engine" in the Docker Desktop options.

If that doesn't work you can use [WAMP](https://www.wampserver.com/en/) as your web server and PHP service and follow the steps below:

- Ensure the PHP extension `pdo_pgsql` is actived
- Edit your `hosts` file to add the following lines:
```
127.0.0.1       workbc.localhost
127.0.0.1       ssot
127.0.0.1       postgres
```
- Edit your `httpd-vhosts.conf` file and add the following lines:
```
<VirtualHost *:80>
    ServerAdmin webmaster@workbc.localhost
    DocumentRoot "C:/Path/To/htdocs/workbc-main/src/web"
    ServerName workbc.localhost
    ErrorLog "logs/workbc-error.log"
    CustomLog "logs/workbc-access.log" common
  	<Directory "C:/Path/To/htdocs/workbc-main/src/web">
	    Options -Indexes +FollowSymLinks +Includes
    	AllowOverride All
    	Require local
  	</Directory>
</VirtualHost>
```
- `docker-compose -f docker-compose.yml -f docker-compose.wamp.yml up`

## Updating local dev environment after git pull
As drupal core and drupal contrib module source code is not committed to the git repo, you will need to use composer to download any new or updated source code. From within `docker-compose exec php bash`, do:
- `composer install` to update source code
- `drush cim` to import new configuration
- `drush cr` to rebuild the cache

In some situations `drush cim` fails. In this case, the Drupal UI (Configuration -> Development -> Configuration Syncronization) should work.

## Installing modules
- Execute the composer requires command for the module. The module project page on Drupal.org provides this command. E.g. `composer require 'drupal/devel:^4.1'`
- Enable the module via Drupal UI Extend menu option
- Export updated configuration to the config/sync folder using `drush cex`

## Backup / Restore
The drupal Backup & Migrate module does not currently support PostgresQL. Backing up and restoring your local dev site can be accomplished using `drush`:

- To backup: `drush sql:dump --result-file=example.sql`. For more info https://www.drush.org/latest/commands/sql_dump/
- To restore: `drush sql:cli < example.sql`. For more info https://www.drush.org/latest/commands/sql_cli/

## Theming / Styling
Please see the `src/web/themes/custom/workbc/README.md` for more details.
