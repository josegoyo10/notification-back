<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Message;
use App\Services\NotificationServices;
use App\Models\Notification;
use Illuminate\Http\Request;
use Exception;

class MessageController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationServices $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function submitMessage(Request $request)
    {
        try {
            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'message' => 'required|string|max:255',
            ]);

            $message = Message::create([
                'category_id' => $validated['category_id'],
                'body' => $validated['message'],
            ]);

            //dd($message);
            $this->notificationService->sendNotifications($message);

            return response()->json(['status' => "Ok", 'message' => 'Notification sent successfully.']);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function getLogHistory()
    {
        $logs = Notification::with('user', 'message')->latest()->get();
        return response()->json($logs);
    }
}