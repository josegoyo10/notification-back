<?php

namespace App\Services;
use App\Models\User;
use App\Models\Notification;
use App\Notifications\EmailNotification;
use App\Notifications\PushNotification;
use App\Notifications\SMSNotification;

class NotificationService {

    public function sendNotifications($message) {
        // 
        $users = User::whereJsonContains('subscribed_categories', $message->category_id)->get();

        foreach ($users as $user) {
            foreach ($user->notification_channels as $channel) {
                $this->sendNotification($user, $message, $channel);
            }
        }
    }

    protected function sendNotification($user, $message, $channel)
    {
        switch ($channel) {
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
    }
    
}


?>