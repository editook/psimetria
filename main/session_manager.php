<?php
include_once('configs.php');
if(!isset($_SESSION))
    session_start();
$actual = "";
if( !isset( $_SESSION['REST_id_user'] ) )
    $actual = $_SERVER['PHP_SELF'];
    
    if($actual == '/index.php'){
        header( 'Location: '. LOCALHOST .'/view/index.php' );
    }
    else if(!isset( $_SESSION['REST_id_user'])){
        header( 'Location: '. LOCALHOST .'/admin' );
    }
    