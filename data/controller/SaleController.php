<?php

include_once('../../config/database.php');
include_once('../model/Category.php');
include_once('../model/Product.php');
include_once('../model/ProductDetails.php');
include_once('../model/Invoice.php');
include_once('../model/Sale.php');


$action = $_GET['action'];
$Category = new Category($conn);
$Product = new Product($conn);
$ProductDetails = new ProductDetails($conn);
$Invoice = new Invoice($conn);
$Sale = new Sale($conn);


if ($action === 'searchDaily') {

    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        echo json_encode($Sale->searchDaily($date));
    } else {
        echo json_encode('No selected date');
    }
} else if ($action === 'searchMonthly') {

    if (isset($_GET['yearmonth'])) {
        $yearmonth = explode('-', $_GET['yearmonth']);
        echo json_encode($Sale->searchMonthly($yearmonth));
    } else {
        echo json_encode('No selected date');
    }
} else if ($action === 'searchRange') {

    if (isset($_GET['startDate']) && isset($_GET['endDate'])) {
        $start = $_GET['startDate'];
        $end = $_GET['endDate'];
        echo json_encode($Sale->searchRange($start, $end));
    }
} else {
    return 'Something went wrong';
}
