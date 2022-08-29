<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;

class ForumPolicy
{
    public function createCategories($user): bool
    {
        if(isset(Auth::user()->admin))
            return Auth::user()->admin === 1;
        else
            return false;
    }

    public function manageCategories($user): bool
    {
        if(isset(Auth::user()->admin))
            return Auth::user()->admin === 1;
        else
            return false;
    }

    public function moveCategories($user): bool
    {
        if(isset(Auth::user()->admin))
            return Auth::user()->admin === 1;
        else
            return false;
    }

    public function renameCategories($user): bool
    {
        if(isset(Auth::user()->admin))
            return Auth::user()->admin === 1;
        else
            return false;
    }

    public function markThreadsAsRead($user): bool
    {
        return true;
    }

    public function viewTrashedThreads($user): bool
    {
        if(isset(Auth::user()->admin))
            return Auth::user()->admin === 1;
        else
            return false;
    }

    public function viewTrashedPosts($user): bool
    {
        if(isset(Auth::user()->admin))
            return Auth::user()->admin === 1;
        else
            return false;
    }
}
