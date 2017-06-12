<?php
    namespace system;

    abstract class Controller 
    {
        protected $data;
        public $template = "";
        
        abstract protected function action();
        
        public function __construct()
        {
            $this->data['title'] = "Мой проект";
        }
        
        public function getData()
        {
            return $this->data;
        }
    }
?>