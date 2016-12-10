<?php

namespace WebLab;

use \WebLab\Core as Core;

class Controller {

    /**
     * Core instance
     * @var Core 
     */
    protected $app;
    /**
     * Example 
     * [
     *  [
     *    "route"=>"site/index",
     *    "caption"=>"Link",
     *     ...
     *  ]
     * ...
     * }
     * @var array 
     */
    protected $menu;
    protected $title = "";

    /**
     * Init $app property
     * @param Core $core
     */
    public function init(Core $core) {
        $this->app = $core;
    }

    public function render($name, $data = array(), $return = false) {
        $twig = $this->app->getTwig();
        $res = $twig->render("$name.tpl.php", 
                array_merge([
                    "title" => $this->title, 
                    'menu'=>$this->menu, 
                    "baseUrl"=>$this->app->getBaseUrl(), 
                    "message"=>$this->getMessage(),
                    ], $data));
        if ($return) {
            return $res;
        }
        echo $res;
    }
    
    public function __construct() {
        
        
        $this->menu = Components\Menu::getMenuTree();
    }
    public function redirect($route, $params = array()){
        $url = "index.php?q=".$route;
        if (count($params)>0){
           $url.="&".http_build_query($params);
        }
        header("Location: ".$this->app->getBaseUrl().$url);
    }
    /**
     * 
     * @param type $text
     * @param type $status success|warning|error
     */
    public function  setMessage($text, $status="success"){
        $_SESSION["message"] = [
          "text"=>$text,
          "status"=>$status,
        ];
    }
    /**
     * 
     * @return type
     */
    public function  getMessage(){
        $res = false;
        if (isset($_SESSION["message"])){
            $res = $_SESSION["message"];
            unset($_SESSION["message"]);
        }
        return $res;
    }
}
