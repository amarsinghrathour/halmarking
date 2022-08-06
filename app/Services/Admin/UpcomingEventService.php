<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Admin;

/**
 * Description of UpcomingEventService
 *
 * @author singh
 */
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\UpcomingEvent;
class UpcomingEventService {

    //put your code here
    public static function save($request) {

        $title = htmlspecialchars(strip_tags($request->input('title')));
        $description = $request->input('description');
        $event_date = $request->input('event_date');
        $url = self::create_slug($title);
        $sort_order = htmlspecialchars(strip_tags($request->input('sort_order')));

        $imageDb = '';
        try {
            DB::beginTransaction();
            if ($request->hasFile('image')) {
                $imageDb = uploadImage($request->file('image'), 'event', 'event');
            }

            if (!$imageDb) {
                session()->put('error', "Error while uploading Image !");
                return false;
            }

            $upcomingEvent = new UpcomingEvent;
            $upcomingEvent->title = $title;
            $upcomingEvent->url = $url;
            $upcomingEvent->event_date = $event_date;
            $upcomingEvent->description = $description;
            $upcomingEvent->sort_order = $sort_order;

            $upcomingEvent->image = $imageDb;
            $upcomingEvent->created_by = auth()->user()->email;
            if ($upcomingEvent->save()) {
                session()->put('success', "Data Saved Successfully");
                DB::commit();
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

    public static function update($request) {

        $id = $request->input('id');
        $title = htmlspecialchars(strip_tags($request->input('title')));
        $description = $request->input('description');
        $event_date = $request->input('event_date');
        $sort_order = htmlspecialchars(strip_tags($request->input('sort_order')));

        $imageDb = '';
        $oldImageDb = '';
        try {
            DB::beginTransaction();
            if ($request->hasFile('image')) {
                $imageDb = uploadImage($request->file('image'), 'event', 'event');
            }


            $upcomingEvent = UpcomingEvent::find($id);
            $upcomingEvent->title = $title;
            if ($upcomingEvent->title != $title) {
                $upcomingEvent->url = self::create_slug($title);
            }
            $upcomingEvent->description = $description;
            $upcomingEvent->event_date = $event_date;
            $upcomingEvent->sort_order = $sort_order;
            if (!empty($imageDb)) {
                $oldImageDb = $upcomingEvent->image;
                $upcomingEvent->image = $imageDb;
            }
            $upcomingEvent->updated_by = auth()->user()->email;
            if ($upcomingEvent->save()) {
                session()->put('success', "Data Saved Successfully");
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
            $data = UpcomingEvent::where('url', $slug)->count();
            if ($data > 0) {
                $string = $slug . '-' . $data;
            }
        } while ($data > 0);


        return $slug;
    }

}
