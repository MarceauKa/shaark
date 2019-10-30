<?php

return [
    // Settings
    'settings' => [
        'backup' => [
            'title' => 'Backup',
            'enabled' => 'Backup enabled?',
            'enabled_help' => 'Ensure that your backup configuration is correct.',
            'only_database' => 'Save only database?',
            'period' => 'Backup period',
            'period_daily' => 'Daily',
            'period_weekly' => 'Weekly',
        ]
    ],

    // Mails
    'mails' => [
        '2fa' => [
            'title' => 'Secure your login',
            'message' => 'Please use the following code :code to access your account.',
            'button' => 'Confirm login',
        ],
    ],
];
