<?php

namespace App\Observers;

use Illuminate\Support\Facades\Request;

class ProcessObserver
{
    public function creating($article)
    {
        // I want to create the $book book, but first...
        $user_id = Request::session()->get('user_id');
        $article->create_at = time();
        $article->user_id = $user_id;
    }

    public function saving($article)
    {
        // I want to save the $book book, but first...
        $article->update_at = time();
    }

    public function saved($user)
    {
        // I just saved the $book book, so....
    }
}
