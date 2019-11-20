<?php

return [
    // Settings
    'settings' => [
        'general' => [
            'title' => 'Allgemeines',
            'install_button' => 'Install',
            'site_name' => 'Name der Website',
            'lang' => 'Sprache',
            'private_help' => 'Privater Inhalt (alle Inhalte sind privat und eine Anmeldung ist erforderlich)',
            'private_download' => 'Downloads privat halten (Links und Alben)',
            'use_default_search' => 'Use classic SQL search instead of full-text search',
        ],

        'appearance' => [
            'title' => "Aussehen",
            'is_dark' => "Dark Mode",
            'home_show_tags' => "Zeige Tags auf der Homepage",
            'home_show_chests' => "Zeige Truhen auf der Homepage",
            'compact_cardslist' => "Komprimiere die Liste der Karten",
            'columns_count' => "Anzahl der angezeigten Spoalten",
            'custom_background' => "Benutzerdefiniertes Hintergrundbild",
            'custom_icon' => "Custom icon (PNG, 512px)",
        ],

        '2fa' => [
            'title' => "sichere Anmeldung",
            'secure_login' => "Zwei-Faktor-Authentifizierung (erfordert einen per E-Mail gesendeten Code)",
            'secure_code_expires' => "Ablauf des Sicherheitscodes (in Minuten)",
            'secure_code_length' => "Länge des Sicherheitscodes",
        ],

        'archiving' => [
            'title' => "Archivierung",
            'link_archive_pdf' => "PDF-Archivierung (Webseiten zu PDF)",
            'node_bin' => "ausführbare Node.js-Datei",
            'link_archive_media' => "Archvierung der Medien (Youtube, Soundcloud, ...)",
            'youtube_dl_bin' => "ausführbare Youtube-dl-Datei",
            'python_bin' => 'ausführbare Python-Datei',
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
        ],

        'comments' => [
            'title' => 'Comments',
            'comments_enabled' => 'Enable comments',
            'comments_guest_view' => 'Guests can see comments',
            'comments_guest_add' => 'Guests can add comments',
            'comments_moderation' => 'New comment moderation',
            'comments_notification' => 'New comment notification',
            'disabled' => 'Disabled',
            'whitelist' => 'White-listing',
            'all' => 'All',
        ]
    ],

    // Mails
    'mails' => [
        '2fa' => [
            'title' => 'Sichern Sie Ihre Anmeldung ab',
            'message' => 'Bitte verwenden Sie den folgenden Code :code, um auf Ihr Konto zuzugreifen.',
            'button' => 'Anmeldung bestätigen'
        ],

        'check' => [
            'title' => 'It works!',
            'message' => 'This email was sent by :name to test your email configuration.',
        ],
    ],
];
