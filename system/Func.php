<?php
    namespace system;
    
    Class Func
    {
        private $data = [];
        private $conDb;
        
        public function setTemplate($template)
        {
            $data = $this->data;
            
            if($template) {
                if(file_exists(MAINPATH."view/".$template.".php")) {
                    require_once(MAINPATH."view/".$template.".php");
                } else {
                    echo "Ошибка подключения шаблона: $template."; exit();
                }
            }
        }
        
        public function setData($vals)
        {
            $this->data = $vals;
        }
    }
?>