<?php
    class Inscription {
        private $erreur;
        private $banner;
        private $valid;

        public function inscription_user($nom, $prenom, $identifiant, $code, $password, $role) {
            global $DB;

            $nom = (String) trim($nom);
            $prenom = (String) trim($prenom);
            $identifiant = (String) trim($identifiant);
            $service = (String) trim($code);
            $password = (String) trim($password);
            $role = (String) trim($role);

            $this->erreur = (String) "";

            $this->valid = (boolean) true;

            

            if(isset($identifiant)) {
                $verif = $DB->prepare("select Code_personnel from personnel where Identifiant = ?");
                $verif->execute(array($identifiant));
                $verif=$verif->fetch();

                if(isset($verif['Code_personnel'])) {
                    $this->valid = false;
                    $this->erreur = '<ul class="notifications">
                                        <li class="toast error">
                                            <div class="column">
                                                <span class="material-icons-round icon-notif">error</span>
                                                <span class="message-notif">Cet identifiant existe déjà.</span>
                                            </div>
                                            <span class="material-icons-outlined icon-notif close" onclick="remove()">close</span>
                                        </li>
                                    </ul>
                                    <script>
                                        const toast = document.querySelector(".toast");
                        
                                        function hideToast() {
                                            setTimeout(function() {
                                                toast.classList.add("hide")
                                            }, 5000);
                                        }
                        
                                        function remove() {
                                            toast.classList.add("hide");
                                        }
                        
                                        hideToast();
                                    </script>';
                }

                if($this->valid) {
                    $crypt_password = password_hash($password, PASSWORD_ARGON2ID);

                    $insert_user = $DB->prepare("INSERT INTO personnel (Nom, Prenom, Identifiant, Mot_de_passe, Service, role) VALUES(?, ?, ?, ?, ?, ?)");
                    $insert_user->execute(array($nom, $prenom, $identifiant, $crypt_password, $service, $role));
                    
                }
            }

            return [$this->erreur];
        }
    }
?>