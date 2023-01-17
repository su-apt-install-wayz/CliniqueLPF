<?php
    include_once('info_user.php');
?>

    <aside>
        <div class="titre">
            <h1>Doc<span class="degrade">Tur</span></h1>
        </div>
        <ul class="list">

        <?php
            if($rang_utilisateur[0]==1) {
        ?>

            <li class="list-item">
                <a href="panel.php">
                    <div class="icon">
                        <span class="material-symbols-rounded">dashboard</span>
                    </div>
                    <div class="lien">
                        <p>Pré-admission</p>
                    </div>
                </a>
            </li>
            <li class="list-item">
                <a href="#">
                    <div class="icon">
                        <span class="material-symbols-rounded">star</span>
                    </div>
                    <div class="lien">
                        <p>Modifier pré-admission</p>
                    </div>
                </a>
            </li>

        <?php
            }
        ?>
        
            <li class="list-item">
                <a href="#">
                    <div class="icon">
                        <span class="material-symbols-rounded">person</span>
                    </div>
                    <div class="lien">
                        <p>Statistiques</p>
                    </div>
                </a>
            </li>
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