<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class CampaignController extends Controller
{

    //create a new campaign calling the view
    public function create(?string $tab = null): View|Application|Factory
    {
        return view('campaigns.create',[
            'tab' => $tab,
            'form' => match ($tab) {
                'template' => '_template',
                'schedule' => '_schedule',
                default => '_config',
            }
        ]);
    }

    public function store(?string $tab = null): RedirectResponse
    {
        if(blank($tab)) {
            $data = request()->validate([
                'name' => ['required', 'max:255'],
                'subject' => ['required', 'max:40'],
                'email_list_id' => ['nullable'],
                'template_id' => ['nullable'],
            ]);

            session()->put('campaigns::create', $data);

            return to_route('campaigns.create', ['tab'=>'template']);

        }

        return to_route('campaigns.create');

    }

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
                ->appends(compact('search', 'withTrashed')),
            'search' => $search,
            'withTrashed' => $withTrashed,
        ]);
    }

    public function destroy(Campaign $campaign): RedirectResponse
    {
        $campaign->delete();

        return back()->with('message', __('Campaign deleted successfully.'));
    }

    public function restore(Campaign $campaign): RedirectResponse
    {
        $campaign->restore();

        return back()->with('message', __('Campaign restored successfully.'));
    }
}
