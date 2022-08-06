<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Admin;

/**
 * Description of WebPostService
 *
 * @author singh
 */
use App\Models\WebPost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebPostService {

    //put your code here

    public static function save($request) {

        $title = htmlspecialchars(strip_tags($request->input('title')));
        $description = $request->input('description');
        $status = htmlspecialchars(strip_tags($request->input('status')));
        $category = htmlspecialchars(strip_tags($request->input('category')));
        $sub_category = htmlspecialchars(strip_tags($request->input('sub_category')));
        $video_embed = $request->input('video_embed');
        $audio_embed = $request->input('audio_embed');
        $template = 'blog_detail';
        $meta_title = htmlspecialchars(strip_tags($request->input('meta_title')));
        $meta_description = htmlspecialchars(strip_tags($request->input('meta_description')));
        $meta_key_word = htmlspecialchars(strip_tags($request->input('meta_key_word')));
        $slug = self::create_slug($title);
        $imageDb = '';
        /* $sidebar = $request->input('sidebar');
          $sidebarIds = '';
          if(!empty($sidebar) && count($sidebar) > 0){
          $sidebarIds = implode(',',$sidebar);
          }
         */
        try {
            DB::beginTransaction();
            if ($request->hasFile('image')) {
                $imageDb = uploadImage($request->file('image'), 'gallery', 'gallery');
                if (!$imageDb) {
                    session()->put('error', "Error while uploading Image !");
                    return false;
                }
            }



            $web_page = new WebPost;
            $web_page->title = $title;
            $web_page->url = $slug;
            $web_page->description = $description;
            if (!empty($imageDb)) {
                $web_page->image = $imageDb;
            }
            $web_page->video_embed = $video_embed;
            $web_page->audio_embed = $audio_embed;
            $web_page->status = $status;
            $web_page->template = $template;
            $web_page->type = 'BLOG';
            //$web_page->sidebar = $sidebarIds;
            $web_page->category_id = $category;
            if (!empty($sub_category)) {
                $web_page->sub_category_id = $sub_category;
            }
            $web_page->meta_title = $meta_title;
            $web_page->meta_description = $meta_description;
            $web_page->meta_key_word = $meta_key_word;

            $web_page->created_by = auth()->user()->email;
            if ($web_page->save()) {
                session()->put('success', "Data Saved Successfully");
                DB::commit();
                return true;
            } else {
                Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured ");
                if (!empty($imageDb) && file_exists(public_path() . '/' . $imageDb)) {
                    unlink(public_path() . '/' . $imageDb);
                }
                session()->put('error', "Error Occured While Data Storing Please try again !");
                return false;
            }
        } catch (\Exception $e) {
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
            if (!empty($imageDb) && file_exists(public_path() . '/' . $imageDb)) {
                unlink(public_path() . '/' . $imageDb);
            }
            session()->put('error', "Exception While Data Storing Please try again !");
            return false;
        }



        return false;
    }

    public static function update($request) {

        $id = $request->input('id');
        $title = htmlspecialchars(strip_tags($request->input('title')));
        $description = $request->input('description');
        $status = htmlspecialchars(strip_tags($request->input('status')));
        $category = htmlspecialchars(strip_tags($request->input('category')));
        $sub_category = htmlspecialchars(strip_tags($request->input('sub_category')));
        
        $video_embed = $request->input('video_embed');
        $audio_embed = $request->input('audio_embed');
        
        $meta_title = htmlspecialchars(strip_tags($request->input('meta_title')));
        $meta_description = htmlspecialchars(strip_tags($request->input('meta_description')));
        $meta_key_word = htmlspecialchars(strip_tags($request->input('meta_key_word')));

        /*
          $sidebar = $request->input('sidebar');
          $sidebarIds = '';
          if(!empty($sidebar) && count($sidebar) > 0){
          $sidebarIds = implode(',',$sidebar);
          }
         */
        $imageDb = '';
        $oldImageDb = '';
        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $imageDb = uploadImage($request->file('image'), 'gallery', 'gallery');
            }

            $web_page = WebPost::find($id);
            if ($web_page->title != $title) {
                $web_page->url = $this->create_slug($title);
                $web_page->title = $title;
            }

            if (!empty($imageDb)) {
                $oldImageDb = $web_page->image;
                $web_page->image = $imageDb;
            }

            $web_page->description = $description;
            $web_page->video_embed = $video_embed;
            $web_page->audio_embed = $audio_embed;
            $web_page->status = $status;
            //$web_page->sidebar = $sidebarIds;
            $web_page->category_id = $category;
            if (!empty($sub_category)) {
                $web_page->sub_category_id = $sub_category;
            }
            $web_page->meta_title = $meta_title;
            $web_page->meta_description = $meta_description;
            $web_page->meta_key_word = $meta_key_word;

            $web_page->updated_by = auth()->user()->email;
            if ($web_page->save()) {
                session()->put('success', "Data Updated Successfully");
                DB::commit();
                if (!empty($oldImageDb) && file_exists(public_path() . '/' . $oldImageDb)) {
                    unlink(public_path() . '/' . $oldImageDb);
                }
                return true;
            } else {
                DB::rollback();
                Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured ");
                if (!empty($imageDb) && file_exists(public_path() . '/' . $imageDb)) {
                    unlink(public_path() . '/' . $imageDb);
                }
                session()->put('error', "Error Occured While Data Storing Please try again !");
                return false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
            if (!empty($imageDb) && file_exists(public_path() . '/' . $imageDb)) {
                unlink(public_path() . '/' . $imageDb);
            }
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
            $data = WebPost::where('url', $slug)->count();
            if ($data > 0) {
                $string = $slug . '-' . $data;
            }
        } while ($data > 0);



        return $slug;
    }
    
    

}
