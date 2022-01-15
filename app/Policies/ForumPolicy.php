<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;

class ForumPolicy
{
    public function createCategories($user): bool
    {
        return Auth::user()->admin === 1;
    }

    public function manageCategories($user): bool
    {
        return Auth::user()->admin === 1;
    }

    public function moveCategories($user): bool
    {
        return Auth::user()->admin === 1;
    }

    public function renameCategories($user): bool
    {
        return Auth::user()->admin === 1;
    }

    public function markThreadsAsRead($user): bool
    {
        return true;
    }

    public function viewTrashedThreads($user): bool
    {
        return Auth::user()->admin === 1;
    }

    public function viewTrashedPosts($user): bool
    {
        return Auth::user()->admin === 1;
    }
}
