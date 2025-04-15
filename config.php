<?php

// ========== KUARASY ==========

define('KUARASY_VERSION', '1.8.0');

// ========== ENV (.env file) ==========

$env = parse_ini_file('.env');

// ========== DATABASE ==========

define('K_DB_HOST', $env['DATABASE_HOST']);
define('K_DB_NAME', $env['DATABASE_NAME']);
define('K_DB_USER', $env['DATABASE_USER']);
define('K_DB_PASSWORD', $env['DATABASE_PASSWORD']);
define('K_DB_DRIVER', 'mysql');

// ========== APPLICATION ==========

ini_set('log_errors', 1);
ini_set('display_errors', 0);

define('DEFAULT_VIEW', 'example');
define('VIEW_FILENAMES', ['index', 'default']);
define('VIEW_EXTS', ['.html', '.php']);
define('CUSTOM_VIEW', []); // View path points to View Class ['movie' => 'Movie']

define('BASEPATH', '/kuarasy');
define('SITE_URL', (isset($_SERVER['REQUEST_SCHEME']) && isset($_SERVER['SERVER_NAME'])) ? ($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . BASEPATH) : null);

define('UPLOADS_DIR', dirname(__DIR__, 1) . BASEPATH . '/uploads/');
define('SUPPORTED_FILE_TYPES', [
  'text/plain',
  'text/csv',
  'application/pdf',
  'image/png',
  'image/jpg',
  'image/jpeg',
  'image/gif'
]);
