<?php

namespace App\Http\Controllers;

use App\Models\EmailList;

class SubscriberController extends Controller
{
    public function index(EmailList $emailList)
    {
        $search = request()->search;

        return view('subscriber.index', [
            'emailList' => $emailList,
            'subscribers' => $emailList
                ->subscribers()
                ->when($search, fn($query) => $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('id', '=', $search)
                )
                ->paginate(5)
                ->appends(compact('search')),
            'search' => $search
        ]);
    }
}
