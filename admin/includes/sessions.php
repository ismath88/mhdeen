<?php
$session = new sessions();
$username = $session->get('username');
if(!$username){
    
    header('location:index.php');
};
?>