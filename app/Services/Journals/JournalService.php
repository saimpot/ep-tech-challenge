<?php

namespace App\Services\Journals;

use App\Client;
use App\Journal;
use Illuminate\Support\Facades\DB;

class JournalService
{
    public function getJournalsForClient(int $clientId)
    {
        return Client::query()
            ->findOrFail($clientId)
            ?->journals()
            ->orderBy('date', 'desc')
            ->get();
    }

    public function createJournalForClient(int $clientId, array $data)
    {
        $client = Client::query()
            ->findOrFail($clientId);

        return $client->journals()->create([
            'date' => $data['date'],
            'text' => $data['text'],
        ]);
    }

    public function deleteJournalForClient(int $clientId, int $journalId): void
    {
        $journal = Journal::query()
            ->where('id', $journalId)
            ->where('client_id', $clientId)
            ->firstOrFail();

        DB::transaction(function () use ($journal) {
            $journal->delete();
        });
    }
}
