<?php

/**
 * Файл Controller.php отвечает за принятие данных от клиента.
 * На основе принятых данных Controller ывполняет какие-либо действия
 */
include_once "User.php";
include_once "Product.php";
include_once "Basket.php";


DB::instance();

//Условие будет выполнено в том случае, если метод отправки данных указан POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["action"]) && isset($_POST["data"])) {

        switch ($_POST["action"]) {
            case 'logIn':
                $user = (new User(...$_POST["data"]))->verification();
                if (!is_object($user))  { echo json_encode(array("status" => 0, "error" => $user)); exit;}

                echo json_encode($user->logIn());
                
            case 'signIn':
                // ... позволяет по порядку разложить элементы массива. Подробнее см ссылку
                // https://intellect.icu/php-5-6-tri-tochki-funktsii-s-peremennym-kolichestvom-argumentov-ispolzuya-sintaksis-razvertyvanie-argumentov-s-pomoshhyu-7510
                $user = (new User(...$_POST["data"]))->verification();
                break;
            
            default:
                echo json_encode(array("status" => 0, "error" => "Переданный action не существует"));
                break;
        }

    } else {
        echo json_encode(array("status" => 0, "error" => "Не переданы POST-данные"));
    }

}

