<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Category;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_category_has_messages()
    {
        $category = Category::factory()->create();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $category->messages);
    }
}