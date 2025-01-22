<?php

include_once('../../config/database.php');
include_once('../../data/model/Sales.php');

$action = $_GET['action'];
$Sales = new Sales($conn);

// $dateFrom = $_GET['dateFrom'];
// $dateTo = $_GET['dateTo'];
if ($action === 'exportReportTable'){
$dateFrom = date('Y-m-d', strtotime($_POST['dateFrom']));
$dateTo = date('Y-m-d', strtotime($_POST['dateTo']));

// $fetch = $Sales->getAll($result);

$result = $Sales->getReport($dateFrom, $dateTo);

// $collected = $fetch['export'];

// $table = '<table>
//             <tr>
//             <th>Product</th>
//             <th>Price</th>
//             <th>Quantity</th>
//             <th>Date Purchased</th>
//             <th>Invoice ID</th>
//             </tr>';
$table = '';
$table = '<table>';
foreach ($result as $excel){
$table.= '<tr>
            <td>' . $excel['product_name'] . '</td>
            <td>' . $excel['total_price'] . '</td>
            <td>' . $excel['total_sales'] . '</td>
            <td>' . $excel['bought'] . '</td>
            <td>' . $excel['transact'] . '</td>
            </tr>';
}
$table.= '</table>';
echo $table;
}

else{
    return 'Something went wrong';
}
?>
