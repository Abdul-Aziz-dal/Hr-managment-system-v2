<?php

//*****MysqlENV*********//
define('DB_HOST', 'hr-system-db.cj4ukegkeuvq.us-east-1.rds.amazonaws.com');
define('DB_USER', 'root');
define('DB_PASS', 'Hrsystem12$$$');
define('DB_NAME', 'hr-system');

$baseUrl=rtrim($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'], '/');
define('BASE_URL', $baseUrl);

define('GCLIENT_ID', "158640470724-g7c2tda757lq3fgeemapv9ulhov5grc5.apps.googleusercontent.com");
define('GCLIENT_SECRET', "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");
define('GCLIENT_SCOPE', "https://www.googleapis.com/auth/drive");

define('GCLIENT_REDIRECT', "http://localhost/hr-onboarding-system/pages/users.php");

define('OAUTH2_TOKEN_URI',"https://oauth2.googleapis.com/token");
define('DRIVE_FILE_UPLOAD_URI',"https://www.googleapis.com/upload/drive/v3/files");
define('DRIVE_FILE_META_URI',"https://www.googleapis.com/drive/v3/files/");

define('SENDGRID_API_KEY',"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");
define('SENDGRID_FROM_EMAIL',"report-services@retailistan.com");
define('SENDGRID_END_POINT',"https://api.sendgrid.com/v3/mail/send");

