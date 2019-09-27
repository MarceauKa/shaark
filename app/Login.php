<?php

namespace App;

use Lab404\AuthChecker\Models\Login as BaseLogin;

class Login extends BaseLogin
{
    const TYPE_2FA = '2fa';
}
