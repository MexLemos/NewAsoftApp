<?php

if (!function_exists('app_base_domain')) {
    /**
     * Get the base domain configured for the app.
     */
    function app_base_domain(): string
    {
        $host = request()->getHost();
        if ($host && str_contains($host, 'softmedia-ao.com')) {
            return 'softmedia-ao.com';
        }
        
        $configured = config('app.domain');
        if ($configured) {
            return $configured;
        }

        $appUrl = config('app.url');
        if ($appUrl) {
            $parsedHost = parse_url($appUrl, PHP_URL_HOST);
            if ($parsedHost) {
                return $parsedHost;
            }
        }
        
        return 'softmedia-ao.com';
    }
}

if (!function_exists('subdomain_url')) {
    /**
     * Generate an absolute URL for a given subdomain.
     *
     * @param string $subdomain 'loja', 'treinamento', or empty for main site
     * @param string $path
     * @param array $parameters
     * @return string
     */
    function subdomain_url(string $subdomain = '', string $path = '/', array $parameters = []): string
    {
        $scheme = request()->getScheme() ?: (app()->environment('production') ? 'https' : 'http');
        $baseDomain = app_base_domain();
        
        $port = request()->getPort();
        $portStr = ($port && !in_array($port, [80, 443])) ? ':' . $port : '';
        
        $host = !empty($subdomain) ? "{$subdomain}.{$baseDomain}" : $baseDomain;
        $cleanPath = '/' . ltrim($path, '/');
        
        $url = "{$scheme}://{$host}{$portStr}{$cleanPath}";
        
        if (!empty($parameters)) {
            $queryString = http_build_query($parameters);
            $url .= (str_contains($url, '?') ? '&' : '?') . $queryString;
        }
        
        return $url;
    }
}

if (!function_exists('current_subdomain')) {
    /**
     * Detect the current request's subdomain.
     *
     * @return string 'loja', 'treinamento', 'admin', or 'main'
     */
    function current_subdomain(): string
    {
        $host = request()->getHost();
        $baseDomain = app_base_domain();
        
        if ($host === "loja.{$baseDomain}") {
            return 'loja';
        }
        
        if ($host === "treinamento.{$baseDomain}") {
            return 'treinamento';
        }

        if ($host === "sysadmin.{$baseDomain}") {
            return 'sysadmin';
        }
        
        if (str_starts_with($host, 'loja.')) {
            return 'loja';
        }
        
        if (str_starts_with($host, 'treinamento.')) {
            return 'treinamento';
        }

        if (str_starts_with($host, 'sysadmin.')) {
            return 'sysadmin';
        }
        
        return 'main';
    }
}

if (!function_exists('is_subdomain')) {
    /**
     * Check if current request is on a specific subdomain.
     */
    function is_subdomain(string $subdomain): bool
    {
        return current_subdomain() === $subdomain;
    }
}
