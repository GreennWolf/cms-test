<?php
session_start();

if (@$_SESSION['super']) {
    header('Location: check.php');
} else {
    header('Location: formLogin.html?' . time());
}
?>