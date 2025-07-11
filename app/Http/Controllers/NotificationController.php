<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{


    public function markAsRead($notificationId)
    {
        // Récupérer la notification de l'utilisateur authentifié
        $notification = Auth::user()->notifications()->find($notificationId);

        // Vérifier si la notification existe
        if ($notification) {
            // Marquer la notification comme lue
            $notification->markAsRead();

            // Retourner une réponse JSON pour indiquer que tout s'est bien passé
            return response()->json(['success' => true]);
        }

        // Retourner une réponse d'erreur si la notification n'a pas été trouvée
        return response()->json(['success' => false, 'message' => 'Notification non trouvée.']);
    }

}

