<?php 
    function DbConnect() {
        return new PDO("mysql:host=localhost;dbname=lsapp", "root", "");
    }

    spl_autoload_register(function($className) {
        $models = 'models/';
        require_once $models.$className.".php";
    });

    if (!isset($_SESSION)) {
        session_start();
    }
?>