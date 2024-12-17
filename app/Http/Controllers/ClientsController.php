<?php

namespace App\Http\Controllers;

use App\Client;
use App\Constants\BookingFilterType;
use App\Http\Requests\StoreClientRequest;
use App\Services\Bookings\Filters\BookingFilterContext;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::query()
            ->where('user_id', Auth::id())
            ->with('bookings')
            ->withCount('bookings')
            ->get();

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show(Request $request, Client $client)
    {
        $filterType = $request->query('filter', BookingFilterType::ALL);

        if (!BookingFilterType::isValid($filterType)) {
            $filterType = BookingFilterType::ALL;
        }

        $client->load(['bookings' => function (HasMany $query) use ($filterType) {
            BookingFilterContext::resolve($filterType)
                ->filter($query)
                ->orderBy('start', 'desc');
        }]);

        if ($request->ajax()) {
            return response()->json([
                'client' => [
                    'bookings' => $client->bookings
                ]
            ]);
        }

        return view('clients.show', ['client' => $client]);
    }

    public function store(StoreClientRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $client = new Client;
        $client->name = $validated['name'];
        $client->email = $validated['email'] ?? null;
        $client->phone = $validated['phone'] ?? null;
        $client->address = $request->get('address');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->user_id = auth()->id();
        $client->save();

        return response()->json([
            'message' => 'Client created successfully.',
            'url' => route('clients.index'),
        ], 201);
    }

    public function destroy(Client $client): JsonResponse
    {
        if ($client->delete()) {
            return response()->json(['message' => 'Client deleted successfully.']);
        }

        return response()->json(['message' => 'Failed to delete client.'], 500);
    }
}
