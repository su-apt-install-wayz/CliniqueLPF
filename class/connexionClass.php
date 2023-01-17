<?php
    class Connexion {

        private $erreur;
        private $valid;

        public function connexion_user($identifiant, $password) {

            global $DB;

            $identifiant = (String) trim($identifiant);
            $password = (String) trim($password);

            $this->erreur = (String) "";
            $this->valid = (boolean) true;

            if($this->valid) {
                $verif_password = $DB->prepare("SELECT password FROM utilisateurs WHERE pseudo = ?");
                $verif_password->execute(array($identifiant));
                $verif_password = $verif_password->fetch();

                if(isset($verif_password['password'])) {
                    if(!password_verify($password, $verif_password['password'])) {
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
                    $connexion = $DB->prepare("SELECT * FROM utilisateurs WHERE pseudo = ?");
                    $connexion->execute(array($identifiant));
                    $connexion = $connexion->fetch();

                    if(isset($connexion['id'])) {
                        $_SESSION['utilisateur'] = array(
                            $connexion['id'], //0
                            $connexion['pseudo'], //1
                            $connexion['nom'], //2
                            $connexion['prenom'], //3
                            $connexion['localisation'], //4
                            $connexion['biographie'], //5
                            $connexion['email'], //6
                            $connexion['avatar'], //7
                            $connexion['banniere'], //8
                            $connexion['add-friend'], //9
                            $connexion['show-loca'], //10
                            $connexion['rang']); //11

                        header('Location: ./pages/panel.php');
                        exit;
                    }
                }
            }

            return [$this->erreur];
        }
    }
?>