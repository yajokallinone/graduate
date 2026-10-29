<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if lang parameter is in query string
        if ($request->has('lang')) {
            $lang = $request->input('lang');
            if (in_array($lang, ['th', 'en'])) {
                session(['locale' => $lang]);
            }
        }

        // Use session value, or fallback to config, or default to 'th'
        $locale = session('locale') ?? config('app.locale', 'th');
        if (!in_array($locale, ['th', 'en'])) {
            $locale = 'th';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
