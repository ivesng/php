<?php 

/**
 * 
 */
class Chaine
{
	private $id;
	private $nom;
	private $adresse;
	private $logo;
	private $description;
	private $phone;
	private $email;
	private $frequence_fm;
	private $frequence_uhf;
	private $idusers;

	
	function __construct($_id, $_nom, $_adresse, $_logo, $_description, $_phone, $_email, $_frequence_fm, $_frequence_uhf, $_idusers)
	{
		$this->id = $_id;
		$this->nom = $_nom;
		$this->adresse = $_adresse;
		$this->logo = $_logo;
		$this->description = $_description;
		$this->phone = $_phone;
		$this->email = $_email;
		$this->frequence_fm = $_frequence_fm;
		$this->frequence_uhf = $_frequence_uhf;
		$this->idusers = $_idusers;

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
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getFrequenceFm()
    {
        return $this->frequence_fm;
    }

    /**
     * @return mixed
     */
    public function getFrequenceUhf()
    {
        return $this->frequence_uhf;
    }

    /**
     * @return mixed
     */
    public function getIdusers()
    {
        return $this->idusers;
    }

    public static function key(){
        return new AES("uwiewlkncfdddaaaaaaaaaaaaaav89938&&&&#%@^^!%!$%%@^^!%%%@%@@");
    }



	public static function MYLIST($query){
			$tableau = Array();
            $key = self::key();
			if ($query) {
				while ($i = $query->fetch(PDO::FETCH_OBJ)) {
					$tableau[] = new Chaine($i->id, $key->decrypt($i->nom), $key->decrypt($i->adresse), $key->decrypt($i->logo), $key->decrypt($i->description), $key->decrypt($i->phone), $key->decrypt($i->email), $key->decrypt($i->frequence_fm), $key->decrypt($i->frequence_uhf), $i->idusers);
				}
				return $tableau;
			}
		}


	public function ajouter_chaine(){
		Query::CRUD("INSERT INTO `chaine`( `nom`, `adresse`, `logo`, `description`, `phone`, `email`, `frequence_fm`, `frequence_uhf`, `idusers`) VALUES ('$this->nom ','$this->adresse','$this->logo','$this->description','$this->phone','$this->email','$this->frequence_fm','$this->frequence_uhf','$this->idusers')");
	}

    public function modifier(){
        Query::CRUD("UPDATE `chaine` SET `nom`='$this->nom',`adresse`='$this->adresse',`phone`='$this->phone',`frequence_fm`='$this->frequence_fm',`frequence_uhf`='$this->frequence_uhf' WHERE `id`='$this->id'");
    }


	public static function AFFICHER_ID($id){
		$query = Query::CRUD("SELECT * FROM chaine WHERE id='$id'");
			return self::MYLIST($query);

	}
	public static function AFFICHER(){
		$query = Query::CRUD("SELECT * FROM chaine");
			return self::MYLIST($query);

	}

    public static function AFFICHER_PHOTO($id){
        $query = self::MYLIST(Query::CRUD("SELECT * FROM chaine WHERE idusers='$id'"));
        if ($query){
            foreach ($query as $i){
                return $i->getLogo();
            }

        }


    }

    public static function AFFICHER_CHAINE_ABONN(){
     return  Chaine::MYLIST(Query::CRUD("SELECT * FROM chaine WHERE idusers NOT IN( '".$_SESSION['idusers']."')"));
    }

    public static function chaineNom($id){
        $query = self::MYLIST(Query::CRUD("SELECT * FROM chaine WHERE idusers='$id'"));
        if ($query)
        {
            foreach ($query As $i)
                return $i->getNom();
        }
    }

    public static function chaineLogo($id){
        $query = self::MYLIST(Query::CRUD("SELECT * FROM chaine WHERE idusers='$id'"));
        if ($query)
        {
            foreach ($query As $i)
                return $i->getLogo();
        }
    }



}