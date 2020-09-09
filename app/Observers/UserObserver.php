<?php

namespace App\Observers;

class UserObserver
{
    public function creating($user)
    {
        // I want to create the $book book, but first...
        $user->create_at = time();
    }

    public function saving($user)
    {
        // I want to save the $book book, but first...
        $user->update_at = time();
    }

    public function saved($user)
    {
        // I just saved the $book book, so....
    }
}
