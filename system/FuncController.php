<?php
    namespace system;
    
    Class FuncController
    {
        private $data = [];
        
        final public function setTemplate($template)
        {
            $data = $this->data;
            
            if($template) {
                if(file_exists(MAINPATH."view/".$template.".php")) {
                    require_once(MAINPATH."view/".$template.".php");
                } else {
                    echo "Ошибка подключения шаблона: $template.";exit();
                }
            }
        }
        
        final public function setData($vals)
        {
            $this->data = $vals;
        }
    }
?>