<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\LockscreenModel;
use Illuminate\Http\Request;

/**
 * Description of LockscreenController
 *
 * @author maury
 */
class LockscreenController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //check Auth
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /*
     * Open Lock Screen Page
     */
    public function showLockedScreen()
    {
        return view('lock-screen.index')
            ->with('title', 'Locked Screen');
    }
    /*
     * Screen Locked
     */
    public function screenLocked()
    {
        LockscreenModel::doScreenLocked();
        return redirect()->route('locked-screen');
    }
    /*
     * Screen Un-Locked
     */
    public function screenUnLocked(Request $request)
    {
        if(LockscreenModel::doScreenUnLocked($request->input('password'))){
        return redirect()->route('admin.dashboard');
        }else{
            return redirect()->back();
        }
    }
    
    
}
