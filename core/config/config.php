<?php
return [
    "SiteName" => "My simple mvc framework",
    "DefaultRoute" => "site/index",
    "components" => [
        "twig" => [
            "cache_path" => "./../core/Templates/cache",
            "template_path" => "./../core/Templates",
        ],
        "db"=>[
            'driver' => 'mysql',
            'host' => 'mysql.zzz.com.ua',
            'database' => 'RomanovaVasilenko',
            'username' => 'admin',
            'password' => 'admin',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => ''
        ],
    ],
];

