<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StatusChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (request('version_control') && Filament::auth()->user())
            return $next($request);

        foreach ($request->route()->parameters() as $name => $value) {
            if ($value instanceof Model && !$value->status) {
                throw new NotFoundHttpException();
            }
        }
        return $next($request);
    }
}
