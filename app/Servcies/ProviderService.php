<?php

namespace App\Services;

use App\Http\Requests\StoreProviderRequest;
use App\Models\Provider;

class ProviderService
{
    public function getProviders($search = null, $category = null)
    {
        $query = Provider::with('category');

        if ($search) {
            $query->search($search);
        }

        if ($category) {
            $query->filterByCategory($category);
        }

        return $query->paginate(10);
    }

    public function store(StoreProviderRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        return Provider::create($data);
    }
}

