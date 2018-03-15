<?php
require 'database.php';

function getMethodFilme($cond = -1, $data = '')
{
    $myArray = [];
    $myAllArray = [];
    if ($cond == -1) {
        $results = databaseGet();
    } else {
        if ($data == 'id') {
            $results = databaseGet($condition = 'id=' . $cond);
        }
        if ($data == 'name') {
            $results = databaseGet($condition = 'nume_film=' . '\'' . $cond . '\'');
        }
    };

    if (count($results) == 0 ) {
        die(json_encode(["400" => "bad request"]));
    } else {
        foreach ($results as $result) {
            $myArray["id"] = $result['id'];
            $myArray["nume_film"] = $result["nume_film"];
            $myArray["categorie"] = $result['nume_categorie'];
            $myArray["descriere"] = $result["descriere"];
            $myAllArray[] = $myArray;
        }
        echo(json_encode(($myAllArray)));
    }


}

function postMethodFilme($nume, $categorie, $descriere = NULL)
{
    $response = databasePost($nume, $categorie, $descriere);
    if ($response == 'success') {
        http_response_code(200);
        echo(json_encode(['success' => 'Done']));
    }
    if ($response == 'error') {
        http_response_code(400);
        echo(json_encode(['error' => 'Error']));
    }
}

function deleteMethodFilme($id)
{
    $response = databaseDelete($id);
    if ($response == 'success') {
        http_response_code(200);
        echo(json_encode(['success' => 'Deleted']));
    }
    if ($response == 'error') {
        http_response_code(400);
        echo(json_encode(['error' => 'Error']));
    }
}


function putMethodFilme($nume,$categorie,$descriere,$id=NULL)
{
    $response = databasePUT($id,$nume,$categorie,$descriere);
    if (!empty($response['success'])) {
        http_response_code(200);
        echo(json_encode($response['success']));
    }
    if ($response == 'error') {
        http_response_code(400);
        echo(json_encode(['error' => 'Error']));
    }
}