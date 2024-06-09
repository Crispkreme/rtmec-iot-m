<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * The role that the user must have to access the route.
     *
     * @var string
     */
    protected $role;

    /**
     * Create a new middleware instance.
     *
     * @param  string|null  $role
     * @return void
     */
    public function __construct(?string $role = 'guest')
    {
        $this->role = $role;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role !== $this->role) {
            abort(403);
        }

        return $next($request);
    }
}
