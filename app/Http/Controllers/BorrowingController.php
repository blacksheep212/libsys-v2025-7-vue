<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Record;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('borrowings/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): \Inertia\Response
    {
        $search_result = null;
        if ($request->searchAcc) {
            $search_result = Record::where('accession_number', $request->searchAcc)->first();
        }

        if ($request->scannedAcc) {
            $search_result = Record::where('accession_number', $request->scannedAcc)->first();
        };

        return Inertia::render('borrowings/Create', [
            'search_ac_result' => $search_result,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->borrow_type === 'inside') {

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrowing $borrowing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        //
    }
}
