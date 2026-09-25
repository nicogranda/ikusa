<?php
if (empty($_SESSION['user_id'])) {
    header('Location: https://ikusa.net/login');
    exit();
}
?>