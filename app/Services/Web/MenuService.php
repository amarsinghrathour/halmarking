<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Services\Web;
/**
 * Description of MenuService
 *
 * @author singh
 */
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\WebMenu;
class MenuService {
    //put your code here
    
    public static function menusRecursive()
    {

        $items = WebMenu::
            where('status', 'ACTIVE')
            ->orderBy('sort_order', 'ASC')
            ->get();
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

            $ul = '';
            if ($menus) {
                $parent_id = 0;
                $ul = '';
                $div = 0;
                foreach ($menus as $parents) {
                    
                    
                    if ($parents->type == 0) {
                        $link = ' target="_blank" href="' . $parents->link . '"';
                    } elseif ($parents->type == 1) {
                        $link = ' href="' . url($parents->link) . '"';
                    } elseif ($parents->type == 2) {
                        $link = ' href="' . url($parents->link) . '"';
                    
                    } elseif ($parents->type == 3) {
                        $link = ' href="' . url('shop?category_url=') . $parents->link . '"';
                    } elseif ($parents->type == 4) {
                        $link = ' href="' . route('web.blog.category',['slug'=>$parents->link]) . '"';
                    } else{
                        $link = '#';
                    }

                    $ul .= '<li class=""><a class="" ' . $link . ' >
                ' . $parents->name . '
                </a>';

                    if (isset($parents->childs)) {
                        $i = 1;
                        $ul .= '<ul >';
                        $ul .= self::childMenu($parents->childs, $i, $parent_id, $div);
                        $ul .= '</ul>';
                        $ul .= '</li>';
                    } else {
                        $ul .= '</li>';
                    }

                }
               
            }

            return $ul;
        }

    }

    private static function childMenu($childs, $i, $parent_id, $div)
    {
        $contents = '';
        foreach ($childs as $key => $child) {
            

             $contents .= '
                <li class="">';

            if ($child->type == 0) {
                $link = ' target="_blank" href="' . $child->link . '"';
            } elseif ($child->type == 1) {
                $link = ' href="' . url($child->link) . '"';
            } elseif ($child->type == 2) {
                $link = ' href="' . url($child->link) . '"';
            }elseif ($child->type == 3) {
                        $link = ' href="' . url('shop?category_url=') . $child->link . '"';
                    } elseif ($child->type == 4) {
                        $link = ' href="' . route('web.blog.category',['slug'=>$child->link]) . '"';
                    } 

            $contents .= '
                <a class="" ' . $link . '>
                    ' .$child->name . '
                </a>
            ';
            if (isset($child->childs)) {
                $contents .= '
                <ul>';
                

                $k = $i + 1;
                $contents .= self::childMenu($child->childs, $k, $parent_id, 1);
                $contents .= '</ul></li>';
            } elseif ($i > 0) {
                $contents .= '</li>';
            }

        }
        return $contents;
    }
    
    /*
     public static function menusRecursiveMobile()
    {

        $items = WebMenu::
            where('status', 'ACTIVE')
            ->orderBy('sort_order', 'ASC')
            ->get();
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

            $ul = '';
            if ($menus) {
                $parent_id = 0;
                $ul = '';
                $div = 0;
                foreach ($menus as $parents) {
                    if (isset($parents->childs)) {
                        $dropright = 'dropdown';
                    } else {
                        $dropright = '';
                    }
                    
                    if ($parents->type == 0) {
                        $link = ' target="_blank" href="' . $parents->link . '"';
                    } elseif ($parents->type == 1) {
                        $link = ' href="' . url($parents->link) . '"';
                    } elseif ($parents->type == 2) {
                        $link = ' href="' . url($parents->link) . '"';
                    } else{
                        $link = '#';
                    }

                    $ul .= '<li class="'.$dropright.'"><a class="nav-link" ' . $link . ' >
                ' . $parents->name . '
                </a>';

                    if (isset($parents->childs)) {
                        $i = 1;
                        $ul .= '<ul class="dropdown-menu" >';
                        $ul .= self::childMenuMobile($parents->childs, $i, $parent_id, $div);
                        $ul .= '</ul>';
                        $ul .= '</li>';
                    } else {
                        $ul .= '</li>';
                    }

                }
               
            }

            return $ul;
        }

    }

    private static function childMenuMobile($childs, $i, $parent_id, $div)
    {
        $contents = '';
        foreach ($childs as $key => $child) {
            

             $contents .= '
                <li class="">';

            if ($child->type == 0) {
                $link = ' target="_blank" href="' . $child->link . '"';
            } elseif ($child->type == 1) {
                $link = ' href="' . url($child->link) . '"';
            } elseif ($child->type == 2) {
                $link = ' href="' . url($child->link) . '"';
            }

            $contents .= '
                <a class="" ' . $link . '>
                    ' .$child->name . '
                </a>
            ';
            if (isset($child->childs)) {
                $contents .= '
                <ul class="dropdown-menu">';
                // $contents .= '
                // <div class="dropdown-submenu submenu1">';

                $k = $i + 1;
                $contents .= self::childMenuMobile($child->childs, $k, $parent_id, 1);
                $contents .= '</ul></li>';
            } elseif ($i > 0) {
                $contents .= '</li>';
            }

        }
        return $contents;
    }
    
    */
    
}
