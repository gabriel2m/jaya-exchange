<?php

namespace App\Http\Controllers;

use App\Contracts\Services\TransactionService;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\User;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    /**
     * Paginated list of $user transactions
     */
    public function index(User $user)
    {
        return TransactionResource::collection(
            $user->transactions()->simplePaginate()
        );
    }

    /**
     * Store a newly created resource in storage
     */
    public function store(StoreTransactionRequest $request, TransactionService $transactionService)
    {
        try {
            return response(
                TransactionResource::make(
                    $transactionService->create($request->all())
                )->resolve(),
                Response::HTTP_CREATED
            );
        } catch (HttpClientException $th) {
            Log::error($th);

            return response([
                'message' => 'Something wrong with our external services, contact a admin',
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
}
