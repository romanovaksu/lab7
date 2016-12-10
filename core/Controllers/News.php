<?php

namespace WebLab\Controllers;

use WebLab\Models\User as User;
use WebLab\Components\Menu as Menu;

class News extends \WebLab\Controller {

    public function doIndex() {
        $this->title = "Новости";
        $this->render("news/index", ['content' =>"Тут будут новости"]);
    }

    public function doAdd() {
        
        $this->setMessage("Тестовое сообщение!"); 
        $this->title = "Добавить новость";
        
        if (isset($_POST["author"])){
       
            \PC::debug($_POST);
            // сохранение данных    
            $this->redirect("news/index");
        }
        
        $this->render("news/form");
    }

    public function doUsers() {
        $users = User::all();
        $this->title = "Пользователи";
        $this->render("site/users", ["users" => $users]);
    }

}
