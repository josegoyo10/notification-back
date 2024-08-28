<?php

namespace Tests\Unit;

use App\Models\Message;
use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_message_belongs_to_category()
    {
        $message = Message::factory()->create();
        $this->assertInstanceOf(Category::class, $message->category);
    }

    public function test_message_has_notifications()
    {
        $message = Message::factory()->create();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $message->notifications);
    }
}