<?php

namespace App\Policies;

use TeamTeaTime\Forum\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostPolicy
{
    public function edit($user, Post $post): bool
    {
        if( $user->getKey() === $post->author_id || Auth::user()->admin == 1)
            return true;
        else
            return false;
    }

    public function delete($user, Post $post): bool
    {
        if( $user->getKey() === $post->author_id || Auth::user()->admin == 1)
            return true;
        else
            return false;
    }

    public function restore($user, Post $post): bool
    {
        if( $user->getKey() === $post->author_id || Auth::user()->admin == 1)
            return true;
        else
            return false;
    }
}
