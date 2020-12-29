<?php

// SET PATH
define("APPROOT", dirname(__DIR__));
define("URLROOT", dirname("http://192.168.128.119"));
define("SITENAME", "SHOP");

// SET DB_INFO
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "0410");
define("DB_NAME", "shop");

// SHOP SERVE API_INFO
define("SPAPI_ROOT", "https://management.api.shopserve.jp/v2");
define("SPAPI_USERNAME", "est628.ev");
define("SPAPI_MANAGER_PASSWORD", "c00b8990b7bec6da7ea301d3f3c8959f45162768");
define("SPAPI_OPEN_PASSWORD", "030b9661345cff54184a61d6c388bfeba9046354");

// ACCESS LOG
define("ACCESS_ROOT", "cat /var/log/apache2/access.log.1 | awk ");
define("IP", "'{print $1}'");
define("TIME", "'{print $4}'");
define("PAGE", "'{print $7}'");
define("URL", "'{print $7}'");
define("RULE", " | sort | uniq -c | sort -rn");