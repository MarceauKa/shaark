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
            'private_download' => 'ダウンロードを非公開にしますか？（ＵＲＬとアルバム）',
            'use_default_search' => 'クラシックＳＱＬ検索を使用（デフォルト：全文検索）',
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
            'link_archive_pdf' => 'ＰＤＦアーカイブ (サイトをＰＤＦ化)',
            'node_bin' => 'Node.jsバイナリ',
            'link_archive_media' => 'メディアアーカイブ (Youtube, Soundcloud, ...)',
            'youtube_dl_bin' => 'Youtube-dlバイナリ',
            'python_bin' => 'Pythonバイナリ',
            'check_pdf_archiving' => 'ＰＤＦアーカイブのテストを実行',
            'check_media_archiving' => 'メディアアーカイブのテストを実行',
        ],

        'backup' => [
            'title' => 'バックアップ',
            'enabled' => 'バックアップを有効にしますか？',
            'enabled_help' => 'バックアップの構成が正しいことを確認してください。',
            'only_database' => 'データーベースのみ',
            'period' => 'バックアップ頻度',
            'period_daily' => '毎日',
            'period_weekly' => '毎週',
        ],

        'images' => [
            'title' => '画像',
            'images_original_resize' => '元の画像のサイズを変更しますか？',
            'images_original_resize_width' => '元の画像の最大幅（ピクセル）',
            'images_thumb_format' => 'サムネールのフォーマット',
            'format_square' => '四角',
            'format_original' => 'オリジナル',
            'images_thumb_queue' => 'バックグラウンドでサムネールを生成しますか？',
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
            'title' => 'ログインを安全化にする',
            'message' => 'アカウントをアクセスするために、このコードを入力してください：:code',
            'button' => 'ログインを確認'
        ],

        'check' => [
            'title' => 'It works!',
            'message' => 'This email was sent by :name to test your email configuration.',
        ],

        'comment' => [
            'title' => 'New comment',
            'message' => 'You have a comment from ":name" (:email) to the post ":post".',
            'action' => 'View',
        ],

        'unmoderated' => [
            'title' => 'New unmoderated comment',
            'message' => 'You have a new unmoderated comment from ":name" (:email) to the post ":post".',
            'action' => 'View and moderate',
        ]
    ],
];
