<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Admin;

/**
 * Description of WebMenuService
 *
 * @author singh
 */
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\WebMenu;
class WebMenuService {
    //put your code here
    
    public static function recursiveMenu()
    {
        $items = WebMenu::
            orderBy('sort_order', 'ASC')
            ->get();
        $ul = '';
        if ($items->isNotEmpty()) {
            $childs = array();
            foreach ($items as $item) {
                $childs[$item->parent_id][] = $item;
            }

            foreach ($items as $item) {
                if (isset($childs[$item->id])) {
                    $item->childs = $childs[$item->id];
                }
            }

            if (!empty($childs[0])) {
                $menus = $childs[0];
            } else {
                $menus = $childs;
            }

            $parent_id = 0;
            $ul = '<ul id="easymm" class="ui-sortable">';
            foreach ($menus as $parents) {

                if ($parents->status == 'INACTIVE') {
                    $status = '<span class="badge badge-warning">Inactive</span>';
                } else {
                    $status = '<span class="badge badge-success">Active</span>';
                }

                $ul .= '<li id="menu-' . $parents->id . '" class="sortable">
                <div class="ns-row">
                <div class="ns-title">' . $parents->name . '</div>
                <div class="ns-url">' . $parents->link . '</div>
                <div class="ns-class">' . $status . '</div>
                <div class="ns-actions">
                <a href="' .route('admin.web_menu.edit',['id'=>$parents->id]). '" class="btn btn-sm btn-info edit-menu">
                <i class="fa fa-edit" aria-hidden="true"></i>
                </a>
                <button type="button" onclick="deleteMenu('.$parents->id.');" class="btn btn-danger btn-sm delete-menu">
                <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
                <input type="hidden" name="menu_id" value="' . $parents->id . '">
                </div>
                </div>';

                if (isset($parents->childs)) {
                    $ul .= '<ul>';
                    $ul .= self::childcat($parents->childs, $parent_id);
                    $ul .= '</ul>';
                } else {
                    $ul .= '</li>';
                }
            }
            $ul .= '</ul>';

        }
        return $ul;
    }

    public static function childcat($childs, $parent_id)
    {
        $contents = '';
        foreach ($childs as $key => $child) {
            if ($child->status == 'INACTIVE') {
                $status = '<span class="badge badge-warning">Inactive</span>';
            } else {
                $status = '<span class="badge badge-success">Active</span>';
            }
            $contents .= '
            <li id="menu-' . $child->id . '" class="sortable">
            <div class="ns-row">
            <div class="ns-title">' . $child->name . '</div>
            <div class="ns-url">' . $child->link . '</div>
            <div class="ns-class">' . $status . '</div>
            <div class="ns-actions">
            <a href="editmenu/' . $child->id . '" class="badge-info badge-pill edit-menu">
            <i class="fa fa-edit" aria-hidden="true"></i>
            </a>
            <button id="deleteProductId" products_id="' . $child->id . '" class="badge-danger badge-pill delete-menu">
            <i class="fa fa-trash" aria-hidden="true" ></i>
            </button>
            <input type="hidden" name="menu_id" value="' . $child->id . '">
            </div>
            </div>
            ';
            if (isset($child->childs)) {
                $contents .= '
                <ul>';
                $contents .= self::childcat($child->childs, $parent_id);
                $contents .= '</li></ul>';
            } else {
                $contents .= '</li>';
            }

        }
        return $contents;
    }
    
    
    public static function save($request)
    {
        $order = WebMenu::max('sort_order');
        $order = $order + 1;

        $page_id = '';
        if ($request->type == 2) {
            $page_id = $request->page_id;
        }

        $link = '';
        if ($request->type == 0) {
            $link = $request->external_link;
        } elseif ($request->type == 1) {
            $link = $request->link;
        } elseif ($request->type == 2) {
            $link = $request->link;
        } elseif ($request->type == 3) {
            $link = $request->category_slug;
        } elseif ($request->type == 4) {
            $link = $request->post_category_slug;
        }
          
        try {
            DB::beginTransaction();
            $menuNew = new WebMenu;
            $menuNew->parent_id= $request->parent_id;
            $menuNew->name = $request->name;
            $menuNew->type = $request->type;
            $menuNew->status = $request->status;
            $menuNew->external_link = $request->external_link;
            $menuNew->link = $link;
            $menuNew->sort_order = $order;
            $menuNew->page_id = $request->page_id;
            $menuNew->created_by = auth()->user()->email;
        if($menuNew->save()){
           session()->put('success', "Data Saved Successfully");
                DB::commit();
                return true;
        }else {
                Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured ");
                
                session()->put('error', "Error Occured While Data Storing Please try again !");
                return false;
            }
        }catch (\Exception $e) {
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
            
            session()->put('error', "Exception While Data Storing Please try again !");
            return false;
        }
        return false;

    }
    
    
    public static function update($request)
    {

        $page_id = '';
        if ($request->type == 2) {
            $page_id = $request->page_id;
        }

        $link = '';
        if ($request->type == 0) {
            $link = $request->external_link;
        } elseif ($request->type == 1) {
            $link = $request->link;
        } elseif ($request->type == 2) {
            $link = $request->link;
        } elseif ($request->type == 3) {
            $link = $request->category_slug;
        } elseif ($request->type == 4) {
            $link = $request->post_category_slug;
        }
        $id = $request->id;
        try {
            DB::beginTransaction();
            $menuNew = WebMenu::find($id);
            $menuNew->name = $request->name;
            $menuNew->type = $request->type;
            $menuNew->status = $request->status;
            $menuNew->external_link = $request->external_link;
            $menuNew->link = $link;
            $menuNew->page_id = $request->page_id;
            $menuNew->updated_by = auth()->user()->email;
        if($menuNew->save()){
           session()->put('success', "Data Updated Successfully");
                DB::commit();
                return true;
        }else {
                Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured ");
                
                session()->put('error', "Error Occured While Data Storing Please try again !");
                return false;
            }
        }catch (\Exception $e) {
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
            
            session()->put('error', "Exception While Data Storing Please try again !");
            return false;
        }
        return false;

    }
    
     public static function savePosition($request)
    {
         try{
        $sort_order = 1;
        foreach ($request->menu as $key => $value) {
            $menu_id = $key;
            Log::debug(__CLASS__ . "::" . __FUNCTION__ . " called with menu id $menu_id and parent $value");
            if ($value == 'null') {
                $parent_id = 0;
            } else {
                $parent_id = $value;
            }

            

            if(!WebMenu::where('id', '=', $menu_id)->update([
                'parent_id' => $parent_id,
                'sort_order' => $sort_order,
            ])){
                Log::error(__CLASS__ . "::" . __FUNCTION__ . "Eror occured for updating menu $menu_id position");
                
                return false;
            }

            $sort_order++;

        }
        return true;
        }catch (\Exception $e) {
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
            
            return false;
        }
        return false;
    }
    
    public static function deletemenu($request)
    {
        try{
            $id = $request->input('id');
        WebMenu::where('id', $id)->delete();

        $order =  WebMenu::max('sort_order');
        $order = $order + 1;

        WebMenu::where('parent_id', '=', $id)->update([
            'parent_id' => 0,
            'sort_order' => $order,
        ]);
        session()->put('success', "Menu Deleted Successfully");
        return true;
        }catch (\Exception $e) {
            Log::error(__CLASS__ . "::" . __FUNCTION__ . "Exception occured :: " . $e->getMessage());
             session()->put('error', "Exception While Data Deleting Data Please try again !");
            
        }
        return false;
    }
    
}
