<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use Illuminate\Http\Request;
use App\Http\Requests\CalendarEventRequest;
use Illuminate\Database\QueryException;

class CalendarEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('calendar.index');
    }

    public function getCalendarEvents()
    {
        $eventList = CalendarEvent::get(['event_name', 'start_date', 'end_date']);
        return response()->json(['Status' => 1, 'Data' => $eventList, 'Message' => 'Events has been retrieved']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CalendarEventRequest $calendarEventRequest, CalendarEvent $calendarEvent)
    {
        $events = $calendarEvent::create($calendarEventRequest->all());
        return response()->json(['Status' => 1, 'Message' => 'Calendar Event has been saved', 'Data' => $events]);
    }

    public function createEvents(Request $request)
    {
        try {
            $events = $request->events;
            $data = array();
            
            foreach($events as $event){
                $data[] = [
                    'event_name'=> $event['title'],
                    'start_date' => $event['start'],
                    'end_date' => $event['end']
                ];
            }
            
            if(count($events) > 0) {
                $response = CalendarEvent::insert($data);

                if($response) {
                    return response()->json(['Status' => 1, 'Data' => $data, 'Message' => 'Events has been added successfully']);
                } else{
                    return response()->json(['Status' => 0, 'Message' => 'There was an error processing your request']);
                }
            } else{
                return response()->json(['Status' => 0, 'Message' => 'Please input required fields']);
            }
        } catch (QueryException $e) {
            return response()->json(['Status' => 2, 'Message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function show(CalendarEvent $calendarEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(CalendarEvent $calendarEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CalendarEvent $calendarEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CalendarEvent  $calendarEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(CalendarEvent $calendarEvent)
    {
        //
    }
}
