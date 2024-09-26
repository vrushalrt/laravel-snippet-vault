<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    use CanLoadRelationships;

    private readonly array $relations;

    public function __construct()
    {
        $this->relations = ['user', 'attendees', 'attendees.user'];
        $this->middleware('auth:sanctum')->except(['index','show']);
        $this->middleware('throttle:60,1')
            ->only(['store','update','destroy']);
        $this->authorizeResource(Event::class, 'event');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $query = Event::query();
        $query = $this->loadRelationships(Event::query());

        return EventResource::collection(
//            Event::with('user')->get()
//            Event::with('user')->paginate()
            $query->latest()->paginate()
        );
    }

//    protected function shouldIncludeRelation(string $relation): bool
//    {
//        $include = request()->query('include');
//
//        if (!$include)
//        {
//            return false;
//        }
//
//        $relations = array_map('trim', explode(',',$include));
//
//        return in_array($relation, $relations);
//    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataEventValidate = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'start_time'    => 'required|date',
            'end_time'      => 'required|date|after:start_time',
        ]);

        $event = Event::create([
            ...$dataEventValidate,
            'user_id' => $request->user()->id
        ]);

//        return new EventResource($event);
        return new EventResource($this->loadRelationships($event));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
//        $event->load('user','attendees');
        return new EventResource($this->loadRelationships($event));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
//        Authorization
//        Gate::allows()
//        if (Gate::denies('update-event',$event)) {
//            abort(403, 'You are not authorized to update the event!');
//        }
        // OR Authorization
        $this->authorize('update-event', $event);

        $dataEventValidate = $request->validate([
            'name'          => 'sometimes|string|max:255',
            'description'   => 'nullable|string',
            'start_time'    => 'sometimes|date',
            'end_time'      => 'sometimes|date|after:start_time',
        ]);

        // Update Event
        $event->update($dataEventValidate);

//        return new EventResource($event);
        return new EventResource($this->loadRelationships($event));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

//        return response()->json([
//            'message' => 'Event deleted successfully'
//        ]);

        // OR Practice this
        return response(status: 204);

    }
}
