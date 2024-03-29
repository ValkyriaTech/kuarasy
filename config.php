<?php

// ========== KUARASY ==========

define('KUARASY_VERSION', '1.5.2');

// ========== DATABASE ==========

define('K_DB_NAME', '');
define('K_DB_USER', '');
define('K_DB_PASSWORD', '');

// ========== APPLICATION ==========

ini_set('log_errors', 1);
ini_set('display_errors', 0);

define('DEFAULT_VIEW', 'example');
define('VIEW_FILENAMES', ['index', 'default']);
define('VIEW_EXTS', ['.html', '.php']);

define('BASEPATH', '');
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
