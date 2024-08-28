<?php

// tests/Unit/SMSNotificationTest.php

namespace Tests\Unit;

use App\Models\Message;
use App\Models\User;
use App\Notifications\SMSNotification;
use Tests\TestCase;

class SMSNotificationTest extends TestCase
{
     /** @test */
    public function it_sends_sms_notification()
    {
        $user = User::factory()->create(['phone_number' => '1234567890']);
        $message = Message::factory()->create(['body' => 'Test SMS Message']);

        $smsNotification = new SMSNotification($user, $message);
        $this->assertTrue($smsNotification);

        // Check that the log or output shows the SMS was sent
    }
}