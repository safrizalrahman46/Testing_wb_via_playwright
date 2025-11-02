<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\Announcement;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
   {
    View::composer('*', function ($view) {
        $latestAnnouncements = Announcement::latest()->take(5)->get();
        $unreadCount = Announcement::where('created_at', '>=', now()->subDay())->count(); // atau logika user-based

        $view->with(compact('latestAnnouncements', 'unreadCount'));
    });
}
}
