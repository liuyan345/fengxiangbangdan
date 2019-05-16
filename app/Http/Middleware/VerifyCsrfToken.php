<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     * @var array
     */
    protected $except = [
        '/admin/power/table',
        '/admin/role/datalist',
        '/admin/admin/datalist',
        '/admin/user/datalist',
        '/admin/template/datalist',
        '/admin/check/datalist',
    ];
}
