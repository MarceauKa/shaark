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
            'private_archive' => "Archive als privat umstellen? ",
            'link_archive_pdf' => "PDF-Archivierung (Webseiten zu PDF)",
            'node_bin' => "ausführbare Node.js-Datei",
            'link_archive_media' => "Archvierung der Medien (Youtube, Soundcloud, ...)",
            'youtube_dl_bin' => "ausführbare Youtube-dl-Datei",
        ],

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
            'title' => 'Sichern Sie Ihre Anmeldung ab',
            'message' => 'Bitte verwenden Sie den folgenden Code :code, um auf Ihr Konto zuzugreifen.',
            'button' => 'Anmeldung bestätigen'
        ],
    ],
];
