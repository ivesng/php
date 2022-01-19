<?php

class Fichier
{
    private $id;
    private $myfichier;
    private $date;
    private $type;
    private $idchaine;
    private $titre;

    /**
     * @param $id
     * @param $myfichier
     * @param $date
     * @param $type
     * @param $idchaine
     */
    public function __construct($id, $titre,$myfichier, $date, $type, $idchaine)
    {
        $this->id = $id;
        $this->myfichier = $myfichier;
        $this->date = $date;
        $this->type = $type;
        $this->idchaine = $idchaine;
        $this->titre = $titre;
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
    public function getMyfichier()
    {
        return $this->myfichier;
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
    public function getType()
    {
        return $this->type;
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
    public function getTitre()
    {
        return $this->titre;
    }



    public static function key(){
        return new AES("JDDDDDDDDDDDDDDDDDDDDDDDDDndnccueiue9876527867$$$####@((@");
    }

    public static function toDoList($query){
        $tab = Array();

        if ($query){
            while ($i = $query->fetch(PDO::FETCH_OBJ))
                $tab[] = new Fichier($i->id, self::key()->decrypt($i->titre),self::key()->decrypt($i->myfichier), $i->date, self::key()->decrypt($i->type), $i->idchaine);
            return $tab;
        }
    }

    public static function Afficher(){
        return self::toDoList(Query::CRUD("SELECT * FROM `fichier`"));
    }

    public function ajouter(){
        Query::CRUD("INSERT INTO `fichier`(`titre`,`myfichier`,`type`, `idchaine`) VALUES ('$this->titre','$this->myfichier','$this->type','$this->idchaine')");
    }

    public static function getVideo($id){
        $query = self::toDoList(Query::CRUD("SELECT * FROM fichier WHERE id='$id'"));
        if ($query){
            foreach ($query as $i){
                return $i->getMyfichier();
            }
        }
    }
    
      public static function countFichier($idchaine){
        $j = 0;
        $query = Query::CRUD("SELECT * FROM fichier WHERE idchaine='$idchaine'");
        if ($query){
            while ($i = $query->fetch(PDO::FETCH_OBJ))
                $j++;
            return $j;

        }


    }
public static function fileAbonnement(){
        $myID = $_SESSION['idusers'];
        $users = Chaine::MYLIST(Query::CRUD("SELECT * FROM chaine WHERE idusers != '$myID'"));
        $tab = Array();
        if ($users){
            foreach ($users as $i){
                if (Abonnement::existChaine($i->getIdusers())){
                    $id = $i->getIdusers();
                    $tampo = self::toDoList(Query::CRUD("SELECT * FROM fichier WHERE idchaine='$id'"));
                    if ($tampo){
                        foreach ($tampo as $j)
                            $tab[] = new Fichier($j->getId(), $j->getTitre(), $j->getMyfichier(), $j->getDate(), $j->getType(), $j->getIdchaine());
                    }
                }

            }
            return $tab;
        }
    }

    public static function delete($id){
        Query::CRUD("DELETE FROM fichier WHERE id='$id'");
    }

}