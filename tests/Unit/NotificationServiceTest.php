<?php

// tests/Unit/NotificationServiceTest.php

namespace Tests\Unit;

use App\Models\Message;
use App\Models\User;
use App\Services\NotificationServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $notificationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->notificationService = new NotificationServices();
    }

    public function test_send_notifications()
    {
        $user = User::factory()->create([
            'subscribed_categories' => json_encode([1]),
            'notification_channels' => json_encode(['email'])
        ]);

        $message = Message::factory()->create(['category_id' => 1]);

        $this->notificationService->sendNotifications($message);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $user->id,
            'message_id' => $message->id,
            'channel' => 'email'
        ]);
    }

    public function test_notification_not_sent_to_unsubscribed_user()
    {
        $user = User::factory()->create([
            'subscribed_categories' => json_encode([2]),
            'notification_channels' => json_encode(['sms'])
        ]);

        $message = Message::factory()->create(['category_id' => 1]);

        $this->notificationService->sendNotifications($message);

        $this->assertDatabaseMissing('notifications', [
            'user_id' => $user->id,
            'message_id' => $message->id
        ]);
    }
}