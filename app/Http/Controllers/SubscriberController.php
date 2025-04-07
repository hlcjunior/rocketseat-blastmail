<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use App\Models\Subscriber;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SubscriberController extends Controller
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(EmailList $emailList): Factory|Application|View
    {
        $search = request()->search;
        $showTrash = request()->get('showTrash', false);

        return view('subscriber.index', [
            'emailList' => $emailList,
            'subscribers' => $emailList
                ->subscribers()
                ->when($showTrash, fn(Builder $query) => $query->withTrashed())
                ->when($search, fn(Builder $query) => $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('id', '=', $search);
                }))
                ->paginate(5)
                ->appends(compact('search', 'showTrash')),
            'search' => $search,
            'showTrash' => $showTrash,
        ]);
    }

    public function destroy(mixed $list, Subscriber $subscriber): RedirectResponse
    {
        $subscriber->delete();

        return back()->with('message', __('Subscriber deleted from the list.'));
    }

}
