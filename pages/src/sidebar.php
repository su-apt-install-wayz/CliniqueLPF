<?php
    include_once('info_user.php');
?>

    <aside>
        <div class="titre">
            <h1>Clinique<span class="degrade"> LPF</span></h1>
        </div>
        <ul class="list">

        <?php
            if($rang_utilisateur[0]==1) {
        ?>

            <li class="list-item">
                <a href="panel.php">
                    <div class="icon">
                        <span class="material-symbols-rounded">person_add</span>
                    </div>
                    <div class="lien">
                        <p>Pré-admission</p>
                    </div>
                </a>
            </li>
            <li class="list-item">
                <a href="#">
                    <div class="icon">
                        <span class="material-symbols-rounded">edit_note</span>
                    </div>
                    <div class="lien">
                        <p>Modifier admission</p>
                    </div>
                </a>
            </li>

        <?php
            }
        ?>

        <?php
            if($rang_utilisateur[0]==2) {
        ?>
        
            <li class="list-item">
                <a href="#">
                    <div class="icon">
                        <span class="material-symbols-rounded">query_stats</span>
                    </div>
                    <div class="lien">
                        <p>Statistiques</p>
                    </div>
                </a>
            </li>
        <?php
            }
        ?>

        <?php
            if($rang_utilisateur[0]==3) {
        ?>

            <li class="list-item">
                <a href="#">
                    <div class="icon">
                        <span class="material-symbols-rounded">person</span>
                    </div>
                    <div class="lien">
                        <p>Ajouter un personnel</p>
                    </div>
                </a>
            </li>

            <li class="list-item">
                <a href="#">
                    <div class="icon">
                        <span class="material-symbols-rounded">person</span>
                    </div>
                    <div class="lien">
                        <p>Ajouter un service</p>
                    </div>
                </a>
            </li>

        <?php
            }
        ?>
            <!-- <li class="list-item">
                <a href="#">
                    <div class="icon">
                        <span class="material-symbols-rounded">settings</span>
                    </div>
                    <div class="lien">
                        <p>Paramètres</p>
                    </div>
                </a>
            </li> -->
            <li class="list-item btn-deco">
                <a href="deconnexion.php">
                    <div class="icon">
                        <span class="material-symbols-rounded">logout</span>
                    </div>
                    <div class="lien">
                        <p>Déconnexion</p>
                    </div>
                </a>
            </li>
        </ul>
    </aside>