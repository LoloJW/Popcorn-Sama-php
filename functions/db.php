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
        $req = $db->prepare("SELECT * FROM film ORDER BY created_at DESC");
        $req->execute();
        $films = $req->fetchAll();
        $req->closeCursor();
    } catch(\PDOException $exception)  {
        throw $exception;
    }
    return $films;
}

function getFilm(int $filmId): false|array {
    $db = connectToDb();

    try{    
        $req = $db->prepare("SELECT * FROM film WHERE id_film=:id");
        $req ->bindValue(":id", $filmId);

        $req->execute();
        $film = $req->fetch();
        $req->closeCursor();
        }
        catch(\PDOException $e){
            throw $e;
        }
        return $film;
    }
/**
 * Cette fonction permet de mettre à jour un film dans la base de données
 *
 * @param null|float $ratingRounded
 * @param integer $filmId
 * @param array $data
 * @return void
 */
    function updateFilm(null|float $ratingRounded, int $filmId, array $data = []) :void {
        $db = connectToDb();
        try
        {
        $req = $db->prepare("UPDATE film SET title=:title, rating=:rating, comment=:comment, updated_at=now() WHERE id_film=:id");

        $req->bindValue(":title", $data['title']);
        $req->bindValue(":rating", $ratingRounded);
        $req->bindValue(":comment", $data['comment']);
        $req->bindValue(":id", $filmId);

        $req->execute();
        $req->closeCursor();
        } catch (\PDOException $e){
            throw $e;
        }
    }

    function deleteFilm(int $filmId): void {
        $db = connectToDb();
     
        try{
        $req = $db->prepare("DELETE FROM film WHERE id_film=:id");
        $req->bindValue(":id", $filmId);
        $req->execute();
        $req->closeCursor();
        } catch (\PDOException $exception) {
            throw $exception;
        }
    }