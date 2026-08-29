<?php
namespace App\Listeners;
use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
{
    public function handle(Login $event): void
    {
        activity("autenticacao")
            ->causedBy($event->user)
            ->withProperties(["ip" => request()->ip(), "user_agent" => request()->userAgent()])
            ->log("Login bem-sucedido");
    }
}
