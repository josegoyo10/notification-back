<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Message;
use App\Services\NotificationService;
use App\Models\Notification;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function submitMessage(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'message' => 'required|string|max:255',
        ]);

        $message = Message::create([
            'category_id' => $validated['category_id'],
            'body' => $validated['message'],
        ]);

        $this->notificationService->sendNotifications($message);

        return response()->json(['message' => 'Message submitted successfully.']);
    }

    public function getLogHistory()
    {
        $logs = Notification::with('user', 'message')->latest()->get();
        return response()->json($logs);
    }
}