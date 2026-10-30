<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SiteVisit;

class TrackSiteVisits
{
    private static bool $tableChecked = false;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Track GET requests on public pages (status 200 OK, 301/302 Redirect, 304 Not Modified)
        if ($request->isMethod('GET')) {
            $status = $response->getStatusCode();
            if ($status >= 200 && $status < 400) {
                $path = $request->path();
                $host = $request->getHost();

                // Ignorar acessos administrativos, internos, API, storage e subdomínio do sysadmin
                $isInternalOrAdminPath = str_starts_with($path, 'admin') || 
                                         str_starts_with($path, 'api') || 
                                         str_starts_with($path, '_') || 
                                         str_starts_with($path, 'storage') ||
                                         str_contains($host, 'sysadmin.') ||
                                         $request->ajax();

                // Ignorar visitas quando for um Administrador ou Técnico logado navegando no site
                $isAdminUser = false;
                if (auth()->check()) {
                    $user = auth()->user();
                    if (method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['admin', 'tech', 'formador', 'instrutor'])) {
                        $isAdminUser = true;
                    }
                }

                if (!$isInternalOrAdminPath && !$isAdminUser) {
                    try {
                        if (!self::$tableChecked) {
                            SiteVisit::ensureTableExists();
                            self::$tableChecked = true;
                        }

                        SiteVisit::create([
                            'ip'         => $request->ip() ?: '127.0.0.1',
                            'url'        => substr($request->fullUrl(), 0, 500),
                            'path'       => substr('/' . ltrim($path, '/'), 0, 255),
                            'referer'    => substr($request->headers->get('referer') ?? '', 0, 500),
                            'user_agent' => substr($request->userAgent() ?? '', 0, 500),
                        ]);
                    } catch (\Throwable $e) {
                        \Illuminate\Support\Facades\Log::warning('Site visit tracking error: ' . $e->getMessage());
                    }
                }
            }
        }

        return $response;
    }
}
