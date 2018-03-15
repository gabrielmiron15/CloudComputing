<?php
function databaseGet($condition = '-1', $tableName = 'filme')
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tema2CC";
    $results = [];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = ($condition == '-1') ? "SELECT * from $tableName where 1" : "SELECT * from $tableName where $condition";
        $results = $conn->query($sql);
    } catch (PDOException $e) {
    }
    $conn = null;
    return  $results->fetchAll();
}

function databasePost($nume, $categorie, $descriere = NULL)
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tema2CC";
    $results = [];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO filme (`id`, `nume_film`, `nume_categorie`, `descriere`) VALUES (NULL, '$nume', '$categorie', '$descriere')";
        $results = $conn->query($sql);
    } catch (PDOException $e) {
        return 'error';
    }
    $conn = null;
    return 'success';
}

function databaseDelete($id)
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tema2CC";
    $results = [];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $id == -1 ?"DELETE FROM filme WHERE 1" : "DELETE FROM filme WHERE id='$id'";
        $results = $conn->query($sql);
    } catch (PDOException $e) {
        return 'error';
    }
    $conn = null;
    return 'success';
}

function databasePUT($id = NULL, $nume, $categorie, $descriere = NULL)
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tema2CC";
    $results = [];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql1 = "SELECT * from `filme` where `id`=$id";
        $results = $conn->query($sql1);
        if(count($results->fetchAll())==0){
            $sql = "INSERT INTO filme (`id`, `nume_film`, `nume_categorie`, `descriere`) VALUES ($id, '$nume', '$categorie', '$descriere')";
            $results = $conn->query($sql);
            return ['success'=>'Inserted'];
        }
        else {
         $sql = "UPDATE `filme` SET `nume_film`='$nume',`nume_categorie`= '$categorie',`descriere`='$descriere' WHERE `id`=$id";
            $results = $conn->query($sql);
            return ['success'=>'Updated'];
        }

    } catch (PDOException $e) {
        var_dump($e);
        return 'error';
    }
    $conn = null;
    return 'error';
}
