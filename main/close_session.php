<?php
include_once('configs.php');
include_once('session_manager.php');

unset($_SESSION['REST_id_user']);
unset($_SESSION['REST_type_user']);

header( 'Location: '. LOCALHOST .'/signin.php' );