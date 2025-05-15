<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProviderRequest;
use App\Http\Resources\ProviderResource;
use App\Services\ProviderService;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    protected ProviderService $providerService;

    public function __construct(ProviderService $providerService)
    {
        $this->providerService = $providerService;
    }

    /**
     * GET /api/providers
     */
    public function index(Request $request)
    {
        $providers = $this->providerService->getProviders(
            $request->query('search'),
            $request->query('category')
        );

        return ProviderResource::collection($providers);
    }



    /**
     * POST /api/providers
     */
    public function store(StoreProviderRequest $request)
    {
        $provider = $this->providerService->store($request);
        return new ProviderResource($provider);
    }
}
