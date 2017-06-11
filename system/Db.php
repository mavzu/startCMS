<?php
    namespace system;
    
    Final class Db
    {
        private $host = "localhost";
        private $username = "root";
        private $password = "root";
        private $dbname = "test";
        private $port = 3306;
        private $conDb;
       
        //Соединение с БД MySQLi
        public function __construct()
        {
			$conDb = new \mysqli($this->host, $this->username, $this->password, $this->dbname, $this->port);
            
            //Если ошибка, то запись в лог
			/*if (mysqli_connect_errno()) {
				if(file_exists("")) {
					$op = fopen("","a");
					fwrite($op,"SystemDbConnect. Не подключиться к MySQL.".date("d.m.Y H:i:s")."\n");
					fclose($op);
				}
				exit(); 
			}*/
				
            //Настраиваем БД для работы с UTF-8
			$conDb->query("SET NAMES 'utf-8'");
			$conDb->query("SET CHARACTER SET utf8");
			$conDb->query("SET CHARACTER_SET_CONNECTION=utf8");
			
			$this->conDb = $conDb;
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
				if($query !== false) {
					$massiv = [$data['param']];
					foreach($data['params'] as $key => $par)
					{
						$massiv[] = &$data['params'][$key];
					}
					call_user_func_array([$query, 'bind_param'], $massiv);
					$query->execute();
					if(isset($query->insert_id) && $query->insert_id > 0) {
						$insert_id = $query->insert_id;
						$query->close();
						return $insert_id;
					} else {
						$result = $query->get_result();
						$query->close();
						if($result !== false && $result->num_rows > 0) {
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
					/*if(file_exists("")) {
						$op = fopen("","a");
						fwrite($op,"SystemDbQuery. ".$this->conDb->error.".".date("d.m.Y H:i:s")."\n");
						fclose($op);
					}*/
				}
			} else {
				$result = $this->conDb->query($data['sql']);
				if(isset($result->num_rows)) {
					$num_rows = $result->num_rows;
					if($num_rows > 0) {
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
			return ["count" => $num_rows, "elem" => $all, "elems" => $all2];
		}
    }
?>