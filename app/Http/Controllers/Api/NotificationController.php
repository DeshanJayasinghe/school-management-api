<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class NotificationController extends Controller
{
    protected $messaging;

    public function __construct()
    {
        $serviceAccountPath = storage_path('app/firebase/firebase-service-account.json');
        
        if (!file_exists($serviceAccountPath)) {
            throw new \RuntimeException(
                "Firebase service account file not found at: {$serviceAccountPath}"
            );
        }

        $this->messaging = (new Factory)
            ->withServiceAccount($serviceAccountPath)
            ->createMessaging();
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string'
        ]);

        try {
            // Correct way to create message in newer SDK versions
            $message = CloudMessage::withTarget('token', $request->fcm_token)
                ->withNotification(Notification::create($request->title, $request->body))
                ->withData(['type' => 'grade_update']);

            $this->messaging->send($message);

            return response()->json([
                'success' => true,
                'message' => 'Notification sent successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send notification',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}