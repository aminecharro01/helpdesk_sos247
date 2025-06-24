<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function markAsRead($id)
{
    $notification = DatabaseNotification::findOrFail($id);

    if ($notification->notifiable_id == Auth::id()) {
        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return back();
    } else {
        abort(403, 'Non autorisé.');
    }
}
}
