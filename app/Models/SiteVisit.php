<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class SiteVisit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getDeviceAttribute(): string
    {
        $ua = $this->user_agent ?? '';
        if (empty($ua)) return 'Desconhecido';
        if (preg_match('/(android|iphone|ipad|ipod|mobile)/i', $ua)) return 'Telemóvel';
        if (preg_match('/(tablet)/i', $ua)) return 'Tablet';
        return 'Computador';
    }

    public function getBrowserAttribute(): string
    {
        $ua = $this->user_agent ?? '';
        if (empty($ua)) return 'Desconhecido';
        if (str_contains($ua, 'Edg')) return 'Edge';
        if (str_contains($ua, 'Chrome')) return 'Chrome';
        if (str_contains($ua, 'Safari')) return 'Safari';
        if (str_contains($ua, 'Firefox')) return 'Firefox';
        if (str_contains($ua, 'Opera') || str_contains($ua, 'OPR')) return 'Opera';
        return 'Navegador Web';
    }

    /**
     * Ensure the table exists in environments where migrations weren't run manually.
     */
    public static function ensureTableExists(): void
    {
        try {
            if (!Schema::hasTable('site_visits')) {
                Schema::create('site_visits', function (Blueprint $table) {
                    $table->id();
                    $table->string('ip', 45)->nullable()->index();
                    $table->string('url', 500)->nullable();
                    $table->string('path', 255)->nullable()->index();
                    $table->string('referer', 500)->nullable();
                    $table->string('user_agent', 500)->nullable();
                    $table->timestamps();
                });
            }
        } catch (\Throwable $e) {
            // Silently ignore if table check fails or already exists
        }
    }
}
