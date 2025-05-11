<?php

return [
    'encryption_key' => env('LICENSE_ENCRYPTION_KEY'),
    'key' => function () {
        try {
            return decrypt(env('APP_LICENSE_KEY_ENC'));
        } catch (\Exception $e) {
            return null;
        }
    },
];
