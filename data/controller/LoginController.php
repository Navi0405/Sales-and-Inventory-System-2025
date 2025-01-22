<?php
session_start();

include_once('../../config/database.php');
include_once('../model/User.php');
include_once('../model/ProductDetails.php');
include_once('../model/Product.php');
include_once('../model/ActionLog.php');

$action = $_GET['action'];
$User = new User($conn);
$ProductDetails = new ProductDetails($conn);
$Product = new Product($conn);
$ActionLog = new ActionLog($conn);

if ($action == 'verify_login')
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $request = [
        'username' => $username,
        'password' => $password
    ];

    $result = $User->verify_login($request);

    if($result == "Validated") {
        // Store username in the session
        $_SESSION['username'] = $username;

        $ProductDetails->updateExpiredStatus();
        $ProductDetails->updateNearExpiration();
        $Product->updateOverstock();
        $Product->updateUnderstock();
        $Product->updateOutofStock();
        $Product->updateNormalStock();
    }

    echo json_encode($result);
}

else if ($action == 'logout')
{
    // Retrieve username from session
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

    $ActionLog->saveLogs('logout', null, null, null, null, $username);

    session_destroy();

    echo json_encode('Success');
}

else
{
    echo json_encode(['error' => 'Invalid action']);
}
