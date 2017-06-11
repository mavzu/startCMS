<?php
    namespace controller;
    
    use system\MainController as Controller;

    Class HomeController extends Controller
    {
        public function action()
        {
            //Create Seo-Base
            $this->data['title'] = "Главная страница";
            
            $this->template = "home";
        }
    }
?>