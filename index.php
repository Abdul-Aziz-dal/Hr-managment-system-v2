<?php
class InitController
{

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function init()
    {
        try {
            $user = $_SESSION['user'];
            if (!isset($user)) {
                header('Location: pages/auth/login.php');
                exit();
            }
            return header('Location: pages/dashboard.php');
            exit();
        } catch (Exception $e) {
            return header('Location: pages/auth/login.php');
            exit();
        }
    }
}

$app = new InitController();
$app->init();
