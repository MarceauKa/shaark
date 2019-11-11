<?php

return [
    // Settings
    'settings' => [
        'general' => [
            'title' => 'General',
            'install_button' => 'Install',
            'site_name' => 'Site name',
            'lang' => 'Language',
            'private_help' => 'Private content (all content is private and login is required)',
            'private_download' => 'Keep downloads private (links and albums)',
            'use_default_search' => 'Use classic SQL search instead of full-text search',
        ],

        'appearance' => [
            'title' => 'Appearance',
            'is_dark' => 'Dark mode',
            'home_show_tags' => 'Show tags on homepage',
            'home_show_chests' => 'Show chests on homepage',
            'compact_cardslist' => 'Compact cards list',
            'columns_count' => 'Number of columns to show',
            'custom_background' => 'Custom background',
            'custom_icon' => 'Custom icon (512x512, .png)',
        ],

        '2fa' => [
            'title' => 'Secure login',
            'check_email' => 'Test email',
            'secure_login' => '2-FA login (requires a code sent by email)',
            'secure_code_expires' => 'Secure code expiration (in minutes)',
            'secure_code_length' => 'Secure code length',
        ],

        'archiving' => [
            'title' => 'Archiving',
            'link_archive_pdf' => 'PDF archiving (Web pages to PDF)',
            'node_bin' => 'Node.js binary',
            'link_archive_media' => 'Media archiving (Youtube, Soundcloud, ...)',
            'youtube_dl_bin' => 'Youtube-dl binary',
            'python_bin' => 'Python binary',
            'check_pdf_archiving' => 'Test PDF archiving',
            'check_media_archiving' => 'Test Media archiving',
        ],

        'backup' => [
            'title' => 'Backup',
            'enabled' => 'Backup enabled?',
            'enabled_help' => 'Ensure that your backup configuration is correct.',
            'only_database' => 'Save only database?',
            'period' => 'Backup period',
            'period_daily' => 'Daily',
            'period_weekly' => 'Weekly',
        ],

        'images' => [
            'title' => 'Images',
            'images_original_resize' => 'Resize original image?',
            'images_original_resize_width' => 'Original max width in pixels',
            'images_thumb_format' => 'Thumbnail format',
            'format_square' => 'Square',
            'format_original' => 'Original',
            'images_thumb_queue' => 'Generate thumbnail in background?',
        ]
    ],

    // Mails
    'mails' => [
        '2fa' => [
            'title' => 'Secure your login',
            'message' => 'Please use the following code :code to access your account.',
            'button' => 'Confirm login',
        ],

        'check' => [
            'title' => 'It works!',
            'message' => 'This email was sent by :name to test your email configuration.',
        ],
    ],
];
