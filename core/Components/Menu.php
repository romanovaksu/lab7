<?php

namespace WebLab\Components;

use WebLab\Model as Model;

class Menu extends Model {
    
    protected $table = "main_menu";
    
    public static function getMenuTree(){
        $current = !empty($_GET["q"])?$_GET["q"]:"site/index";
        $menu = self::where("pid", "0")->get();
        $res = array();
        foreach($menu as $item){
            $active = $item->route == $current ? true:false;
            if ($current == "" && $item->route == "site/index") $active = true;
            $res[] = [
                "route"=>$item->route,
                "title"=>$item->title,
                "active"=> $item->route == $active
            ];
        }
        return $res;
    }
}

