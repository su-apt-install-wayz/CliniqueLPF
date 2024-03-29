<?php
    class Inscription {
        private $erreur;
        private $banner;
        private $valid;

        public function inscription_user($nom, $prenom, $identifiant, $service, $password, $role, $naissance) {
            global $DB;

            $nom = (String) trim($nom);
            $prenom = (String) trim($prenom);
            $identifiant = (String) trim($identifiant);
            $service = (String) trim($service);
            $password = (String) trim($password);
            $role = (String) trim($role);
            $naissance = trim($naissance);

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

                $personnel_existant = $DB->prepare("select * from personnel where Nom = ? and Prenom = ?");
                $personnel_existant->execute(array($nom, $prenom));
                $personnel_existant=$personnel_existant->fetch();

                if ($naissance == $personnel_existant['date_naissance']) {
                    $this->valid = false;
                    $this->erreur = '<ul class="notifications">
                                        <li class="toast error">
                                            <div class="column">
                                                <span class="material-icons-round icon-notif">error</span>
                                                <span class="message-notif">Personnel existant né à la même date.</span>
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

                    $insert_user = $DB->prepare("INSERT INTO personnel (Nom, Prenom, Identifiant, Mot_de_passe, Service, role, date_naissance) VALUES(?, ?, ?, ?, ?, ?, ?)");
                    $insert_user->execute(array($nom, $prenom, $identifiant, $crypt_password, $service, $role, $naissance));
                    
                    $this->erreur = '<ul class="notifications">
                                        <li class="toast success">
                                            <div class="column">
                                                <span class="material-icons-round icon-notif">check_circle</span>
                                                <span class="message-notif">Personnel créé avec succès.</span>
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
            }

            return [$this->erreur];
        }
    }
?>