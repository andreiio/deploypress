<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(dirname(__DIR__));
$dotenv->load();

// Load database info and local development parameters
define('DB_NAME',              getenv('DB_NAME'));
define('DB_USER',              getenv('DB_USER'));
define('DB_PASSWORD',          getenv('DB_PASSWORD'));
define('DB_HOST',              getenv('DB_HOST'));

// You almost certainly do not want to change these
define('DB_CHARSET',           'utf8');
define('DB_COLLATE',           '');

// Salts, for security
// Change these in config/secrets/salts.yaml
define('AUTH_KEY',             getenv('AUTH_KEY'));
define('SECURE_AUTH_KEY',      getenv('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY',        getenv('LOGGED_IN_KEY'));
define('NONCE_KEY',            getenv('NONCE_KEY'));
define('AUTH_SALT',            getenv('AUTH_SALT'));
define('SECURE_AUTH_SALT',     getenv('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT',       getenv('LOGGED_IN_SALT'));
define('NONCE_SALT',           getenv('NONCE_SALT'));


define('WP_HOME',              rtrim(getenv('APP_URL'), '/'));
define('WP_SITEURL',           WP_HOME . '/wp');
// Custom Content Directory
define('WP_CONTENT_DIR',       __DIR__ . '/content');
define('WP_CONTENT_URL',       WP_HOME . '/content');

// Disable editing in dashboard
define('DISALLOW_FILE_EDIT',   true);

define('APP_ENV',              getenv('APP_ENV'));
define('APP_DEBUG',            getenv('APP_DEBUG'));

if (APP_DEBUG) {
	// Hide errors in prod
	ini_set('display_errors',  0);
	define('WP_DEBUG',         false);
	define('WP_DEBUG_LOG',     false);
	define('WP_DEBUG_DISPLAY', false);
	define('SAVEQUERIES',      false);
} else {
	// Always show errors in non-prod environment
	ini_set('display_errors',  1);
	define('WP_DEBUG',         true);
	define('WP_DEBUG_LOG',     true);
	define('WP_DEBUG_DISPLAY', true);
	define('SAVEQUERIES',      true);
}

// Bootstrap WordPress
if (!defined('ABSPATH'))
	define('ABSPATH', __DIR__ . '/wp/');

require_once(ABSPATH . 'wp-settings.php');

?>
