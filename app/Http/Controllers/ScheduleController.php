<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function store(Request $request, Schedule $schedule)
    {
        $input = $request->input('schedule');
        $schedule->fill($input)->save();
        return redirect('/books/create/'.$schedule->itinerary_id);
    }
    
    public function update(Request $request, Schedule $schedule)
    {
        $input = $request->input('schedule');
        $schedule->fill($input)->save();
        return redirect('/books/create/'.$schedule->itinerary_id);
    }
    
    public function delete(Schedule $schedule)
    {
        $schedule->delete();
        return redirect('/books/create/'.$schedule->itinerary_id);
    }
}
