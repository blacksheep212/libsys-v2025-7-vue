<?php

namespace App\Http\Controllers;

use App\Models\BorrowingTransaction;
use App\Models\LibraryVisit;
use App\Models\Record;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function  index(Request $request)
    {
        $records = Record::with('book')
            ->select('records.*', DB::raw('(SELECT COUNT(*) FROM records r2 WHERE r2.title = records.title AND r2.deleted_at IS NULL) as copy_count'))
            ->whereIn('id', function($subQuery) {
                $subQuery->select(DB::raw('MIN(id)'))
                    ->from('records')
                    ->whereNull('deleted_at')
                    ->groupBy('title');
            })
            ->latest()
            ->paginate(10);

        $search_result = null;
        if ($request->search_button)
        {
            if ($request->filled('search')) {
                $search_term = $request->search;

                $search_result = Record::with('book')
                    ->select('records.*', DB::raw('(SELECT COUNT(*) FROM records r2 WHERE r2.title = records.title AND r2.deleted_at IS NULL) as copy_count'))
                    ->where(function($query) use ($search_term) {
                        $query->where('accession_number', 'LIKE', '%' . $search_term . '%')
                            ->orWhere('title', 'LIKE', '%' . $search_term . '%');
                    })
                    ->whereIn('id', function($subQuery) {
                        $subQuery->select(DB::raw('MIN(id)'))
                            ->from('records')
                            ->whereNull('deleted_at')
                            ->groupBy('title');
                    })
                    ->paginate(5);

            } else {
                session()->flash('error', 'Enter a search term');
            }
        }

        $user_count = User::count();
        $record_count = Record::count();
        $transaction_count = BorrowingTransaction::count() + LibraryVisit::count();

        return Inertia::render('Welcome', [
            'records' => $records,
            'search_result' => $search_result,
            'search_term' => $request->search,
            'search_button' => $request->search_button,
            'userCount' => $user_count,
            'recordCount' => $record_count,
            'transactionCount' => $transaction_count,
        ]);
    }

}
