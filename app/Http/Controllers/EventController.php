<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Events;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(5);
        return view('event.dataevent', compact('events'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('event.createevent');
    }
}   
