<?php

namespace App\Services\Clients;

use App\Client;
use App\Constants\BookingFilterType;
use App\Services\Bookings\Filters\BookingFilterContext;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientService
{
    public function getClientsForUser(): Collection|array
    {
        return Client::query()
            ->where('user_id', Auth::id())
            ->with(['bookings', 'journals'])
            ->withCount(['bookings', 'journals'])
            ->get();
    }

    public function getClientWithBookings(Client $client, string $filterType): Client
    {
        $filterType = BookingFilterType::isValid($filterType) ? $filterType : BookingFilterType::ALL;

        $client->load(['bookings' => function ($query) use ($filterType) {
            BookingFilterContext::resolve($filterType)
                ->filter($query)
                ->orderBy('start', 'desc');
        }]);

        return $client;
    }

    public function createClient(array $data)
    {
        return DB::transaction(function () use ($data) {
            $client = new Client();
            $client->fill($data);
            $client->user_id = Auth::id();
            $client->save();

            return $client;
        });
    }

    public function deleteClient(int $clientId): void
    {
        $client = Client::query()->findOrFail($clientId);

        DB::transaction(function () use ($client) {
            $client->delete();
        });
    }
}
