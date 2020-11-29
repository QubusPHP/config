<?php

use function Qubus\Config\env;

return [
    'test_var' => env('TEST_VAR', 'bye'),
];
