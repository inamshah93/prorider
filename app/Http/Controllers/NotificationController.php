<?php
// app/Http/Controllers/NotificationController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Factory;

class NotificationController extends Controller
{
    public function sendPushNotification(Request $request)
    {
        // dd($request->all());
        // Initialize Firebase with the service account JSON file
        $firebase = (new Factory)
            ->withServiceAccount(storage_path() . "/app/firebase/client_secret.json");

        // Create a messaging instance
        $messaging = $firebase->createMessaging();

        // Prepare the message
        $message = CloudMessage::withTarget('token', $request->fcm_token[0]) // Sending to the first token initially for structure
            ->withNotification([
                'title' => $request->title,
                'body' => $request->message
            ])
            ->withData([
                'sound' => 'notification_sound.wav', // custom sound file for both platforms
            ])
            ->withAndroidConfig([
                'notification' => [
                    'sound' => 'notification_sound', // sound file without extension for Android
                    'channel_id' => 'ss_notifications' // Ensure your Android app has a notification channel with this ID
                ]
            ])
            ->withApnsConfig([
                'payload' => [
                    'aps' => [
                        'sound' => 'notification_sound.wav' // custom sound for iOS
                    ]
                ]
            ]);

        try {
            // Check if we have multiple tokens
            if (is_array($request->fcm_token) && count($request->fcm_token) > 1) {
                // Send to multiple tokens
                $response = $messaging->sendMulticast(CloudMessage::new()->withNotification([
                    'title' => $request->title,
                    'body' => $request->message
                ])->withData([
                            'sound' => 'notification_sound.wav',
                        ]), $request->fcm_token);
            } else {
                // Send to a single token
                $messaging->send($message);
            }

            // If sending is successful, return success response
            return response()->json([
                'status' => true,
                'message' => 'Push notification sent successfully'
            ]);
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            // Handle specific messaging exceptions
            dd($e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Failed to send push notification'
            ], 500); // You can adjust the HTTP status code as needed
        }
    }
}

