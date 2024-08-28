<?php

namespace Tests\Unit;

namespace Tests\Unit;

use App\Models\Message;
use App\Models\User;
use App\Notifications\PushNotification;
use Tests\TestCase;

class PushNotificationTest extends TestCase
{
    public function test_push_notification_sends_correctly()
    {
        $user = User::factory()->make();
        $message = Message::factory()->make();

        $PushNotification = new PushNotification($user, $message);
        $this->assertNotEmpty($PushNotification);
    }
}