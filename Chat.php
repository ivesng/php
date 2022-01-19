<?php

    class Chat{
        private $id;
        private $idexp;
        private $idrec;
        private $msg;
        private $date;

        function __construct($_id, $_idexp, $_idrec, $_msg, $_date)
        {
            $this->id = $_id;
            $this->idexp = $_idexp;
            $this->idrec = $_idrec;
            $this->msg = $_msg;
            $this->date = $_date;
        }

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @return mixed
         */
        public function getIdexp()
        {
            return $this->idexp;
        }

        /**
         * @return mixed
         */
        public function getIdrec()
        {
            return $this->idrec;
        }

        /**
         * @return mixed
         */
        public function getMsg()
        {
            return $this->msg;
        }

        /**
         * @return mixed
         */
        public function getDate()
        {
            return $this->date;
        }
        public static function key(){
            return new AES("uwiewlkncfdddaaaaaaaaaaaaaav89938&ddbbdvfdmmd##!#%@&&&#%@^^!%!$%%@^^!%%%@%@@");
        }

        public static function MyList($query)
        {
            $tab = Array();
            if ($query){
                while ($i = $query->fetch(PDO::FETCH_OBJ))
                    $tab[] = new Chat($i->id, $i->idexp, $i->idrec, self::key()->decrypt($i->msg), $i->date);
                return $tab;
            }

        }

        public static function Afficher($id){
            return self::MyList(Query::CRUD("SELECT * FROM `chat` WHERE `idrec`='$id' AND idexp IN (SELECT idusers FROM chaine)"));
        }

        public static function Affichers($id){
            $idusers = $_SESSION['idusers'];
            return self::MyList(Query::CRUD("SELECT * FROM `chat` WHERE (`idrec`='$id' AND `idexp`='$idusers') OR (`idrec`='$idusers' AND `idexp`='$id')"));
        }


        public function ajouter(){
            Query::CRUD("INSERT INTO `chat`(`idexp`, `idrec`, `msg`) VALUES ('$this->idexp','$this->idrec','$this->msg')");
        }

    }