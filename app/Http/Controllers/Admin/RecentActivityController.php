<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\RecentActivityService;
use App\Models\RecentActivity;
class RecentActivityController extends Controller
{
    //
    public function __construct() {
        //Check Auth
        $this->middleware('auth');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        //Check is Center Chooses or Not
        // $this->middleware('session');
        $this->middleware('permission:recent_activity-list|recent_activity-create|recent_activity-edit|recent_activity-delete', ['only' => ['index','save']]);
         $this->middleware('permission:recent_activity-create', ['only' => ['add','save']]);
         $this->middleware('permission:recent_activity-edit', ['only' => ['edit','update','updateSortOrder']]);
    
    }
    
    ############################
    # Recent Activity View
    ############################

    public function index() {
        $title = __('Recent Activity');
        $albums = RecentActivity::where('status', '!=', 'DELETED')->orderBy('sort_order')->get();

        return view('admin.recent_activity.list')
                        ->with('title', $title)
                        ->with('dataArray', $albums)
        ;
    }

    ############################
    # Recent Activity Add
    ############################

    public function add() {
        $title = __('Recent Activity Add');

        return view('admin.recent_activity.add')
                        ->with('title', $title)
        ;
    }

    public function save(Request $request) {
        $this->validate(request(), [
            'title' => 'required',
            'activity_date' => 'required|date',
            'description' => 'nullable',
            'sort_order' => 'bail|required|numeric',
            'image' => 'required|mimes:jpg,jpeg,png,bmp,tiff|max:2000',
        ]);
        RecentActivityService::save($request);
        return redirect()->back();
    }

    public function update(Request $request) {
        $this->validate(request(), [
            'id' => 'bail|required|',
            'title' => 'required',
            'activity_date' => 'required|date',
            'description' => 'nullable',
            'sort_order' => 'bail|required|numeric',
            'image' => 'nullable|mimes:jpg,jpeg,png,bmp,tiff|max:2000',
        ]);
        RecentActivityService::update($request);
        return redirect()->back();
    }

    ############################
    # Recent Activity View
    ############################

    public function edit($id) {
        $title = __('Recent Activity Edit');
        $albums = RecentActivity::find($id);

        return view('admin.recent_activity.edit')
                        ->with('title', $title)
                        ->with('data', $albums)
        ;
    }

    function updateSortOrder(Request $request) {
        $id = $request->post('id');
        $sort_order = $request->post('sort_order');

        $data = array();
        if (!empty($id)) {

            $category = RecentActivity::find($id);
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
