<?php

$url = parse_url(getenv('DATABASE_URL'));

DEFINE('DB_HOST', $url['host']);
DEFINE('DB_USER', $url['user']);
DEFINE('DB_PASS', $url['pass']);
DEFINE('DB_NAME', substr($url['path'], 1));

DEFINE('SERVER_ROOT', '/');