<?php

// tests/Unit/EmailNotificationTest.php

namespace Tests\Unit;

use App\Models\Message;
use App\Models\User;
use App\Notifications\EmailNotification;
use Tests\TestCase;

class EmailNotificationTest extends TestCase
{
    public function test_email_notification_sends_correctly()
    {
        $user = User::factory()->make();
        $message = Message::factory()->make();

        $emailNotification = new EmailNotification($user, $message);
        $this->assertNotEmpty($emailNotification);
    }
}