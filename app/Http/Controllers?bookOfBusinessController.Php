<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BookOfBusinessController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 50;
        $page = max(1, (int)$request->get('page', 1));
        $offset = ($page - 1) * $perPage;

        $total = DB::table('book_of_business')->count();
        $clients = DB::table('book_of_business')
            ->orderBy('name', 'asc')
            ->offset($offset)
            ->limit($perPage)
            ->get();

        $selectedId = (int) $request->get('id', $clients->first()->id ?? 0);
        $client = DB::table('book_of_business')->find($selectedId);

        $notes = DB::table('notes')
            ->where('client_type', 'book_of_business')
            ->where('client_id', $selectedId)
            ->orderByDesc('created_at')
            ->get();

        return view('book_of_business', compact('clients', 'client', 'notes', 'total', 'page', 'perPage', 'offset'));
    }
}
