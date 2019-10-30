<?php

return [
    // Settings
    'settings' => [
        'backup' => [
            'title' => 'Sauvegarde',
            'enabled' => 'Sauvegarde activée ?',
            'enabled_help' => "Vérifiez votre configuration avant de l'activer.",
            'only_database' => 'Sauvegarder seulement la base de données',
            'period' => 'Période de sauvegarde',
            'period_daily' => 'Tous les jours',
            'period_weekly' => 'Toutes les semaines',
        ]
    ],

    // Mails
    'mails' => [
        '2fa' => [
            'title' => 'Sécurisez votre connexion',
            'message' => 'Veuillez utiliser le code suivant :code pour sécuriser votre connexion.',
            'button' => 'Confirmer la connexion'
        ],
    ],
];
