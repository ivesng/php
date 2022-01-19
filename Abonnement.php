<?php

class Abonnement
{
    private $id;
    private $idusers;
    private $idchaine;
    private $status;
    private $date;

    /**
     * @param $id
     * @param $idusers
     * @param $idchaine
     * @param $status
     * @param $date
     */
    public function __construct($id, $idusers, $idchaine, $status, $date)
    {
        $this->id = $id;
        $this->idusers = $idusers;
        $this->idchaine = $idchaine;
        $this->status = $status;
        $this->date = $date;
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
    public function getIdusers()
    {
        return $this->idusers;
    }

    /**
     * @return mixed
     */
    public function getIdchaine()
    {
        return $this->idchaine;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }




    public static function toDoList($query){
        $tab = Array();
        if ($query){
            while ($i = $query->fetch(PDO::FETCH_OBJ))
                $tab[] = new Abonnement($i->id, $i->idusers, $i->idchaine, $i->status, $i->date);
            return $tab;
        }
    }


   public function ajouter(){
        Query::CRUD("INSERT INTO `abonnement`(`idusers`, `idchaine`, `status`) VALUES ('$this->idusers','$this->idchaine','$this->status')");
   }

   public static function status($idchaine){
        $id = $_SESSION['idusers'];
        $query = self::toDoList(Query::CRUD("SELECT * FROM `abonnement` WHERE (idusers='$id' AND idchaine='$idchaine')  OR  (idusers='$idchaine' AND idchaine='$id')"));
        if ($query){
            foreach ($query as $i){
                return $i->getStatus();
            }
        }else
            return 2;
   }


   public static function confirmer($idchaine){
        Query::CRUD("UPDATE abonnement SET status=1 WHERE idchaine='".$_SESSION['idusers']."' AND idusers='$idchaine'");
   }
   
   public static function existChaine($idchaine){
        $id = $_SESSION['idusers'];
        $query = self::toDoList(Query::CRUD("SELECT * FROM `abonnement` WHERE ((idusers='$id' AND idchaine='$idchaine')  OR  (idusers='$idchaine' AND idchaine='$id')) AND status=1"));
        if ($query){
            foreach ($query as $i){
                return true;
            }
        }else
            return false;
    }
    
      public static function count($idusers){
        $j = 0;
        $query = Query::CRUD("SELECT * FROM abonnement WHERE idusers='$idusers' OR idchaine='$idusers'");
        if ($query){
            while($i = $query->fetch(PDO::FETCH_OBJ))
                $j++;
            return $j;



        }
    }

}