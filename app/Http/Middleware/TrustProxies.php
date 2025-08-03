<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     * Set to '*' to trust all proxies or specify array of IPs.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies = '*';

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    /**
     * The headers that should be used to detect proxies.
     *
     * @var null|int
     */
    protected $headers = 0;
}
