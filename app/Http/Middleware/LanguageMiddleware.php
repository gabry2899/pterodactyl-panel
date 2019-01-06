<?php

namespace Pterodactyl\Http\Middleware;

use Closure;
use View;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Pterodactyl\Traits\Helpers\AvailableLanguages;

class LanguageMiddleware
{
    use AvailableLanguages;

    /**
     * @var \Illuminate\Foundation\Application
     */
    private $app;

    /**
     * LanguageMiddleware constructor.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request and set the user's preferred language.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->user()->language ?? config('app.locale', 'en');
        if ($request->has('l')) {
            $locale = $request->get('l', $locale);
        }
        if ($request->user() && $request->user()->language != $locale) {
            $user = $request->user();
            $user->language = $locale;
            $user->save();
        }


        $this->app->setLocale($locale);

        View::composer('*', function($view) use ($locale)
        {
            $view->with('_active_locale', $locale);
            $view->with('_locales', $this->getAvailableLanguages());
        });

        return $next($request);
    }
}
