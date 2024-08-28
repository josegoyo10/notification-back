<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
use RefreshDatabase;

public function test_user_has_notifications()
{
$user = User::factory()->create();
$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->notifications);
}

public function test_user_has_subscribed_categories()
{
$user = User::factory()->create(['subscribed_categories' => json_encode([1, 2])]);
$this->assertIsArray(json_decode($user->subscribed_categories));
}

public function test_user_has_notification_channels()
{
$user = User::factory()->create(['notification_channels' => json_encode(['email', 'sms'])]);
$this->assertIsArray(json_decode($user->notification_channels));
}
}