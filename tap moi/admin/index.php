<?php
session_start();
if(! isset($_SESSION['user_id'])){
    header("Location:login.php");
}
define('MYWEB','nguyenngocphi');
require_once '../vendor/autoload.php';
require_once '../config/database.php';

use App\Route;

Route::route_admin();