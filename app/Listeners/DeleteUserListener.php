<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Deleted;
use Illuminate\Support\Facades\Storage;

class DeleteUserListener
{
    /**
     * Handle the event.
     *
     * @param  Deleted  $event
     * @return void
     */
    public function handle(Deleted $event)
    {
        $user = $event->user;

        // Delete user files from storage
        $userFolderPath = 'user_files/' . $user->id;
        Storage::deleteDirectory($userFolderPath);

        // Delete associated files from database
        $user->files()->delete();
    }
}