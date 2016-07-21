<?php

$url = parse_url(getenv('DATABASE_URL'));

DEFINE('DB_HOST', 'localhost' );
DEFINE('DB_USER', 'root' );
DEFINE('DB_PASS', '' );
DEFINE('DB_NAME', 'av_apparatuur' );

DEFINE('ASSET_PATH', dirname(__FILE__) . '/../assets/');
DEFINE('SERVER_ROOT', '/' );
DEFINE('HTTP_HOST', $_SERVER['HTTP_HOST'] . '/' );