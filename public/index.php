<?php
    session_start();

        require_once __DIR__ . "/../functions/db.php";
        require_once __DIR__ . "/../functions/helpers.php";
    //1. Etablir une connexion avec la base de données
    $_SESSION['crsf_token']= bin2hex(random_bytes(32));

    //2. Effectuer la requête de sélection de tous les films de la base de données .

    $films = getFilms();

    // var_dump($films); die();
?>


<?php $title = "Liste des films"?>
<?php $description = "Découvrez la liste complète de mes films : notes, commentaires et fiches détaillées. Répertoire cinéma mis à jour régulièrement."?>
<?php $keywords = "Cinéma, repertoire, film, dwwm22"?>

<?php include_once __DIR__ ."/../partials/head.php";?>

    <?php include_once __DIR__ ."/../partials/nav.php";?>


    <!-- Main -->
     <main class="container">
        <h1 class="text-center my-3 display-5"> Listes des films</h1>
        <div class="d-flex justify-content-end align-items-center my-3">
            <a href="/create.php" class="btn btn-danger">
                <i class="fa-solid fa-plus"></i>
            Ajouter film</a>
        </div>

        <?php if(isset($_SESSION['success']) && !empty($_SESSION['success'])):?>
            <!-- Affichage flash du message -->
             <div class="text-center alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>
             <?php unset($_SESSION['success']); ?>
        <?php endif?>

            <?php if(count($films) > 0) : ?>


            <div class="container">
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <?php foreach($films as $film) :?>
                            <article class="film-card bg-white p-4 rounded shadow">
                                <h2>Titre:<?= htmlspecialchars($film['title']); ?></h2>
                                <p>Note:<?= isset($film['rating']) && $film['rating'] !== "" ? displayStars((float) htmlspecialchars($film['rating'])) : 'Non renseignée'; ?></p>
                                <hr>
                                <div class="d-flex justify-content-start align-items-center gap-2">
                                    <a href="show.php?film_id=<?= htmlspecialchars($film['id_film']); ?>" class="btn btn-sm btn-dark">Voir détails</a>
                                    <a href="edit.php?film_id=<?= htmlspecialchars($film['id_film']); ?>" class="btn btn-sm btn-secondary">Modifier</a>
                                    <form action="/delete.php" method="post">
                                        <input type="hidden" name="crsf_token" value="<?= htmlspecialchars($_SESSION['crsf_token']);?>">
                                        <input type="hidden" name="honey_pot" value="">
                                        <input type="hidden" name="film_id" value="<?= htmlspecialchars($film['id_film']);?>">
                                        <input type="submit" class="btn btn-sm btn-dark" value="Supprimer"onclick="return confirm('Vous êtes sur de vouloir supprimer ?')">
                                    </form>
                                </div>
                            </article>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            <?php else : ?>
                <p class="mt-5">Aucun film ajouté à la liste.</p>
            <?php endif?>

     </main>

    <?php include_once __DIR__ ."/../partials/footer.php";?>
    
<?php include_once __DIR__ ."/../partials/foot.php";?>