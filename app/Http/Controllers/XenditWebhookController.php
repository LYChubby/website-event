<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class XenditWebhookController extends Controller
{
    public function handle(Request $req)
    {
        $signature = $req->header('X-Callback-Token');
        abort_if($signature !== config('services.xendit.webhook_token'), 403);

        $event = $req->input('event');
        $data  = $req->input('data');

        if ($event === 'invoice.paid') {
            // Update status transaksi di DB menjadi “paid”
        }

        return response()->json(['status' => 'OK']);
    }
}
