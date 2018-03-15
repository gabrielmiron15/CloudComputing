<?php
require 'functions.php';
$request_method = $_SERVER["REQUEST_METHOD"];
$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$firstSegment = $uriSegments[0];
$lastUriSegment = array_pop($uriSegments);
if ($lastUriSegment !== 'filme' && ctype_digit($lastUriSegment)) {
    if ($request_method == 'GET') {
        getMethodFilme($cond = $lastUriSegment, $data = 'id');
    }
    if ($request_method == "DELETE") {
        deleteMethodFilme($lastUriSegment);
    }
    if ($request_method == "PUT") {
        $data = file_get_contents("php://input");
        parse_str($data, $_PUT);

        if (!empty($_PUT["name"]) && !empty($_PUT["category"]) && !empty($_PUT["description"])) {

                putMethodFilme($_PUT["name"], $_PUT["category"], $_PUT["description"], $lastUriSegment);
             
        } else {
            http_response_code(400);
            echo('Bad request');
        }
    }
    die();
} else
    if ($lastUriSegment !== 'filme' && !ctype_digit($lastUriSegment)) {
        http_response_code(404);
        die('Page Not Found');
    } else

        if ($request_method == 'GET') {
            if (count($_GET) != 0) {
                if (!empty($_GET["id"])) {
                    getMethodFilme($cond = $_GET["id"], $data = 'id');
                } else
                    if (!empty($_GET["name"])) {
                        getMethodFilme($cond = $_GET["name"], $data = 'name');
                    } else {
                        http_response_code(400);
                        die('Bad request');
                    }
            } else {

                getMethodFilme();
            }
        } else {

            if ($request_method == 'POST') {
                if (!empty($_POST["name"]) && !empty($_POST["category"])) {
                    if (!empty($_POST["description"])) {
                        postMethodFilme($_POST["name"], $_POST["category"], $_POST["description"]);
                    } else {
                        postMethodFilme($_POST["name"], $_POST["category"]);
                    }
                } else {
                    http_response_code(400);
                    die('Bad request');
                }
            }

            if ($request_method == "DELETE") {

                $data = file_get_contents("php://input");

                parse_str($data, $_DELETE);
                if (!empty($_DELETE["id"])) {
                    deleteMethodFilme($_DELETE["id"]);
                } else {

                    deleteMethodFilme(-1);

                }
            }


            if ($request_method == "PUT") {
                $data = file_get_contents("php://input");
                parse_str($data, $_PUT);

                if (!empty($_PUT["name"]) && !empty($_PUT["category"]) && !empty($_PUT["description"])) {
                    if (!empty($_PUT["id"])) {
                        putMethodFilme($_PUT["name"], $_PUT["category"], $_PUT["description"], $_PUT["id"]);
                    } else {
                        putMethodFilme($_PUT["name"], $_PUT["category"], $_PUT["description"]);
                    }
                } else {
                    http_response_code(400);
                    echo('Bad request');
                }
            }

        }