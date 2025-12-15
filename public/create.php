<?php
session_start();

//var_dump($_SERVER);
//die();

/*
*TRAITEMENT DES DONN2ES PRVENANT DU FORMULAIRE
*---------------------------------------------
*/

    // 1. Si les données du formulaire sont envoyés via la méthode POST,
        if($_SERVER['REQUEST_METHOD'] === "POST") {

        //Alors,
        // 2. Protéger le serveur contre les failles de sécurité
        // 2a. Les failles de types csrf

            if(!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || 
            empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) ||
            $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                //Effectuer une redirection vers la page de laquelle proviennent les informations puis arrêter l'exécution du script.
                header('Location: create.php');
                die();
            }
            unset($_SESSION['csrf_token']);
            unset($_POST['csrf_token']);

            // die('continuer la partie');

        // 2b. Les robots spammeurs
        // Si le pot de miel n'existe pas ou qu'il est remplie.
        if( !isset($_POST['honey_pot']) || !empty($_POST['honey_pot'])){
            // Effectuer une redirection vers la page de laquelle proviennent les informations puis arrêter l'exécution du script.
            header('Location: create.php');
            die();
        }
        unset($_POST['honey_pot']);

        // die('Continuer la partie');

        // 3. Procéder à la validation des données du formulaire
$formError = [];

        if(isset($_POST['title'])){
            $title = trim($_POST['title']);
            
            if(empty($title)){
                $formError['title']="Le titre est obligatoire.";
            } else if( mb_strlen($title) > 255){
                $formError['title'] = "Le titre ne doit pas dépasser 255 caractères.";
            }
        }

        // var_dump($_POST); die();
        if(isset($_POST['rating']) && $_POST['rating'] !== "") {
            $rating = trim($_POST['rating']);

            if (!is_numeric($rating)) {
                $formError['rating'] = "La note doit être un nombre.";
            } else if (floatval($rating) < 0 || floatval($rating) > 5){
                $formError['rating'] = "La note doit être comprise entre 0 et 5.";
            }
        }
        if(isset($_POST['comment']) && $_POST['comment'] !== ""){
            $comment = trim($_POST['comment']);
            if(mb_strlen($comment) > 1000){
                $formError['comment'] = "Le commentaire ne doit pas dépasser 1000 caractères.";
            }
        }

        // 4. S'il existe au moins une erreur détectée par le système,
        if(count($formError)>0){

          // Alors,

            // 4a. Sauvegarder les messages d'erreurs en session, pour affichage à l'écran de l'utilisateur
            $_SESSION['form_errors'] = $formError;

            // 4b. Sauvegarder les anciennes données provenant du formulaire en session

            //Effectuer une redirection vers la page de laquelle proviennent les informations
            //Puis arrêter l'exécution du script.
            header('Location: create.php');
            die();
        }
        // 5. Dans le cas contraire,
        //5a. Arrondir la note à un chiffre après la virgule,

        //6. Etablir une connexion avec la base de données

        //7. Effectuer la requête d'insertion du nouveau film dans la table prévue "film"

        //8. Générer le message flash de succès

        //9. Effectuer une redirection vers la page listant les films ajoutés (index.php)
        // Puis arrêter l'exécution du script.
        }
       
        // Générons et sauvegardons le jeton de sécurité en session
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

?>

<?php $title = "Fiiiiiilm"?>
<?php $description = "Ouaip, des s*** une robe les cheveux long... un film"?>
<?php $keywords = "Mais la flèche d'or en plein coeur c'est normal ?"?>

<?php include_once __DIR__ ."/../partials/head.php";?>

    <?php include_once __DIR__ ."/../partials/nav.php";?>


    <!-- Main -->
     <main class="container">
        <h1 class="text-center my-3 display-5">Nouveau Film</h1>

        <!-- Formulaire d'ajout d'un nouveau film -->
         <div class="container mt-5">
            <div class="row">
                <div class="col-md-8 col-lg-6 mx-auto p-4 bg-white shadow rounded">

                    <?php if(isset($_SESSION['form_errors']) && !empty($_SESSION['form_errors'])) : ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach($_SESSION['form_errors'] as $error) : ?>
                                    <li><?= $error;?></li>
                                <?php endforeach ?>
                                <?php unset($_SESSION['form_errors']);?>
                            </ul>
                        </div>
                    <?php endif ?>
                    <form method="post">
                        <div class="mb-3">
                            <label for="title">Titre <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" autofocus required>
                        </div>
                        <div class="mb-3">
                            <label for="rating">Note / 5</label>
                            <input type="text" min="0" max="5" step=".5" inputmode="decimal" name="rating" id="rating" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="comment">laissez un commentaire</label>
                            <textarea name="comment" id="comment" class="form-control" rows="4"></textarea>
                        </div>
                        
                        <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token'];?>">
                        <input type="hidden" name="honey_pot" value="">
                        
                        <div>
                            <input formnovalidate type="submit" value="Ajouter" class="btn btn-danger shadow">
                        </div>
                    </form>
                </div>
            </div>
         </div>

     </main>

    <?php include_once __DIR__ ."/../partials/footer.php";?>
    
<?php include_once __DIR__ ."/../partials/foot.php";?>