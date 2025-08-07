<?php

use App\Models\Activity;

function logActivity($type, $title, $description)
{
    Activity::create([
        'type' => $type,
        'title' => $title,
        'description' => $description,
    ]);
}
