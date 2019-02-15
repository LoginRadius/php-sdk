<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
define('API_KEY', ''); // Pass API Key
define('API_SECRET', '');  // Pass API Secret Key
define('API_REQUEST_SIGNING', ''); // Pass boolean true/false for enable/disable
define('AUTH_FLOW', '');   // Pass optional/disabled, if email verification flow optional or disabled, no need to mention if required flow

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
