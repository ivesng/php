<?php

	/**
	 * 
	 */
	class Query
	{
		
		public static function CRUD($query){
			$con = Connexion::GetConnexion();
	        $re = $con->prepare($query);
	        $re->execute();
	        if ($re) return $re;

		}

	 public static function securisation($donnees){
        $donnees = htmlspecialchars($donnees);
        $donnees = trim($donnees);
        $donnees = stripslashes($donnees);
        $donnees = strip_tags($donnees);

        return $donnees;
    }

    public static function textArea($donnees)
    {
        $donnees = htmlspecialchars($donnees);
        $donnees = stripslashes($donnees);
        $donnees = strip_tags($donnees);
        return $donnees;
    }

    public static function validateur_email($email_new){
        $email = filter_var($email_new, FILTER_SANITIZE_EMAIL);
        if (filter_var($email_new, FILTER_VALIDATE_EMAIL) == true) {
            if($email_new != $email){
                return $email_new;
            }
            else{
                return $email;
            }

        }
	}

    public static function OuvertFileZip($zipfil){
        $zip = zip_open('assets/picture/'.str_replace(substr($zipfil,-3),'zip',$zipfil));
            
        if ($zip) {
           $zip_entry = zip_read($zip);
            return zip_entry_name($zip_entry);
            zip_close($zip);

        }

    }

    public static function zipFile($nameFold)
    {

        $zip = new ZipArchive();
        $filename = str_replace(substr($nameFold,-3),'zip',$nameFold);

        if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
            exit("Impossible d'ouvrir le fichier <$filename>\n");
        }

        $zip->addFile($nameFold);
        $zip->close();

    }

    public static function deleteFile($dossier, $extension_choisi, $age_requis)
    {
        // on ouvre le dossier
        $repertoire = opendir($dossier);
        // On lance notre boucle qui lira les fichiers un par un 
        while (false !== ($fichier = readdir($repertoire))) {
            // on met le chemin du fichier dans une variable simple
            $chemin  = $dossier.'/'.$fichier;

            // Les variables qui contiennent toutes les infos necessaires.
            $infos = pathinfo($chemin);
            $extension = $infos['extension'];
            $age_fichier = time() - filemtime($chemin);

            //On n'oublie pas la condition sous peine d'avoir quelques surprises

            if ($fichier != '.' AND $fichier != '..' AND !is_dir($fichier) AND $extension == $extension_choisi AND $age_fichier > $age_requis) {
                unlink($chemin);
            }
        }
       // echo 'ok';
        closedir($repertoire); // on ferme le repertoire

    }

    public static function dezipper($dossier)
    {
        $zip = new ZipArchive();
        $path = '.';
        $file = ('assets/archivage/'.str_replace(substr($dossier,-3),'zip',$dossier));
        $res = $zip->open($file);
        if ($res === TRUE) {
            // code...
            $zip->extractTo($path);
            $zip->close();

            
        }
    }

}