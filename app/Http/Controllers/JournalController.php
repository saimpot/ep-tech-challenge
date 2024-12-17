<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJournalRequest;
use App\Services\Journals\JournalService;
use Illuminate\Http\JsonResponse;

class JournalController extends Controller
{
    public function __construct(
        protected JournalService $journalService
    ) { }

    public function index(int $clientId): JsonResponse
    {
        $journals = $this->journalService->getJournalsForClient($clientId);

        return response()->json(['journals' => $journals]);
    }

    public function store(StoreJournalRequest $request, int $clientId): JsonResponse
    {
        $journal = $this->journalService->createJournalForClient($clientId, $request->validated());

        return response()->json($journal, 201);
    }

    public function destroy(int $clientId, int $journalId): JsonResponse
    {
        $this->journalService->deleteJournalForClient($clientId, $journalId);

        return response()->json(['message' => 'Journal deleted successfully.']);
    }
}
