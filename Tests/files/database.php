<?php

/**
 * Qubus\Config
 *
 * @link       https://github.com/QubusPHP/config
 * @copyright  2020 Joshua Parker <josh@joshuaparker.blog>
 * @copyright  2016 Sinergi
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 *
 * @since      1.0.0
 */

return [
    'connections' => [
        'default' => [
            'driver' => "pdo_mysql",
            'host' => "127.0.0.1",
            'dbname' => "my_database",
            'user' => "my_user",
            'password' => "my_password"
        ]
    ]
];
