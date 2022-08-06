<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Admin\WebSliderService;
use App\Models\WebSlider;
class WebSliderController extends Controller
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
        $this->middleware('permission:web_slider-list|web_slider-create|web_slider-edit|web_slider-delete', ['only' => ['index','save']]);
         $this->middleware('permission:web_slider-create', ['only' => ['add','save']]);
         $this->middleware('permission:web_slider-edit', ['only' => ['edit','update','updateSortOrder']]);
    
    }
    
    ############################
    # Slider View
    ############################
     public function index() 
    {
          $title = __('Slider');
          $sliders = WebSlider::where('status','!=','DELETED')->orderBy('sort_order')->get();
          
      return view('admin.slider.list')
         ->with('title', $title)
         ->with('dataArray', $sliders)
         ;

    }
    ############################
    # Slider Add
    ############################
     public function add() 
    {
          $title = __('Slider Add');
          
      return view('admin.slider.add')
         ->with('title', $title)
         ;

    }
    
    
    
    public function save(Request $request) {
        $this->validate(request(), [
            'title' => 'nullable',
            'sub_title' => 'nullable',
            'description' => 'nullable',
            'sort_order' => 'bail|required|numeric',
            'image' => 'required|mimes:jpg,jpeg,png,bmp,tiff|max:2000',
        ]);
        WebSliderService::save($request);
        return redirect()->back();
    }
    public function update(Request $request) {
        $this->validate(request(), [
            'id' => 'bail|required|',
            'title' => 'nullable',
            'sub_title' => 'nullable',
            'description' => 'nullable',
            'sort_order' => 'bail|required|numeric',
            'image' => 'nullable|mimes:jpg,jpeg,png,bmp,tiff|max:2000',
        ]);
        WebSliderService::update($request);
        return redirect()->back();
    }
    
    
    ############################
    # Slider View
    ############################
     public function edit($id) 
    {
          $title = __('Slider Edit');
          $sliders = WebSlider::find($id);
          
      return view('admin.slider.edit')
         ->with('title', $title)
         ->with('data', $sliders)
         ;

    }
    
    
    function updateSortOrder(Request $request) {
    $id = $request->post('id');
        $sort_order = $request->post('sort_order');
       
        $data = array();
        if(!empty($id)){
            
            $category = WebSlider::find($id);
            $category->sort_order = $sort_order;
            $category->updated_by = auth()->user()->email;
            
            if($category->save()){
                $data['code'] = 200;
                $data['status'] = 'success';
                $data['message'] = 'Your data has been updated';
                session()->put('succsess',"Your data has been updated Successfully");
            }
            else
            {
                $data['code'] = 201;
                $data['status'] = 'error';
                $data['message'] = 'Data updating failed !';
                session()->put('error',"Data updating failed Please try again !");
            }
        } else {
            Log::debug("Empty Data");
            $data['code'] = 201;
            $data['status'] = 'error';
            $data['message'] = 'Data updating failed ! Empty';
            session()->put('error',"Category Id Is Required Please try again !");
        }
        return response()->json($data);
}
    
}
