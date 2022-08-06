<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebAlbum;
use App\Services\Admin\WebAlbumService;
class WebAlbumController extends Controller {

    //
    public function __construct() {
        //Check Auth
        $this->middleware('auth');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        //Check is Center Chooses or Not
        // $this->middleware('session');
        $this->middleware('permission:web_album-list|web_album-create|web_album-edit|web_album-delete', ['only' => ['index','save']]);
         $this->middleware('permission:web_album-create', ['only' => ['add','save']]);
         $this->middleware('permission:web_album-edit', ['only' => ['edit','update','updateSortOrder']]);
    
    }

    ############################
    # Gallery View
    ############################

    public function index() {
        $title = __('Gallery');
        $albums = WebAlbum::where('status', '!=', 'DELETED')->orderBy('sort_order')->get();

        return view('admin.album.list')
                        ->with('title', $title)
                        ->with('dataArray', $albums)
        ;
    }

    ############################
    # Gallery Add
    ############################

    public function add() {
        $title = __('Gallery Add');

        return view('admin.album.add')
                        ->with('title', $title)
        ;
    }

    public function save(Request $request) {
        $this->validate(request(), [
            'title' => 'required',
            'description' => 'nullable',
            'sort_order' => 'bail|required|numeric',
            'image' => 'required|mimes:jpg,jpeg,png,bmp,tiff|max:2000',
        ]);
        WebAlbumService::save($request);
        return redirect()->back();
    }

    public function update(Request $request) {
        $this->validate(request(), [
            'id' => 'bail|required|',
            'title' => 'required',
            'description' => 'nullable',
            'sort_order' => 'bail|required|numeric',
            'image' => 'nullable|mimes:jpg,jpeg,png,bmp,tiff|max:2000',
        ]);
        WebAlbumService::update($request);
        return redirect()->back();
    }

    ############################
    # Gallery View
    ############################

    public function edit($id) {
        $title = __('Gallery Edit');
        $albums = WebAlbum::find($id);

        return view('admin.album.edit')
                        ->with('title', $title)
                        ->with('data', $albums)
        ;
    }

    function updateSortOrder(Request $request) {
        $id = $request->post('id');
        $sort_order = $request->post('sort_order');

        $data = array();
        if (!empty($id)) {

            $category = WebAlbum::find($id);
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
