<?php

namespace App\Http\Controllers\outbox;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Outgoing;

use Illuminate\Support\Facades\Auth;

class OutboxController extends Controller
{
    // Display a listing of outbox messages
    public function index()
    {
        $outboxMessages = Outbox::all();
        return response()->json($outboxMessages);
    }

    // Store a newly created outbox message
    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $outbox = Outbox::create($validated);

        return response()->json($outbox, 201);
    }

    // Display the specified outbox message
    public function show($id)
    {
        $outbox = Outbox::findOrFail($id);
        return response()->json($outbox);
    }

    // Update the specified outbox message
    public function update(Request $request, $id)
    {
        $outbox = Outbox::findOrFail($id);

        $validated = $request->validate([
            'recipient' => 'sometimes|required|string|max:255',
            'message' => 'sometimes|required|string',
        ]);

        $outbox->update($validated);

        return response()->json($outbox);
    }

    // Remove the specified outbox message
    public function destroy($id)
    {
        $outbox = Outbox::findOrFail($id);
        $outbox->delete();

        return response()->json(['message' => 'Outbox message deleted']);
    }
}