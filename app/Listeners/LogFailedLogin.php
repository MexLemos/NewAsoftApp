<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Spatie\Activitylog\Facades\LogActivity;

class LogFailedLogin
{
    public function handle(Failed $event): void
    {
        activity("seguranca")
            ->withProperties([
                "email"      => $event->credentials["email"] ?? "desconhecido",
                "ip"         => request()->ip(),
                "user_agent" => request()->userAgent(),
            ])
            ->log("Tentativa de login falhada para: " . ($event->credentials["email"] ?? "N/D"));
    }
}
