<?php
require dirname(__DIR__) . '/src/bootstrap.php';
session_unset(); session_destroy(); header('Location: /login.php'); exit;
