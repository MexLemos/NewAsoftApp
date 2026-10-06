<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SiteVisit;

class TrackSiteVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track successful GET requests on non-administrative pages
        if ($request->isMethod('GET') && $response->getStatusCode() === 200) {
            $path = $request->path();

            if (!str_starts_with($path, 'admin') && 
                !str_starts_with($path, 'api') && 
                !str_starts_with($path, '_') && 
                !str_starts_with($path, 'storage') &&
                !$request->ajax()) {
                
                try {
                    SiteVisit::ensureTableExists();

                    SiteVisit::create([
                        'ip'         => $request->ip(),
                        'url'        => substr($request->fullUrl(), 0, 500),
                        'path'       => substr('/' . ltrim($path, '/'), 0, 255),
                        'referer'    => substr($request->headers->get('referer') ?? '', 0, 500),
                        'user_agent' => substr($request->userAgent() ?? '', 0, 500),
                    ]);
                } catch (\Throwable $e) {
                    // Fail silently to never interrupt visitor browsing
                }
            }
        }

        return $response;
    }
}
