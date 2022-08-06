<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebAlbum;
use App\Models\WebAlbumImage;
use App\Services\Admin\WebAlbumImageService;

class WebAlbumImageController extends Controller
{
    //
    public function __construct()
    {
        //Check Auth
        $this->middleware('auth');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        //Check is Center Chooses or Not
       // $this->middleware('session');
        $this->middleware('permission:web_album_image-list|web_album_image-create|web_album_image-edit|web_album_image-delete', ['only' => ['index','save']]);
         $this->middleware('permission:web_album_image-create', ['only' => ['add','save']]);
         $this->middleware('permission:web_album_image-edit', ['only' => ['edit','update','updateSortOrder']]);
    
    }
    
    ############################
    # Gallery Image View
    ############################

    public function index($album_slug) {
        $title = __('Gallery Image');
        $albums = WebAlbum::where('status', '!=', 'DELETED')->where('url',$album_slug)->first();
        $album_images = WebAlbumImage::where('status', '!=', 'DELETED')->orderBy('sort_order')->get();

        return view('admin.album_image.list')
                        ->with('title', $title)
                        ->with('album', $albums)
                        ->with('dataArray', $album_images)
        ;
    }
    
    ############################
    # Gallery Image  Iamage Add
    ############################

    public function add($album_id) {
        $title = __('Gallery Image Add');
       $albums = WebAlbum::find($album_id);
        return view('admin.album_image.add')
                        ->with('title', $title)
                         ->with('album', $albums)
        ;
    }
    
    public function save(Request $request) {
        $this->validate(request(), [
            'album_id' => 'required',
            'title' => 'nullable',
            'description' => 'nullable',
            'sort_order' => 'bail|required|numeric',
            'image' => 'required|mimes:jpg,jpeg,png,bmp,tiff|max:2000',
        ]);
        WebAlbumImageService::save($request);
        return redirect()->back();
    }

    public function update(Request $request) {
        $this->validate(request(), [
            'id' => 'bail|required|',
            'album_id' => 'required',
            'title' => 'nullable',
            'description' => 'nullable',
            'sort_order' => 'bail|required|numeric',
            'image' => 'nullable|mimes:jpg,jpeg,png,bmp,tiff|max:2000',
        ]);
        WebAlbumImageService::update($request);
        return redirect()->back();
    }

    ############################
    # Gallery Image View
    ############################

    public function edit($id) {
        $title = __('Gallery Image Edit');
        $albumImage = WebAlbumImage::find($id);
        $albums = WebAlbum::find($albumImage->album_id);
        return view('admin.album_image.edit')
                        ->with('title', $title)
                        ->with('data', $albumImage)
                        ->with('album', $albums)
        ;
    }

    function updateSortOrder(Request $request) {
        $id = $request->post('id');
        $sort_order = $request->post('sort_order');

        $data = array();
        if (!empty($id)) {

            $category = WebAlbumImage::find($id);
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
