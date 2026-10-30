<?php

namespace App\Providers;

use App\Support\School;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Carbon::setLocale(config('app.locale', 'id'));
        Paginator::defaultView('pagination.ekskul');   // tombol halaman sendiri (tanpa Tailwind)
        View::share('school', new School());            // $school->name(), ->principal(), dst. di semua view
    }
}
