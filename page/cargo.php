<?php
session_start();

include_once '../app/view/CargoView.php';

if(!(isset($_SESSION['logado'])) OR  $_SESSION['logado'] != '1'){
    header("location: login.php");
}else{
    $view = new CargoView("Cargo");
    
    echo $view->get("lista");
    
}
