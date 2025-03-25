<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

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
        $request->validate([
            'title' => ['required', 'max:255'],
            'listFile' => ['required', 'file', 'mimes:csv'],
        ]);

        $emails = $this->getEmailsFromCsvFile($request->file('listFile'));

        DB::transaction(function () use ($request, $emails) {
            $emailList = EmailList::query()->create([
                'title' => $request->title,
            ]);
            $emailList->subscribers()->createMany($emails);
        });

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

    /**
     * @param UploadedFile $listFile
     * @return array
     */
    private function getEmailsFromCsvFile(UploadedFile $listFile): array
    {
        $fileHandle = fopen($listFile->getRealPath(), 'r');
        $items = [];

        while (($line = fgetcsv($fileHandle)) !== false) {
            if (mb_strtolower($line[0]) == 'name' && mb_strtolower($line[1]) == 'email') {
                continue;
            }

            $items[] = [
                'name' => $line[0],
                'email' => $line[1],
            ];
        }

        fclose($fileHandle);
        return $items;
    }
}
