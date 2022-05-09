<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\SendMailEvent;

class SendMail
{
    public function __construct(protected User $user)
    {
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate()
    {
        if ($user = $this->user->where('id', auth()->id())->first()) {
            $message = 'well receive your submitted';
            event(new SendMailEvent($user?->email, $message));
        }
    }
}
