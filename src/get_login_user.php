<?php 
    global $current_user;
    wp_get_current_user();
    $user = $current_user->user_login;
    echo 'Username: ' . $user . '';
?>