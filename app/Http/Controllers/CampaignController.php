<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class CampaignController extends Controller
{
    public function index(): View|Application|Factory
    {

        $search = request('search');
        $withTrashed = request('withTrashed', false);


        return view('campaigns.index', [
            'campaigns' => Campaign::query()
                ->when($withTrashed, fn(Builder $query) => $query->withTrashed())
                ->when(
                    $search,
                    fn(Builder $query) => $query
                        ->where('name', 'like', "%$search%")
                        ->orWhere('id', '=', $search)
                )
                ->paginate(2)
                ->appends(compact('search')),
            'search' => $search,
            'withTrashed' => $withTrashed,
        ]);
    }
}
