<?php
    define("MAINPATH", __dir__."/");
    define("DEVELOP",true); //Продакшн или разработка
    
    if(DEVELOP) {
        ini_set("display_errors","1");
    }
    
    //Подгружаем нужные классы
    include MAINPATH."system/FuncController.php";
    include MAINPATH."system/MainController.php";
    include MAINPATH."controller/HomeController.php";
    
    $temp = new controller\HomeController();
  
    //Выполнение маршрута
    $temp->action();
    
    $func = new system\FuncController();
    $func->setData($temp->getData());
    
    //Подключаем шаблоны
    $func->setTemplate("header");
    $func->setTemplate($temp->template);
    $func->setTemplate("footer");
?>