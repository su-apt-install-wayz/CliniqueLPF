<?php
    class Inscription {
        private $erreur;
        private $banner;
        private $valid;

        public function inscription_user($identifiant, $mail, $password) {
            global $DB;

            $identifiant = (String) trim($identifiant);
            $mail = (String) trim($mail);
            $password = (String) trim($password);

            $this->erreur = (String) "";
            $this->banner = (String) "";

            $this->valid = (boolean) true;

            if(isset($identifiant)) {
                $verif = $DB->prepare("select Code_personnel from personnel where Identifiant = ?");
                $verif->execute(array($identifiant));
                $verif=$verif->fetch();

                if(isset($verif['Code_personnel'])) {
                    $this->valid = false;
                    $this->erreur = "Ce pseudo est déjà pris.";
                }

                if($this->valid) {
                    $crypt_password = password_hash($password, PASSWORD_ARGON2ID);

                    $insert_user = $DB->prepare("INSERT INTO personnel (Nom, Identifiant, Mot_de_passe, role) VALUES(?, ?, ?, 'secretaire')");
                    $insert_user->execute(array($identifiant, $identifiant, $crypt_password));
                    
                }
            }

            return [$this->erreur];
        }
    }
?>