<?php

namespace App\Providers;

use App\Model\Article;
use App\Model\Book;
use App\Model\Process;
use App\Model\User;
use App\Observers\ArticleObserver;
use App\Observers\BookObserver;
use App\Observers\ProcessObserver;
use App\Observers\UserObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        'Illuminate\Database\Events\QueryExecuted' => [
            'App\Listeners\QueryListener',
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogSuccessfulLogin',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        User::observe(new UserObserver());
        Article::observe(new ArticleObserver());
        Process::observe(new ProcessObserver());
        Book::observe(new BookObserver());
    }
}
