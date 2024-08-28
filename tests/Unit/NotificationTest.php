<?php
// tests/Unit/NotificationTest.php

namespace Tests\Unit;

use App\Models\Notification;
use App\Models\User;
use App\Models\Message;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_notification_belongs_to_user()
    {
        $notification = Notification::factory()->create();
        $this->assertInstanceOf(User::class, $notification->user);
    }

    public function test_notification_belongs_to_message()
    {
        $notification = Notification::factory()->create();
        $this->assertInstanceOf(Message::class, $notification->message);
    }
}