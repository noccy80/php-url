<?php

require_once __DIR__."/../vendor/autoload.php";

use NoccyLabs\Url\Url;

echo Url::canonize("google.com") . PHP_EOL;

echo Url::canonize("foo.com/bar?baz=true") . PHP_EOL;
