<?php

ini_set('log_errors', 1);
ini_set('display_errors', 0);

// ========== DATABASE ==========

define('DB_NAME', '');
define('DB_USER', '');
define('DB_PASSWORD', '');

// ========== APPLICATION ==========

define('DEFAULT_VIEW', 'example');
define('VIEW_FILENAMES', ['index', 'default']);
define('VIEW_EXTS', ['.html', '.php']);

define('BASEPATH', '');
define('UPLOADS_DIR', dirname(__DIR__, 1) . BASEPATH . '/uploads/');
