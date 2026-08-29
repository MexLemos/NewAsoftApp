<?php
namespace App\Listeners;
use Illuminate\Auth\Events\Logout;

class LogLogout
{
    public function handle(Logout $event): void
    {
        if ($event->user) {
            activity("autenticacao")
                ->causedBy($event->user)
                ->withProperties(["ip" => request()->ip()])
                ->log("Logout");
        }
    }
}
