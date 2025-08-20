<?php

include_once('configs.php');
include_once('session_manager.php');

if( $_SESSION['REST_type_user'] == 'Administrador' || $_SESSION['REST_type_user'] == 'CLIENTE' )
    header("Location: ". LOCALHOST ."/view/index.php");
else
    header( 'Location: '. LOCALHOST .'/signin.php' );