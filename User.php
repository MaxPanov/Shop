<?php
session_start();

class User {

    private $user_id;
    private $login;
    private $pass;

    function __construct($login = "", $pass = "", $user_id = "") {
        $this->user_id = $user_id;
        $this->login = $login;
        $this->pass = $pass;
    }

    function __get($property) {
        return $this->$property;
    }

    function logIn() {
        $select = DB::query("SELECT * FROM `User` WHERE `login` = '{$this->login}' LIMIT 1 ", [], User::class);

        if ($select) if (password_verify($this->pass, $select[0]->pass)) {

            $_SESSION["User"] = $select[0];

            return array("status" => 1, "redirect" => "/shop/");
        }

        return array("status" => 0, "error" => ["Неправильный Логин или Пароль"]);
    }

    /**
     * В случае, если массив errors будет заполнен,
     * то функция вернет нам массив с ошибками,
     * иначе вернет объект класса User
     */
    function verification() {
        $errors = [];

        if (!$this->login) $errors[] = "Не передан Логин";
        if (!$this->pass) $errors[] = "Не передан Пароль";

        if (strlen($this->login) < 5) $errors[] = "Логин не может быть меньше 5 символов"; 
        if (strlen($this->pass) < 8) $errors[] = "Пароль не может быть меньше 8 символов"; 

        return ($errors) ? $errors : $this;
    }
}