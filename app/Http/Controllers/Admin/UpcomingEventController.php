<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UpcomingEvent;
use App\Services\Admin\UpcomingEventService;
use Illuminate\Support\Facades\Auth;
class UpcomingEventController extends Controller
{
    //
     //
    public function __construct() {
        //Check Auth
        $this->middleware('auth');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        //Check is Center Chooses or Not
        // $this->middleware('session');
        $this->middleware('permission:upcoming_event-list|upcoming_event-create|upcoming_event-edit|upcoming_event-delete', ['only' => ['index','save']]);
         $this->middleware('permission:upcoming_event-create', ['only' => ['add','save']]);
         $this->middleware('permission:upcoming_event-edit', ['only' => ['edit','update','updateSortOrder']]);
    
    }
    
    ############################
    # Upcoming event View
    ############################

    public function index() {
        $title = __('Upcoming event');
        $albums = UpcomingEvent::where('status', '!=', 'DELETED')->orderBy('sort_order')->get();

        return view('admin.upcoming_event.list')
                        ->with('title', $title)
                        ->with('dataArray', $albums)
        ;
    }

    ############################
    # Upcoming event Add
    ############################

    public function add() {
        $title = __('Upcoming event Add');

        return view('admin.upcoming_event.add')
                        ->with('title', $title)
        ;
    }

    public function save(Request $request) {
        $this->validate(request(), [
            'title' => 'required',
            'event_date' => 'required|date',
            'description' => 'nullable',
            'sort_order' => 'bail|required|numeric',
            'image' => 'required|mimes:jpg,jpeg,png,bmp,tiff|max:2000',
        ]);
        UpcomingEventService::save($request);
        return redirect()->back();
    }

    public function update(Request $request) {
        $this->validate(request(), [
            'id' => 'bail|required|',
            'title' => 'required',
            'event_date' => 'required|date',
            'description' => 'nullable',
            'sort_order' => 'bail|required|numeric',
            'image' => 'nullable|mimes:jpg,jpeg,png,bmp,tiff|max:2000',
        ]);
        UpcomingEventService::update($request);
        return redirect()->back();
    }

    ############################
    # Upcoming event View
    ############################

    public function edit($id) {
        $title = __('Upcoming event Edit');
        $albums = UpcomingEvent::find($id);

        return view('admin.upcoming_event.edit')
                        ->with('title', $title)
                        ->with('data', $albums)
        ;
    }

    function updateSortOrder(Request $request) {
        $id = $request->post('id');
        $sort_order = $request->post('sort_order');

        $data = array();
        if (!empty($id)) {

            $category = UpcomingEvent::find($id);
            $category->sort_order = $sort_order;
            $category->updated_by = auth()->user()->email;

            if ($category->save()) {
                $data['code'] = 200;
                $data['status'] = 'success';
                $data['message'] = 'Your data has been updated';
                session()->put('succsess', "Your data has been updated Successfully");
            } else {
                $data['code'] = 201;
                $data['status'] = 'error';
                $data['message'] = 'Data updating failed !';
                session()->put('error', "Data updating failed Please try again !");
            }
        } else {
            Log::debug("Empty Data");
            $data['code'] = 201;
            $data['status'] = 'error';
            $data['message'] = 'Data updating failed ! Empty';
            session()->put('error', "Category Id Is Required Please try again !");
        }
        return response()->json($data);
    }
    
}
