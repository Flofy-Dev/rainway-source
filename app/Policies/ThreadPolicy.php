<?php

namespace App\Policies;

use TeamTeaTime\Forum\Models\Thread;
use Illuminate\Support\Facades\Auth;

class ThreadPolicy
{
    public function view($user, Thread $thread): bool
    {
        return true;
    }

    public function deletePosts($user, Thread $thread): bool
    {
        return true;
    }

    public function restorePosts($user, Thread $thread): bool
    {
        return true;
    }

    public function rename($user, Thread $thread): bool
    {
        if( $user->getKey() == $thread->author_id || Auth::user()->admin == 1)
            return true;
        else
            return false;
    }

    public function reply($user, Thread $thread): bool
    {
        return ! $thread->locked;
    }

    public function delete($user, Thread $thread): bool
    {
        if( $user->getKey() == $thread->author_id || Auth::user()->admin == 1)
            return true;
        else
            return false;
    }

    public function restore($user, Thread $thread): bool
    {
        if( $user->getKey() == $thread->author_id || Auth::user()->admin == 1)
            return true;
        else
            return false;
    }
}
