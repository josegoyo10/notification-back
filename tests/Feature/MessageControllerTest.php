<?php

// tests/Feature/MessageControllerTest.php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Message;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_submit_message()
    {
        $category = Category::factory()->create();
        $user = User::factory()->create([
            'subscribed_categories' => json_encode([$category->id]),
            'notification_channels' => json_encode(['email'])
        ]);

        $response = $this->postJson('/submit-message', [
            'category_id' => $category->id,
            'message' => 'Test message'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('messages', ['body' => 'Test message']);
        $this->assertDatabaseHas('notifications', [
            'user_id' => $user->id,
            'channel' => 'email'
        ]);
    }

    public function test_get_list_notification()
    {
        $notification = Notification::factory()->create();

        $response = $this->getJson('/list-notification');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'user_id', 'message_id', 'channel', 'sent_at', 'created_at', 'updated_at']
            ]);
    }
}