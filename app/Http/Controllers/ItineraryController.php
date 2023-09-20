<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itinerary;
use Illuminate\Support\Facades\Auth;

class ItineraryController extends Controller
{
    public function index(Itinerary $itinerary)
    {
        $books = $itinerary->get();
        return view('books/index')->with(['books' => $books ]);
    }
    
    public function store(Request $request, Itinerary $itinerary)
    {
        $input = $request->input('book');
        $input['user_id'] = Auth::id();
        $itinerary->fill($input)->save();
        
        return redirect('/books/create/'.$itinerary->id);
    }

    public function create(Itinerary $itinerary)
    {
        return view('books/create')->with(['book'=>$itinerary]);
    }
    
    public function update(Request $request, Itinerary $itinerary)
    {
        $input = $request->input('book');
        $input['user_id'] = Auth::id();
        $itinerary->fill($input)->save();
        
        return redirect('/books/index');
    }
    
    public function delete(Itinerary $itinerary)
    {
        $itinerary->delete();
        return redirect('/books/index');
    }
}
