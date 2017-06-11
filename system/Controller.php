<?php
    namespace system;

    Class Controller {
        protected $data;
        
        public $template = "";
        
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