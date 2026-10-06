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
