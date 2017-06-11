<?php
    namespace system;
    
    Class FuncController
    {
        private $data = [];
        
        public function setTemplate($template)
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
        
        public function setData($vals)
        {
            $this->data = $vals;
        }
        
        /* Передаем в функцию запроса к БД
         * данные в виде:
         * array ( 
         *      "sql" => "SELECT * FROM `base` WHERE `number` = ? AND `string` = ?",
         *      "param" => "is",
         *      "params" => [$number, $string]
         * )
         */
        public function query($data)
		{
			$num_rows = 0;
			$all = [];
			$all2 = [];
			if(isset($data['param']) && isset($data['params'])) {
				$query = $this->conDb->prepare($data['sql']);
				if($query!==false) {
					$massiv = [$data['param']];
					foreach($data['params'] as $key=>$par)
					{
						$massiv[] = &$data['params'][$key];
					}
					call_user_func_array([$query,'bind_param'],$massiv);
					$query->execute();
					if(isset($query->insert_id) && $query->insert_id>0) {
						$insert_id = $query->insert_id;
						$query->close();
						return $insert_id;
					} else {
						$result = $query->get_result();
						$query->close();
						if($result!==false && $result->num_rows>0) {
							$num_rows = $result->num_rows;
							while($row = $result->fetch_assoc())
							{
								if(!$all) {
									$all = $row;
								}
								$all2[] = $row;
							}
						}
					}
				} else {
					if(file_exists(mError)) {
						$op = fopen(mError,"a");
						fwrite($op,"Database. ".$this->conDb->error.".".date("d.m.Y H:i:s")."\n");
						fclose($op);
					}
				}
			} else {
				$result = $this->conDb->query($data['sql']);
				if(isset($result->num_rows))
				{
					$num_rows = $result->num_rows;
					if($num_rows>0)
					{
						while($row = $result->fetch_assoc())
						{
							if(!$all) {
								$all = $row;
							}
							$all2[] = $row;
						}
					}
					$result->close();
				}
			}
			
			//elem - массив с данными, elems - массив(0 => массив())
			return array("count"=>$num_rows,"elem"=>$all,"elems"=>$all2);
		}
    }
?>