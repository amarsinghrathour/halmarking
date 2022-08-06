<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Admin;

/**
 * Description of NoticeBoardService
 *
 * @author singh
 */
use App\Models\NoticeBoard;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class NoticeBoardService {
    //put your code here
     //put your code here
    public static function save($request) {

        $title = htmlspecialchars(strip_tags($request->input('title')));
        $description = $request->input('description');
        $url = self::create_slug($title);
        $sort_order = htmlspecialchars(strip_tags($request->input('sort_order')));

        
        try {
            DB::beginTransaction();
            


            $noticeBoard = new NoticeBoard;
            $noticeBoard->title = $title;
            $noticeBoard->url = $url;
            
            $noticeBoard->description = $description;
            $noticeBoard->sort_order = $sort_order;

            
            $noticeBoard->created_by = auth()->user()->email;
            if ($noticeBoard->save()) {
                session()->put('success', "Data Saved Successfully");
                DB::commit();
                return true;
            } else {
                DB::rollback();
                Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured ");
                
                session()->put('error', "Error Occured While Data Storing Please try again !");
                return false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
            
            session()->put('error', "Exception While Data Storing Please try again !");
            return false;
        }



        return false;
    }

    public static function update($request) {

        $id = $request->input('id');
        $title = htmlspecialchars(strip_tags($request->input('title')));
        $description = $request->input('description');
        $sort_order = htmlspecialchars(strip_tags($request->input('sort_order')));

        try {
            DB::beginTransaction();
            


            $noticeBoard = NoticeBoard::find($id);
            $noticeBoard->title = $title;
            if ($noticeBoard->title != $title) {
                $noticeBoard->url = self::create_slug($title);
            }
            $noticeBoard->description = $description;
            
            $noticeBoard->sort_order = $sort_order;
            
            $noticeBoard->updated_by = auth()->user()->email;
            if ($noticeBoard->save()) {
                session()->put('success', "Data Saved Successfully");
                DB::commit();
               
                return true;
            } else {
                DB::rollback();
                Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured ");
               
                session()->put('error', "Error Occured While Data Storing Please try again !");
                return false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
           
            session()->put('error', "Exception While Data Storing Please try again !");
            return false;
        }



        return false;
    }

    protected static function create_slug($string) {
        $slug = "";
        do {
            //$slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
            $slug = strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
            $data = NoticeBoard::where('url', $slug)->count();
            if ($data > 0) {
                $string = $slug . '-' . $data;
            }
        } while ($data > 0);


        return $slug;
    }
}
