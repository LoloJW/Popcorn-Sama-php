<?php
session_start();
require_once __DIR__ . "/../functions/db.php";
require_once __DIR__ . "/../functions/helpers.php";

//1. Si l'identifiant du filme envoyé dans la barre d'url n'existe pas, 
    if(!isset($_GET['film_id']) || empty($_GET['film_id'])){
        //   Puis arrêter l'exécution du script.
        //  alors effectuer une redirection vers la page index
        header("Location: index.php");
        die();
    }

//2. Dans le cas contaire,
//  Récupérer l'identifiant du film depuis la barre d'URL,
//  S'assurer de protéger le serveur contre les failles xss
    $filmId = (int) htmlspecialchars($_GET['film_id']);

//3. Etablir une connexion avec la base de données
//   Afin de vérifer si l'identifiant correspond à un film qui existe vraiment
$film = getFilm($filmId);

//4. Si ce n'est pas le cas,
if (false === $film) {
    //Alors, effectuer une redirection vers la page index
    //Puis, arrêter l'exécution du script.
    header ("Location: index.php");
    die();
}
$_SESSION['crsf_token'] = bin2hex(random_bytes(32));
?>
<?php $title = "Détails des films"?>
<?php $description = "DETAILS !!!"?>
<?php $keywords = "Cinéma, repertoire, film, dwwm22, DETAAAAAAIL!!!!!"?>

<?php include_once __DIR__ ."/../partials/head.php";?>

    <?php include_once __DIR__ ."/../partials/nav.php";?>


    <!-- Main -->
     <main class="container">
        <h1 class="text-center my-3 display-5"> Les détails de ce film</h1>

        <div>
            <small>
                Ajouté le <?= (new DateTime($film['created_at']))->format('d/m/Y \à H:i:s'); ?>
            </small>
            <br>
            <small>
              <?php if(isset($film['updated_at']) && !empty($film['updated_at'])) : ?>
                        Modifié le <?= (new DateTime($film['updated_at']))->format('d/m/Y \à H:i:s'); ?>
                    <?php endif ?>
            </small>
        </div>
    
        <article class="film-card bg-white p-4 rounded shadow">
            <h2>Titre:<?= htmlspecialchars($film['title']); ?></h2>
            <p>Note:<?= isset($film['rating']) && $film['rating'] !== "" ? displayStars((float) htmlspecialchars($film['rating'])) : 'Non renseignée'; ?></p>
            <p>Commentaire: <?=isset($film['comment']) && $film['comment'] !== "" ? htmlspecialchars($film['comment']) : 'Non renseigné'; ?></p>
            <hr>
            <div class="d-flex justify-content-start align-items-center gap-2">
                <a href="edit.php?film_id=<?= htmlspecialchars($film['id_film']); ?>" class="btn btn-sm btn-secondary">Modifier</a>
                <form action="/delete.php" method="post">
                    <input type="hidden" name="crsf_token" value="<?= htmlspecialchars($_SESSION['crsf_token']);?>">
                    <input type="hidden" name="honey_pot" value="">
                    <input type="hidden" name="film_id" value="<?= htmlspecialchars($film['id_film']);?>">
                    <input type="submit" class="btn btn-sm btn-dark" value="Supprimer"onclick="return confirm('Vous êtes sur de vouloir supprimer ?')">
                </form>
            </div>
        </article>

     </main>

    <?php include_once __DIR__ ."/../partials/footer.php";?>
    
<?php include_once __DIR__ ."/../partials/foot.php";?>