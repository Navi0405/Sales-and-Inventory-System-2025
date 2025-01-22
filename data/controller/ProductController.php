<?php

include_once('../../config/database.php');
include_once('../model/Category.php');
include_once('../model/Product.php');
include_once('../model/ProductDetails.php');

$action = $_GET['action'];
$Category = new Category($conn);
$Product = new Product($conn);
$ProductDetails = new ProductDetails($conn);

if(isset($_GET['barcode'])){
    $barcode = $_GET['barcode'];
}

switch ($action)
{
    case 'getTableDataRegister': 
        $result = $ProductDetails->getAll();

        $table_data = '';
        $counter = 1;
        foreach ($result as $product) {
            if($product['product_details_id']==NULL){
                $product['product_details_id']=0;
            }
        
        
            $table_data .= '<tr>';
            $table_data .= '<td>' . $counter . '</td>';
            $table_data .= '<td>' . $product['product_name'] . '</td>';
            $table_data .= '<td>' . $product['barcode'] . '</td>';
            $table_data .= '<td>' . $product['batch'] . '</td>';
            $table_data .= '<td class="col-actions">';
            $table_data .= '<div class="btn-group" role="group" aria-label="Basic mixed styles example">';
            $table_data .= '<button type="button" onclick="Product.clickUpdate('. $product['product_details_id'] .','. $product['product_id'] .')" class="btn btn-warning btn-sm"><i class="bi bi-list-check"></i> Add Stocks </button>';
            // $table_data .= '<button type="button" onclick="Product.clickDelete('. $product['product_details_id'] .')" class="btn btn-danger btn-sm"> <i class="bi bi-trash"></i> Delete</button>';
            $table_data .= '</div>';
            $table_data .= '</td>';
            $table_data .= '</tr>';

            $counter++;
        }

        echo json_encode($table_data);
    break;


    case 'getRegisteredProductsById':

        $product_id = $_POST['product_id'];
        $result = $Product->getRegisteredProductsById($product_id);

        echo json_encode($result);
    break;

    case 'loadTableData':

        $result = $ProductDetails->loadTableData();

        $table_data = '';
        $counter = 1;
        foreach ($result as $product) {
            $table_data .= '<tr>';
            $table_data .= '<td>' . $counter . '</td>';
            $table_data .= '<td>' . $product['barcode'] . '</td>';
            $table_data .= '<td>' . $product['product_name'] . '</td>';
            $table_data .= '</tr>';

            $counter++;
        }

        echo json_encode($table_data);
        
    break;

    case 'getProductTable':
    
        $result = $Product->getAll();
        $resultExpired = $Product->getAllExpired();


        $productExpiredQty =[];
        foreach($resultExpired as $productExpired){
            $productExpiredQty[$productExpired['barcode']] = $productExpired['total_quantity'];
        }

        $table_data = '';
        $counter = 1;

        // foreach ($result as $product) {
        //     if ($product['total_quantity'] == 0) {
        //         continue; // Skip products with stock value of 0
        //     }
            
            foreach ($result as $product) {
                $status = ($product['status'] == 1) ? 'Active' : 'Deactivate';
                $product_name = "'" . addslashes($product['product_name']) . "'";

                $totalExpired = 0;
                if(array_key_exists($product['barcode'], $productExpiredQty)){
                    $totalExpired = $productExpiredQty[$product['barcode']];
                }

                $table_data .= '<tr>';
                $table_data .= '<td>' . $counter . '</td>';
                $table_data .= '<td>' . $product['product_name'] . '</td>';
                $table_data .= '<td><span class="category">' . $product['category_name'] . '</span></td>';
                $table_data .= '<td>' . $product['type'] . '</td>';
                $table_data .= '<td>' . $product['barcode'] . '</td>';
                $table_data .= '<td>' . $product['total_quantity'] . '</td>';
                $table_data .= '<td>' . $product['max_stock'] . '</td>';
                $table_data .= '<td>' . $product['min_stock'] . '</td>';
                // $table_data .= '<td>' . $product['lot_num'] . '</td>';
                $table_data .= '<td>' . $product['sale_price'] . '</td>';
                $table_data .= '<td>' . $status . '</td>';
                $table_data .= '<td>' . $totalExpired. '</td>';
                $table_data .= '<td class="col-actions">';
                $table_data .= '<div class="btn-group" role="group" aria-label="Basic mixed styles example">';
                $table_data .= '<button type="button" onclick="Product.clickView('. $product['product_id'] .','. $product_name .')" class="btn btn-info btn-sm"><i class="bi bi-eye"></i> View </button>';
                if($_SESSION['user']['role'] != 3) {
                    $table_data .= '<button type="button" onclick="Product.clickUpdate('. $product['product_id'] .','. $product_name .')" class="btn btn-warning btn-sm"><i class="bi bi-list-check"></i> Update </button>';
                }
                $table_data .= '</div>';
                $table_data .= '</td>';
                $table_data .= '</tr>';

                $counter++;
            }
            echo json_encode($table_data);

    break;

    case 'inventoryExcel':

        $result = $Product->getAll();
        $resultExpired = $Product->getAllExpired();
        $designatory = $ProductDetails->getDesignations();

        $productExpiredQty =[];
        foreach($resultExpired as $productExpired){
            $productExpiredQty[$productExpired['barcode']] = $productExpired['total_quantity'];
        }

        $designatedProductsQty =[];
        foreach($designatory as $designatedProducts){
            $designatedProductsQty[$designatedProducts['barcode']] = $designatedProducts['designation'];
        }

        $column_name = [];
        foreach ($result as $inventory){
            $status = ($inventory['status'] == 1) ? 'Active' : 'Deactivate';
            $product_name = "'" . addslashes($inventory['product_name']) . "'";

            $totalExpired = 0;
            if(array_key_exists($inventory['barcode'], $productExpiredQty)){
                $totalExpired = $productExpiredQty[$inventory['barcode']];
            }

            $totalDesignated = 0;
            if(array_key_exists($inventory['barcode'], $designatedProductsQty)){
                $totalDesignated = $productExpiredQty[$inventory['designation']];
            }

            $column_name[] = [
                'Product' => $inventory['product_name'],
                'Category' => $inventory['category_name'],
                'Type' => $inventory['type'],
                'Barcode' => $inventory['barcode'],
                'Quantity' => $inventory['total_quantity'],
                'Max Stock' => $inventory['max_stock'],
                'Min Stock' => $inventory['min_stock'],
                'Status' => $status,
                'Expired Products' => $totalExpired,
                'Designated Products' => $totalDesignated
            ];
        }

        echo json_encode($column_name);
    break;


    case 'getProductDetailsTableModal':
    
        $product_id = $_POST['product_id'];
        $result = $ProductDetails->getAllByProductId($product_id);

        $table_data = '';
        foreach ($result as $productDetails) {
            $expired_status = ($productDetails['expired_status'] == 1) ? 'Yes' : 'No';

            $table_data .= '<tr>';
            $table_data .= '<td>' . $productDetails['batch'] . '</td>';
            $table_data .= '<td>' . $productDetails['lot_num'] . '</td>';
            $table_data .= '<td>' . $productDetails['quantity'] . '</td>';
            $table_data .= '<td>' . $productDetails['buy_price'] . '</td>';
            $table_data .= '<td>' . $productDetails['date_added'] . '</td>';
            $table_data .= '<td>' . $productDetails['manufacture_date'] . '</td>';
            $table_data .= '<td>' . $productDetails['expiration_date'] . '</td>';
            $table_data .= '<td>' . $expired_status . '</td>';
            // $table_data .= '<td class="col-actions">';
            // $table_data .= '<div class="btn-group" role="group" aria-label="Basic mixed styles example">';
            // // $table_data .= '<button type="button" onclick="Product.clickUpdate('. $productDetails['product_details_id'] .','. $productDetails['product_id'] .')" class="btn btn-warning btn-sm"><i class="bi bi-list-check"></i> Update </button>';
            // if($_SESSION['user']['role'] == 1) {
            // // $table_data .= '<button type="button" onclick="Product.clickDelete('. $productDetails['product_details_id'] .')" class="btn btn-danger btn-sm"> <i class="bi bi-trash"></i> Delete</button>';
            // }
            // $table_data .= '</div>';
            // $table_data .= '</td>';
            $table_data .= '</tr>';

        }

        echo json_encode($table_data);

    break;

    case 'getDesignatedExpiredTable':
    
        // $product_id = $_POST['product_id'];
        $result = $ProductDetails->getAllDesignated();

        $table_data = '';
        $counter = 1;
        if(!empty($result[0]['product_name'])){
        foreach ($result as $productDetails) {
            // $expired_status = ($productDetails['expired_status'] == 1) ? 'Yes' : 'No';
            // $table_data .= print_r($result);
            $table_data .= '<tr>';
            $table_data .= '<td>' . $counter . '</td>';        
            $table_data .= '<td>' . $productDetails['product_name'] . '</td>';
            $table_data .= '<td>' . $productDetails['batch'] . '</td>';
            $table_data .= '<td>' . $productDetails['quantity'] . '</td>';
            $table_data .= '<td>' . $productDetails['expiration_date'] . '</td>';
            if ($productDetails['designation'] == 1) {
            $table_data .= '<td>' . 'For Exchange' . '</td>';
            $table_data .= '<td>' . '<button type="submit" onclick=""> Exchanged </button>';
            }
            else if ($productDetails['designation'] == 2) {
            $table_data .= '<td>' . 'For Return' . '</td>';
            $table_data .= '<td>' . '<button type="submit" onclick=""> Returned </button>';
            }
            else if ($productDetails['designation'] == 3) {
            $table_data .= '<td>' . 'Decompose' . '</td>';
            $table_data .= '<td>' . '<button type="submit" onclick=""> Decomposed </button>';    
            }
            // $table_data .= '<td>' . $productDetails['designation'] . '</td>';        
            // $table_data .= '<td>' . $expired_status . '</td>';

            // $table_data .= '</td>';
            $table_data .= '</tr>';

            $counter++;
        }
        }
        echo json_encode($table_data);

    break;


    case 'getSelectData':
    
        $result = $Category->getAll();

        $options = '<option value="" selected="true" disabled>Select Category</option>';

        foreach ($result as $category) 
        {
            $options .= '<option value='. $category['id'] .'>' . $category['name'] . '</option>';
        }

        echo json_encode($options);

    break;

    case 'getById':
    
        $product_details_id = $_POST['product_details_id'];

        echo json_encode($ProductDetails->getById($product_details_id));

    break;

    case 'save':
    
        $product_barcode = $_POST['product_barcode'];
        $product_name = $_POST['product_name'];
        $product_category = $_POST['product_category'];
        $lot_num = $_POST['lot_num'];
        $buying_price = $_POST['buying_price'];
        $selling_price = $_POST['selling_price'];
        $manufature_date = $_POST['manufature_date'];
        $expiraton_date = $_POST['expiraton_date'];
        $status = $_POST['status'];
        $quantity = $_POST['quantity'];
        $type = $_POST['type'];
        $location = $_POST['location'];


        $request = [
            'product_barcode' => $product_barcode,
            'product_name' => $product_name,
            'product_category' => $product_category,
            'lot_num' => $lot_num,
            'buying_price' => $buying_price,
            'selling_price' => $selling_price,
            'manufature_date' => $manufature_date,
            'expiraton_date' => $expiraton_date,
            'status' => $status,
            'quantity' => $quantity,
            'type' => $type,
            'location' => $location,
        ];

        
        $product = $Product->getByBarcode($product_barcode);
        
        $lastInsertID = '';
        if(empty($product)) 
        {
            $lastInsertID = $Product->save($request);
            $request['product_id'] = $lastInsertID;
        }
        else 
        {
            $request['product_id'] = $product['id'];
            $Product->updateSellPrice($request);
        }
        
        $result = $ProductDetails->save($request);

        echo json_encode($result);

    break;

    case 'registerProduct':
    
        $txt_product_barcode = $_POST['txt_product_barcode'];
        $txt_product_name = $_POST['txt_product_name'];
        // $txt_lot_number = $_POST['txt_lot_number'];
        $slc_product_category = $_POST['slc_product_category'];
        $slc_status = $_POST['slc_status'];
        $slc_type = $_POST['slc_type'];

        $request = [
            'txt_product_barcode' => $txt_product_barcode,
            'txt_product_name' => $txt_product_name,
            // 'lot_num' => $lot_num,
            'slc_product_category' => $slc_product_category,
            'slc_status' => $slc_status,
            'slc_type' => $slc_type,
        ];

        $result = $ProductDetails->registerProduct($request);
        $Product->updateNormalStock();

        echo json_encode($result);

    break;

    case 'updateProductDetails':
    
        $product_id = $_POST['product_id'];
        $product_details_id = $_POST['product_details_id'];
        $lot_num = $_POST['lot_num'];
        $buying_price = $_POST['buying_price'];
        $selling_price = $_POST['selling_price'];
        $manufature_date = $_POST['manufature_date'];
        $expiraton_date = $_POST['expiraton_date'];
        $quantity = $_POST['quantity'];
        $location = $_POST['location'];
        // $Product->updateSellPrice($request);
        
        $request = [
            'product_id' => $product_id,
            'product_details_id' => $product_details_id,
            'lot_num' => $lot_num,
            'buying_price' => $buying_price,
            'selling_price' => $selling_price,
            'manufature_date' => $manufature_date,
            'expiraton_date' => $expiraton_date,
            'quantity' => $quantity,
            'location' => $location,
        ];
        $Product->updateSellPrice($request);
        $result = $ProductDetails->update($request);
        $ProductDetails->updateExpiredStatus();
        $ProductDetails->updateNearExpiration();
        $Product->updateOverstock();
        $Product->updateUnderstock();
        $Product->updateOutofStock();
        $Product->updateNormalStock();
        
        echo json_encode($result);

    break;

    case 'getProductForUpdate':
    
        $product_id = $_POST['product_id'];

        $result = $Product->getById($product_id);

        echo json_encode($result);

    break;


    case 'updateProduct':
    
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_barcode = $_POST['product_barcode'];
        $product_category = $_POST['product_category'];
        $selling_price = $_POST['selling_price'];
        // $lot_num = $_POST['lot_num'];
        $status = $_POST['status'];
        $max_stock = $_POST['max_stock'];
        $min_stock = $_POST['min_stock'];
        $type = $_POST['type'];
        // $expired_products = $_POST['expired_products'];

        $request = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_barcode' => $product_barcode,
            'product_category' => $product_category,
            'selling_price' => $selling_price,
            // 'lot_num' => $lot_num,
            'status' => $status,
            'max_stock' => $max_stock,
            'min_stock' => $min_stock,
            'type' => $type,
            // 'expired_products' => $expired_products,
        ];

        $result = $Product->update($request);
        $ProductDetails->updateExpiredStatus();
        $ProductDetails->updateNearExpiration();
        $Product->updateOverstock();
        $Product->updateUnderstock();
        $Product->updateNormalStock();

        echo json_encode($result);

    break;

    case 'getAvailableProductByBarcode':
        $result = $Product->getAvailableProductByBarcode($barcode);
        echo json_encode($result);
    break;

    case 'getTotalProduct':
    
        $result = $Product->getTotalProduct();
        echo json_encode($result);

    break;

    default:
        echo json_encode(['error' => 'Invalid action']);
}