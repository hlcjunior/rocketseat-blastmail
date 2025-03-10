<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory
    {
        return view('email-list.index', [
            'emailLists' => EmailList::query()->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory
    {
        return view('email-list.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'max:255'],
            'listFile' => ['required', 'file', 'mimes:csv'],
        ]);

        $listFile = $request->file('listFile');
        $fileHandle = fopen($listFile->getRealPath(), 'r');
        $items = [];

        while (($line = fgetcsv($fileHandle)) !== false) {
            if(mb_strtolower($line[0])  == 'name' && mb_strtolower($line[1]) == 'email') {
                continue;
            }

            $items[] = [
                'name' => $line[0],
                'email' => $line[1],
            ];
        }

        fclose($fileHandle);

        $emailList = EmailList::query()->create([
            'title' => $data['title'],
        ]);
        $emailList->subscribers()->createMany($items);

        return to_route("email-list.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailList $emailList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailList $emailList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmailList $emailList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailList $emailList)
    {
        //
    }
}
