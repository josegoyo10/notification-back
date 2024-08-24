<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone_number', 'subscribed_categories', 'notification_channels'];

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}