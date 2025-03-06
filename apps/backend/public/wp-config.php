<?php

/* Autoload dependencies */
require dirname(__DIR__) . '/vendor/autoload.php';

/* The env function */
function env(string $key, $default = null) {
  if (!isset($_ENV[$key])) {
    return $default;
  }
  return $_ENV[$key];
}

/* Load the environment variables */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . './../../../');
$dotenv->load();

/* MySQL database name */
define('DB_NAME', env('DB_DATABASE'));

/* MySQL database username */
define('DB_USER', env('DB_USERNAME'));

/* MySQL database password */
define('DB_PASSWORD', env('DB_PASSWORD'));

/* MySQL hostname */
define('DB_HOST', env('DB_HOST'));

/* Database Charset to use in creating database tables */
define('DB_CHARSET', env('DB_CHARSET', 'utf8mb4'));

/* The Database Collate type. Don't change this if in doubt */
define('DB_COLLATE', env('DB_COLLATE', ''));

/* Set the home url to the current domain */
define('WP_HOME', env('APP_URL'));

/* Custom WordPress directory */
define('WP_SITEURL', WP_HOME . '/admin');

/* Custom content directory */
define('WP_CONTENT_DIR', env('WP_CONTENT_DIR', __DIR__));

/* Custom content url */
define('WP_CONTENT_URL', env('WP_CONTENT_URL', WP_HOME));

/* Set the trash to less days to optimize WordPress */
define('EMPTY_TRASH_DAYS', env('EMPTY_TRASH_DAYS', 7));

/* Set the default WordPress theme */
define('WP_DEFAULT_THEME', env('WP_THEME', 'headless'));

/* Specify the Number of Post Revisions */
define('WP_POST_REVISIONS', env('WP_POST_REVISIONS', 2));

/* WordPress environment */
define('WP_ENV', env('APP_ENV', 'production'));

/* Authentication Unique Keys and Salts */
define('AUTH_KEY', env('AUTH_KEY'));
define('SECURE_AUTH_KEY', env('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY', env('LOGGED_IN_KEY'));
define('NONCE_KEY', env('NONCE_KEY'));
define('AUTH_SALT', env('AUTH_SALT'));
define('SECURE_AUTH_SALT', env('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT', env('LOGGED_IN_SALT'));
define('NONCE_SALT', env('NONCE_SALT'));

/* Table prefix */
$table_prefix = env('DB_PREFIX', 'wp_');

/* Debug mode */
define('WP_DEBUG', env('APP_DEBUG') === 'true' ? true : false);
define('WP_DEBUG_DISPLAY', env('APP_DEBUG') === 'true' ? true : false);
define('SCRIPT_DEBUG', env('APP_DEBUG') === 'true' ? true : false);

/* Add multisite support */
define('WP_ALLOW_MULTISITE', env('WP_ALLOW_MULTISITE', false));

if (env('WP_MULTISITE', false)) {
  define('MULTISITE', env('WP_MULTISITE', false));
  define('SUBDOMAIN_INSTALL', env('SUBDOMAIN_INSTALL', false));
  define('DOMAIN_CURRENT_SITE', env('DOMAIN_CURRENT_SITE', $_SERVER['HTTP_HOST']));
  define('PATH_CURRENT_SITE', env('PATH_CURRENT_SITE', '/'));
  define('SITE_ID_CURRENT_SITE', env('SITE_ID_CURRENT_SITE', 1));
  define('BLOG_ID_CURRENT_SITE', env('BLOG_ID_CURRENT_SITE', 1));
}

// Increase memory limit
define('WP_MEMORY_LIMIT', '512M');
define('WP_MAX_MEMORY_LIMIT', '512M');

/* Absolute path to the WordPress directory */
if (!defined('ABSPATH')) {
  define('ABSPATH', __DIR__ . '/');
}

/* Sets up WordPress vars and included files */
require_once ABSPATH . 'wp-settings.php';
