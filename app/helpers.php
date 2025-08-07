<?php

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

function logActivity($type, $title, $description)
{
    Activity::create([
        'type' => $type,
        'title' => $title,
        'description' => $description,
        'user_id' => Auth::id(),
    ]);
}
