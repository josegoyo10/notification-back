<?php

namespace App\Services;

use App\Models\User;
use App\Models\Notification;
use App\Notifications\EmailNotification;
use App\Notifications\PushNotification;
use App\Notifications\SMSNotification;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Log;

use function PHPSTORM_META\type;

class NotificationServices
{

    public function sendNotifications($message)
    {
        // 

        try {

            $users = User::whereJsonContains('subscribed_categories', $message->category_id)->get();

            foreach ($users as $user) {

                $getChannel = array_map(null, explode(',', $user->notification_channels));

                foreach ($getChannel as $channel) {
                    $_channel = preg_replace('/[^A-Za-z0-9. -]/', '', $channel);
                    $this->sendNotification($user, $message, $_channel);
                }
            }
        } catch (Exception $exception) {
            Log::error('An error occurred while sending notifications: ' . $exception->getMessage());
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    protected function sendNotification($user, $message, $channel)
    {
     try {
        $opc_channel = str_replace(' ', '', $channel);

        switch ($opc_channel) {
            case 'sms':
                $notification = new SMSNotification($user, $message);
                break;
            case 'email':
                $notification = new EmailNotification($user, $message);
                break;
            case 'push':
                $notification = new PushNotification($user, $message);
                break;
            default:
                return;
        }

        $notification->send();

        Notification::create([
            'user_id' => $user->id,
            'message_id' => $message->id,
            'channel' => $channel,
            'sent_at' => now(),
        ]);
     } catch (Exception $exception) {
            Log::error('An error occurred while creating notifications: ' . $exception->getMessage());
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }
}