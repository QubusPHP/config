<?php

use function Qubus\Config\Helpers\env;

return [
    'test_var' => env('TEST_VAR', 'bye'),
];
