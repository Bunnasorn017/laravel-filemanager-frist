<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\File;
use App\Models\User;

class FilePolicy
{
    public function view(User $user, File $file)
    {
        return $user->id === $file->user_id;
    }

    public function update(User $user, File $file)
    {
        return $user->id === $file->user_id;
    }

    public function delete(User $user, File $file)
    {
        return $user->id === $file->user_id;
    }
}