<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contacts;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contacts::orderBy('id', 'DESC')->get();
        return view('admin.contacts.index', with([
            'contacts' => $contacts,
        ]));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contacts = Contacts::find($id);

        return view('admin.contacts.show', with([
            'contacts' => $contacts,
        ]));
    }

}
