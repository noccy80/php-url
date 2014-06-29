<?php

require_once __DIR__."/../vendor/autoload.php";

use NoccyLabs\Url\Url;


$base = "http://domain.tld/path/to/file.html";

echo Url::create($base)->apply("image.jpg")."\n";;
echo Url::create($base)->apply("/image.jpg")."\n";
