<?php

	class Users
	{
		private $idusers;
		private $login;
		private $password;
		private $role;
		
		function __construct($_idusers, $_login, $_password, $_role)
		{
			$this->idusers = $_idusers;
			$this->login = $_login;
			$this->password = $_password;
			$this->role = $_role;
		}

		public function getIdusers(){ return $this->idusers; }
		public function getLogin(){ return $this->login; }
		public function getPassword(){ return $this->password;}
		public function getRole(){ return $this->role;}

		public static function MYLIST($query){
			$tableau = Array();

			if ($query) {
				while ($i = $query->fetch(PDO::FETCH_OBJ)) {
					$tableau[] = new Users($i->idusers, Chaine::key()->decrypt($i->login), $i->password, Chaine::key()->decrypt($i->role));
				}
				return $tableau;
			}
		}

		public static function seConnecter($login, $password){
			$query = Query::CRUD("SELECT * FROM users WHERE login='$login' AND password='$password'");
			//echo $query;
			//print_r($query)
			return Users::MYLIST($query);

		}

		public function ajouter_users(){
			Query::CRUD("INSERT INTO `users`(`login`, `password`, `role`) VALUES ('$this->login','$this->password','$this->role')");
		}

		public  function getId_users(){
			$query = Query::CRUD("SELECT * FROM users Order by idusers desc ");
			if ($query) {
				while ($i = $query->fetch(PDO::FETCH_OBJ))
                    return $i->idusers;
			}

		}

        public static  function getLogin_users($idusers){
            $query = self::MYLIST(Query::CRUD("SELECT * FROM users WHERE idusers='$idusers' "));
            if ($query) {
                foreach ($query as $i)
                    return $i->getLogin();
            }

        }



	}