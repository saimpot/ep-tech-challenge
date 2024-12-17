<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\StoreJournalRequest;
use App\Journal;
use Illuminate\Http\JsonResponse;

class JournalController extends Controller
{
    public function index(Client $client): JsonResponse
    {
        return response()->json([
            'journals' => $client->journals()->orderBy('date', 'desc')->get(),
        ]);
    }

    public function store(StoreJournalRequest $request, Client $client): JsonResponse
    {
        $journal = $client->journals()->create([
            'date' => $request->input('date'),
            'text' => $request->input('text'),
        ]);

        return response()->json($journal, 201);
    }

    public function destroy(Client $client, Journal $journal): JsonResponse
    {
        if ($journal->client_id !== $client->id) {
            abort(403, 'Unauthorized action.');
        }

        $journal->delete();

        return response()->json(['message' => 'Journal deleted successfully.']);
    }
}
