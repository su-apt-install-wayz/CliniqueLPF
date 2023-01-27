<?php
    class Connexion {

        private $erreur;
        private $valid;

        public function connexion_user($identifiant, $password) {

            global $DB;

            $identifiant = (String) htmlspecialchars(trim($identifiant));
            $password = (String) htmlspecialchars(trim($password));

            $this->erreur = (String) "";
            $this->valid = (boolean) true;

            
            if($this->valid) {
                $verif_password = $DB->prepare("SELECT Mot_de_passe FROM personnel WHERE Identifiant = ?");
                $verif_password->execute(array($identifiant));
                $verif_password = $verif_password->fetch();

                if(isset($verif_password['Mot_de_passe'])) {
                    if(!password_verify($password, $verif_password['Mot_de_passe'])) {
                        $this->valid = false;
                        $this->erreur = '
                        <ul class="notifications">
                            <li class="toast error">
                                <div class="column">
                                    <span class="material-icons-round icon-notif">error</span>
                                    <span class="message-notif">Mot de passe incorrect.</span>
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
                } else {
                    $this->valid = false;
                    $this->erreur = '
                    <ul class="notifications">
                        <li class="toast error">
                            <div class="column">
                                <span class="material-icons-round icon-notif">error</span>
                                <span class="message-notif">Aucun utilisateur avec ce pseudo</span>
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
                    $connexion = $DB->prepare("SELECT * FROM personnel WHERE Identifiant = ?");
                    $connexion->execute(array($identifiant));
                    $connexion = $connexion->fetch();

                    if(isset($connexion['Code_personnel'])) {
                        $_SESSION['personnel'] = array(
                            $connexion['Code_personnel'], //0
                            $connexion['Nom'], //1
                            $connexion['Identifiant'], //2
                            $connexion['Mot_de_passe'], //3
                            $connexion['Service'], //4
                            $connexion['role'],); //5

                        header('Location: pages/panel');
                        exit;
                    }
                }
            }

            return [$this->erreur];
        }
    }
?>