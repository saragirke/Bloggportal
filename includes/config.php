<?php


if(!isset($_SESSION)) 
{ 
    session_start(); 
}

    // autoinkludera klasser
    spl_autoload_register(function ($class_name) {
        include 'classes/' . $class_name . '.class.php';
    });

    $site_title = "Saras webbplats";
    $divider = " | ";

   