<?php

namespace App\Http\Controllers;

use App\Client;
use App\Constants\BookingFilterType;
use App\Http\Requests\StoreClientRequest;
use App\Services\Clients\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function __construct(
        protected ClientService $clientService
    ) { }

    public function index()
    {
        $clients = $this->clientService->getClientsForUser();

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show(Request $request, Client $client)
    {
        $clientData = $this->clientService
            ->getClientWithBookings(
                $client,
                $request->query('filter', BookingFilterType::ALL)
            );

        if ($request->ajax()) {
            return response()->json(['client' => ['bookings' => $clientData['bookings']]]);
        }

        return view('clients.show', ['client' => $clientData]);
    }

    public function store(StoreClientRequest $request): JsonResponse
    {
        $this->clientService->createClient($request->validated());

        return response()->json([
            'message' => 'Client created successfully.',
            'url' => route('clients.index'),
        ], 201);
    }

    public function destroy(int $clientId): JsonResponse
    {
        $this->clientService->deleteClient($clientId);

        return response()->json(['message' => 'Client deleted successfully.']);
    }
}
