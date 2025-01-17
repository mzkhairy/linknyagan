<?php

namespace App\Policies;

use App\Models\User;
use App\Models\pageSettings;

class pageSettingsPolicy
{

    public function updatePgDescription(User $user, pageSettings $pageSettings)
    {
        return $user->id === $pageSettings->user_id;
    }
}
