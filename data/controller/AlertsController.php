<?php

include_once('../../config/database.php');
include_once('../model/Product.php');
include_once('../model/ProductDetails.php');

$action = $_GET['action'];
$ProductDetails = new ProductDetails($conn);
$Product = new Product($conn);

switch ($action) {
    case 'getTableDataExpirationStatus':
    
        $result = $ProductDetails->getAllAlertExpired();

        $table_data = '';
        $counter = 1;
        foreach ($result as $product) {
            $expired_status = $product['expired_status'];

            if($product['designation'] == 0 && $product['expired_status'] == 0 && $product['quantity'] != 0) 
            {
                $expired_status = '<span class="category category--red">Near Expiration</span>'; 
            }
            else if ($product['designation'] == 0 && $product['expired_status'] == 1 && $product['quantity'] != 0){
                $expired_status = '<span class="category category--red">Expired</span>' .
                '<select class="form-control" name="" id="designate" onchange="Alerts.getExpiredId('. $product['product_details_id'] .','. $product['expired_status'] . ')">
                    <option value="" selected="true">Select Designation</option>
                    <option value="1" onchange="Alerts.Exchange('. $product['product_details_id'] .',' . $product['expired_status'] .','. $product['designation'] . ')" id="exchange">For Exchange</option>
                    <option value="2" onchange="Alerts.Return('. $product['product_details_id'] .',' . $product['expired_status'] .','. $product['designation'] . ')" id="return">For Return</option>
                    <option value="3"  onchange="Alerts.Decompose('. $product['product_details_id'] .',' . $product['expired_status'] .','. $product['designation'] . ')" id="decompose">Decompose</option>
                </select>';
            }


            $table_data .= '<tr>';
            $table_data .= '<td>' . $counter . '</td>';
            $table_data .= '<td>' . $product['product_name'] . '</td>';
            $table_data .= '<td>' . $product['batch'] . '</td>';
            $table_data .= '<td>' . $product['quantity'] . '</td>';
            $table_data .= '<td>' . $product['expiration_date'] . '</td>';
            $table_data .= '<td>' . $expired_status . '</td>';
            $table_data .= '</tr>';

            $counter++;
        }
        echo json_encode($table_data);
    break;

    case 'getTableDataStockStatus':
    
        $result = $Product->getAllByStockStatus();
        // $quantity = $_POST['quantity'];
        // $request = ['quantity' => $quantity]; 
        $table_data = '';
        $counter = 1;
        foreach ($result as $product) {
            // $stock_status = $product['stock_status'];

            if ($product['stock_status'] == 0) 
            {
                $stock_status = '<span class="category category--black">Out of Stock</span>';
            }         
            else if ($product['stock_status'] == 3) 
            {
                $stock_status = '<span class="category category--red">Oversupply</span>';
            }
            else if($product['stock_status'] == 2) 
            {
                $stock_status = '<span class="category category--orange">Insufficient</span>';
            }
            else if($product['stock_status'] == 4)
            {
                $stock_status = '<span class"category category--yellow">Kindly add a stock(s) for this new product.</span>';
            }
        

            

            $table_data .= '<tr>';
            $table_data .= '<td>' . $counter . '</td>';
            $table_data .= '<td>' . $product['product_name'] . '</td>';
            $table_data .= '<td>' . $product['total_quantity'] . '</td>';
            $table_data .= '<td>' . $product['max_stock'] . '</td>';
            $table_data .= '<td>' . $product['min_stock'] . '</td>';
            $table_data .= '<td>' . $stock_status . '</td>';
            $table_data .= '</tr>';

            $counter++;
        }

        echo json_encode($table_data);

    break;

    case 'getById':
    
        $product_details_id = $_POST['product_details_id'];

        echo json_encode($ProductDetails->getById($product_details_id));

    break;

    case 'exchange':
    
        $id = $_POST['product_details_id'];
        $designation = $_POST['designation'];
        $expired_status = $_POST['expired_status'];

        $request = [
            'product_details_id' => $id,
            'designation' => $designation,
            'expired_status' => $expired_status
        ];

        $result = $ProductDetails->Exchange($request);

        echo json_encode($result);

    break;

    case 'return':
    
        $id = $_POST['product_details_id'];
        $designation = $_POST['designation'];
        $expired_status = $_POST['expired_status'];

        $request = [
            'product_details_id' => $id,
            'designation' => $designation,
            'expired_status' => $expired_status
        ];

        $result = $ProductDetails->Return($request);

        echo json_encode($result);
    
    break;

    case 'decompose':
    
        $id = $_POST['product_details_id'];
        $designation = $_POST['designation'];
        $expired_status = $_POST['expired_status'];

        $request = [
            'product_details_id' => $id,
            'designation' => $designation,
            'expired_status' => $expired_status
        ];

        $result = $ProductDetails->Decompose($request);

        echo json_encode($result);

    break;

    default:
        echo json_encode(['error' => 'Invalid action']);
        
}