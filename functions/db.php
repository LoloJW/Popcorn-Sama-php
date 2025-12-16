<?php
/**
 * Cette fonction permet d'établir une connexion avec la base de données.
 *
 * @return PDO
 */
function connectToDb(): PDO {


    $dsnDb = 'mysql:dbname=popcornsama;host=127.0.0.1';
    $userDb = 'root';
    $passwordDb = '';

    try {
        $db = new PDO($dsnDb, $userDb, $passwordDb);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
        die("Connection to database failed: ".$e->getMessage());
    }
    return $db;
}

/**
 * Cette fonction permet d'insérer un nouveau film en base de données.
 *
 * @param float|null $ratingRounded
 * @param array $data
 * @return void
 */
function insertFilm(?float $ratingRounded,array $data = []):void {
      
      //Etablissons une connexion à la base de données.
      $db = connectToDb();

      //Préparons la requête à exécuter
      $req=$db -> prepare("INSERT INTO film (title, rating, comment, created_at, updated_at) VALUES (:title, :rating, :comment, now(), now() )");

      //Passons à la requête, les données necessaires
      $req->bindValue("title", $data['title']);
      $req->bindValue("rating", $ratingRounded);
      $req->bindValue("comment", $data['comment']);

      // Exécutons la requête
      $req->execute();

      //Fermons le curseur, c'est à dire la connexion à la base de données.
      $req->closeCursor();
}
/**
 * Cette fonction permet d récupérer tous les films de la base de données.
 *
 * @return array
 */
function getFilms(): array{
    $db = connectToDb();

    try{
        $req = $db->prepare("SELECT * FROM film");
        $req->execute();
        $films = $req->fetchAll();
        $req->closeCursor();
    } catch(\PDOException $exception)  {
        throw $exception;
    }
    return $films;
}
