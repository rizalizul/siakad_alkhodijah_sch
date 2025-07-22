<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * URIs yang dikecualikan dari CSRF (jika perlu).
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
