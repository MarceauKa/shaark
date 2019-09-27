<?php

use App\Login;

return [

    /*
    |--------------------------------------------------------------------------
    | Throttling authentication logs
    |--------------------------------------------------------------------------
    |
    | You can skip authentication logs for a device if the last authentication
    | log creation is inferior to the throttle value. Set 0 to disable
    | throttling, or set the throttling time in minutes.
    |
    */
    'throttle' => env('AUTH_CHECKER_THROTTLE', 0),

    /*
    |--------------------------------------------------------------------------
    | Device matching attributes
    |--------------------------------------------------------------------------
    |
    | Declare fields that are used to define if a device is new or not for an
    | user. For example, specifying 'platform', 'platform_version' and
    | 'browser' will not create a new device if the user already has
    | a device registered for these attributes.
    |
    */
    'device_matching_attributes' => [
        # Ex: OS X, Windows, ...
        'platform',
        # Ex: 10_12_2, 8, ...
        'platform_version',
        # Ex: Chrome, Firefox, ...
        'browser',
        # Ex: 42.0.2311.135, 37.0, ...
        //'browser_version',
    ],

    /*
    |--------------------------------------------------------------------------
    | User login column
    |--------------------------------------------------------------------------
    |
    | Declare the name of the column used to authenticate an user.
    | By default, it's 'email' but you can change it to your needs.
    |
    */
    'login_column' => 'email',

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | Customize models used by the package.
    | Custom models must extends defaults ones.
    |
    */
    'models' => [
        # Ex: App\Models\Device (default: Lab404\AuthChecker\Models\Device)
        'device' => null,
        # Ex: App\Models\Login (default: Lab404\AuthChecker\Models\Login)
        'login' => Login::class,
    ]

];
