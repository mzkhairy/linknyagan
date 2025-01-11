<?php

namespace App\Policies;

use App\Models\Link;
use App\Models\User;

class LinkPolicy
{
    public function update(User $user, Link $link): bool
    {
        return $user->id === $link->user_id;
    }

    public function delete(User $user, Link $link): bool
    {
        return $user->id === $link->user_id;
    }
    public function view(User $user, Link $link)
    {
    return $user->id === $link->user_id;
    }
}