<?php

include_once('../../config/database.php');
include_once('../model/ActionLog.php');

$action = $_GET['action'];
$ActionLog = new ActionLog($conn);

if ($action == 'getTableData') 
{
    $result = $ActionLog->getAll();

    usort($result, function ($present, $past) {
        return strtotime($past['datetime']) - strtotime($present['datetime']);
    });


    $table_data = '';
    $counter = 1;
    // foreach ($result as $product) {
    //     $table_data .= '<tr>';
    //     $table_data .= '<td>' . $counter . '</td>';
    //     $table_data .= '<td>' . $product['datetime'] . '</td>';
    //     $table_data .= '<td>' . $product['role'] . '</td>';
    //     $table_data .= '<td>' . $product['username'] . '</td>';
    //     $table_data .= '<td>' . $product['action'] . '</td>';
    //     $table_data .= '</tr>';

    //     $counter++;
    // }
    foreach ($result as $product) {
        $datetime = date('Y-m-d / h:i:s A', strtotime($product['datetime']));
        $table_data .= '<tr>';
        $table_data .= '<td>' . $counter . '</td>';
        $table_data .= '<td>' . $datetime . '</td>';
        $table_data .= '<td>' . $product['role'] . '</td>';
        $table_data .= '<td>' . $product['username'] . '</td>';
        $table_data .= '<td>' . $product['action'] . '</td>';
        $table_data .= '</tr>';
    
        $counter++;
    }

    echo json_encode($table_data);
}

else 
{
    echo json_encode(['error' => 'Invalid action']);
}

?>