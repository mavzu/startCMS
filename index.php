<?php
    define("MAINPATH", __dir__."/");
    define("DEVELOP",true); //Продакшн или разработка
    
    if(DEVELOP) {
        ini_set("display_errors","1");
    }
    
    //Подгружаем нужные классы
    include MAINPATH."system/Func.php";
    include MAINPATH."system/Controller.php";
    include MAINPATH."system/Db.php";
    include MAINPATH."controller/HomeController.php";
    
    $db = new system\Db();
    
    $temp = new controller\HomeController();
  
    //Выполнение маршрута
    $temp->action();
    
    $func = new system\Func();
    $func->setData($temp->getData());
    
    //Подключаем шаблоны
    $func->setTemplate("header");
    $func->setTemplate($temp->template);
    $func->setTemplate("footer");
?>