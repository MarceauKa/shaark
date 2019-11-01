<?php

return [
    // Settings
    'settings' => [
        'general' => [
            'title' => '一般',
            'install_button' => 'インストール',
            'site_name' => 'サイトの名前',
            'lang' => '言語',
            'private_help' => '非公開（全てのコンテンツが非公開になる。コンテンツへのアクセスにログインが必要。）',
        ],

        'appearance' => [
            'title' => '外見',
            'is_dark' => 'ダークモード',
            'home_show_tags' => 'ホームページにタグを表示する',
            'home_show_chests' => 'ホームページにチェストを表示する',
            'compact_cardslist' => 'カードのコンパクト表示',
            'columns_count' => 'コラム表示数',
            'custom_background' => 'カスタム背景',
            'custom_icon' => 'カスタムアイコン(PNG, 512px)',
        ],

        '2fa' => [
            'title' => '安全なログイン',
            'secure_login' => '二要素認証 (メールで送られた厳密コードは必要とする)',
            'secure_code_expires' => '厳密コードの有効期限 (分単位)',
            'secure_code_length' => '厳密コードの長さ',
        ],

        'archiving' => [
            'title' => 'アーカイブ中',
            'private_archive' => 'アーカイブを非公開にしますか？',
            'link_archive_pdf' => 'ＰＤＦアーカイブ (サイトをＰＤＦ化)',
            'node_bin' => 'Node.jsバイナリ',
            'link_archive_media' => 'メディアアーカイブ (Youtube, Soundcloud, ...)',
            'youtube_dl_bin' => 'Youtube-dlバイナリ',
        ],

        'backup' => [
            'title' => 'バックアップ',
            'enabled' => 'バックアップを有効にしますか？',
            'enabled_help' => 'バックアップの構成が正しいことを確認してください。',
            'only_database' => 'データーベースのみ',
            'period' => 'バックアップ頻度',
            'period_daily' => '毎日',
            'period_weekly' => '毎週',
        ]
    ],

    // Mails
    'mails' => [
        '2fa' => [
            'title' => 'ログインを安全化にする',
            'message' => 'アカウントをアクセスするために、このコードを入力してください：:code',
            'button' => 'ログインを確認'
        ],
    ],
];
