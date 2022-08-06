<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\NoticeBoardService;
use App\Models\NoticeBoard;
class NoticeBoardController extends Controller
{
    //
    public function __construct() {
        //Check Auth
        $this->middleware('auth');
        //Check Locked Screen
        $this->middleware('lockedscreen');
        //Check is Center Chooses or Not
        // $this->middleware('session');
        $this->middleware('permission:notice_board-list|notice_board-create|notice_board-edit|notice_board-delete', ['only' => ['index','save']]);
         $this->middleware('permission:notice_board-create', ['only' => ['add','save']]);
         $this->middleware('permission:notice_board-edit', ['only' => ['edit','update','updateSortOrder']]);
    
    }
    
    ############################
    # Notice Board View
    ############################

    public function index() {
        $title = __('Notice Board');
        $data = NoticeBoard::where('status', '!=', 'DELETED')->orderBy('sort_order')->get();

        return view('admin.notice_board.list')
                        ->with('title', $title)
                        ->with('dataArray', $data)
        ;
    }

    ############################
    # Notice Board Add
    ############################

    public function add() {
        $title = __('Notice Board Add');

        return view('admin.notice_board.add')
                        ->with('title', $title)
        ;
    }

    public function save(Request $request) {
        $this->validate(request(), [
            'title' => 'required',
            
            'description' => 'required',
            'sort_order' => 'bail|required|numeric',
            
        ]);
        NoticeBoardService::save($request);
        return redirect()->back();
    }

    public function update(Request $request) {
        $this->validate(request(), [
            'id' => 'bail|required|',
            'title' => 'required',
            
            'description' => 'required',
            'sort_order' => 'bail|required|numeric',
            
        ]);
        NoticeBoardService::update($request);
        return redirect()->back();
    }

    ############################
    # Notice Board View
    ############################

    public function edit($id) {
        $title = __('Notice Board Edit');
        $data = NoticeBoard::find($id);

        return view('admin.notice_board.edit')
                        ->with('title', $title)
                        ->with('data', $data)
        ;
    }

    function updateSortOrder(Request $request) {
        $id = $request->post('id');
        $sort_order = $request->post('sort_order');

        $data = array();
        
        if (!empty($id)) {

            $sort = NoticeBoard::find($id);
            $sort->sort_order = $sort_order;
            $sort->updated_by = auth()->user()->email;

            if ($sort->save()) {
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
