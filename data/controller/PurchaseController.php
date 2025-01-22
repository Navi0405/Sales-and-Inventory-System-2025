<?php 
include_once('../../config/database.php');
include_once('../model/Purchase.php');

$action = $_GET['action'];
$Purchase = new Purchase($conn);

switch ($action)
{

    case 'getPurchaseTable':
    
        $result = $Purchase->getAllPurchases();

        $table_data = '';
        $counter = 1;
        foreach ($result as $purchases) {
            $status = $purchases['status'];
            $paid = $purchases['paid'];
            $delivery = $purchases['delivery'];
            $received = $purchases['received'];
            $stock = $purchases['stock'];
            $damaged = $purchases['damaged'];
            $incomplete = $purchases['incomplete'];
            $theft = $purchases['theft'];

            $table_data .= '<tr>';
            $table_data .= '<td>' . $counter . '</td>';
            $table_data .= '<td>' . $purchases['orders'] . '</td>';
            $table_data .= '<td>' . $purchases['quantity'] . '</td>';
            $table_data .= '<td>' . $purchases['amount'] . '</td>';
            $table_data .= '<td>' . $purchases['order_date'] . '</td>';
            $table_data .= '<td>' . $purchases['receiving_date'] . '</td>';
            $table_data .= '<td>' . $purchases['supplier'] . '</td>';
            $table_data .= '<td>' . $status . '</td>';
            $table_data .= '<td class="col-actions">';
            $table_data .= '<div class="btn-group" role="group" aria-label="Basic mixed styles example">';
            if ($status == 0) {
            $table_data .= '<button type="button" id="pay" onclick="Purchase.clickPay('. $purchases['purchase_id'] .','. $status .','. $paid .')" class="btn btn-warning btn-sm"><i class="bi bi-list-check"></i> Pay </button>';
            }
            else if ($status == 1) {
            $table_data .= '<button type="button" id="" class="btn btn-warning btn-sm"  disabled><i class="bi bi-list-check"></i> Paid </button>';
            $table_data .= '<button type="button" id="deliver" onclick="Purchase.clickDeliver('. $purchases['purchase_id'] .','. $status .','. $delivery .')" class="btn btn-warning btn-sm"><i class="bi bi-list-check"></i> On-Delivery </button>';
            }
            else if ($status == 2) {
            $table_data .= '<button type="button" id="" class="btn btn-warning btn-sm"  disabled><i class="bi bi-list-check"></i> Delivered </button>';
            $table_data .= '<button type="button" id="receive" onclick="Purchase.clickReceive('. $purchases['purchase_id'] .','. $status .','. $received .')" class="btn btn-warning btn-sm"><i class="bi bi-list-check"></i> Received </button>';
            }
            else if ($status == 3) {
            $table_data .= '<button type="button" id="" class="btn btn-warning btn-sm"  disabled><i class="bi bi-list-check"></i> Received </button>';
            $table_data .= '<button type="button" id="stock" onclick="Purchase.clickStock('. $purchases['purchase_id'] .','. $status .','. $stock .')" class="btn btn-warning btn-sm"><i class="bi bi-list-check"></i> On-Stock </button>';
            $table_data .= '<button type="button" id="damaged" onclick="Purchase.clickDamage('. $purchases['purchase_id'] .','. $status .','. $damaged .')" class="btn btn-warning btn-sm"><i class="bi bi-list-check"></i> Damaged </button>';
            $table_data .= '<button type="button" id="incomplete" onclick="Purchase.clickIncomplete('. $purchases['purchase_id'] .','. $status .','. $incomplete .')" class="btn btn-warning btn-sm"><i class="bi bi-list-check"></i> Incomplete </button>';
            $table_data .= '<button type="button" id="theft" onclick="Purchase.clickTheft('. $purchases['purchase_id'] .','. $status .','. $theft .')" class="btn btn-warning btn-sm"><i class="bi bi-list-check"></i> Theft </button>';
        }
            else if ($status == 4) {
            $table_data .=    '<button type="button" id="stocked" onclick=""  class="btn btn-warning btn-sm" disabled><i class="bi bi-list-check"></i> On-Stock </button>';
                // $status += $a;
        }
            else if ($status == 5) {
            $table_data .=     '<button type="button" id="damaged" onclick="" class="btn btn-warning btn-sm" disabled><i class="bi bi-list-check" ></i> Damaged </button>';
                // $status += $b;
                }
            else if ($status == 6){
            $table_data .=     '<button type="button" id="incompleted" onclick="" class="btn btn-warning btn-sm" disabled><i class="bi bi-list-check"></i> Incomplete </button>';
                // $status += $c;
            }

            else{
            $table_data .=     '<button type="button" id="incompleted" onclick="" class="btn btn-warning btn-sm" disabled><i class="bi bi-list-check"></i> Theft </button>';
                // $status += $c;
            }
            // $table_data .= '<button type="button" onclick="Product.clickDelete('. $product['product_details_id'] .')" class="btn btn-danger btn-sm"> <i class="bi bi-trash"></i> Delete</button>';
            $table_data .= '</div>';
            $table_data .= '</td>';
            $table_data .= '</tr>';

            $counter ++;
        }

        echo json_encode($table_data);

    break;

    case 'createPurchase':
    
        $purchase_id = $_POST['purchase_id'];

        $result = $Purchase->getById($purchase_id);

        echo json_encode($result);
    
    break;

    case 'save':
    
        $orders = $_POST['orders'];
        $quantity = $_POST['quantity'];
        $amount = $_POST['amount'];
        $order_date = $_POST['order_date'];
        $receiving_date = $_POST['receiving_date'];
        $supplier = $_POST['supplier'];



        $request = [
            'orders' => $orders,
            'quantity' => $quantity,
            'amount' => $amount,
            'order_date' => $order_date,
            'receiving_date' => $receiving_date,
            'supplier' => $supplier,
        ];
        
        $result = $Purchase->save($request);

        echo json_encode($result);
    
    break;

    case 'getID':
    

        $purchase_id = $_POST['purchase_id'];

        
        echo json_encode($Purchase->getById($purchase_id));

    break;

    case 'Pay':
    
        $id = $_POST['purchase_id'];
        $status = $_POST['status'];

        $request = [
            'purchase_id' => $id,
            'status' => $status
        ];

        $result = $Purchase->Pay($request);

        echo json_encode($result);
    
    break;

    case 'paid':
    
        $id = $_POST['purchase_id'];
        $paid = $_POST['paid'];

        $request = [
            'purchase_id' => $id,
            'paid' => $paid
        ];

        $result = $Purchase->paid($request);

        echo json_encode($result);    

    break;

    case 'Deliver':
    
        $id = $_POST['purchase_id'];
        $status = $_POST['status'];

        $request = [
            'purchase_id' => $id,
            'status' => $status
        ];

        $result = $Purchase->Deliver($request);

        echo json_encode($result);

    break;
    
    case 'delivery':
    
        $id = $_POST['purchase_id'];
        $delivery = $_POST['delivery'];

        $request = [
            'purchase_id' => $id,
            'delivery' => $delivery
        ];

        $result = $Purchase->delivery($request);

        echo json_encode($result);    
    
    break;

    case 'Receive':
    
        $id = $_POST['purchase_id'];
        $status = $_POST['status'];

        $request = [
            'purchase_id' => $id,
            'status' => $status
        ];

        $result = $Purchase->Receive($request);

        echo json_encode($result);

    break;

    case 'received':
    
        $id = $_POST['purchase_id'];
        $received = $_POST['received'];

        $request = [
            'purchase_id' => $id,
            'received' => $received
        ];

        $result = $Purchase->received($request);

        echo json_encode($result);
    
    break;

    case 'Stock':
    
        $id = $_POST['purchase_id'];
        $status = $_POST['status'];

        $request = [
            'purchase_id' => $id,
            'status' => $status
        ];

        $result = $Purchase->Stocked($request);

        echo json_encode(['success' => 'Stocks loaded successfully']);
    
    break;

    case 'stock':
    
        $id = $_POST['purchase_id'];
        $stock = $_POST['stock'];

        $request = [
            'purchase_id' => $id,
            'stock' => $stock
        ];

        $result = $Purchase->stock($request);

        echo json_encode($result);
    
    break;

    case 'Damage':
    
        $id = $_POST['purchase_id'];
        $status = $_POST['status'];

        $request = [
            'purchase_id' => $id,
            'status' => $status
        ];

        $result = $Purchase->Damage($request);

        echo json_encode($result);
    
    break;

    case 'damaged':
    
        $id = $_POST['purchase_id'];
        $damaged = $_POST['damaged'];

        $request = [
            'purchase_id' => $id,
            'damaged' => $damaged
        ];

        $result = $Purchase->damaged($request);

        echo json_encode($result);
    
    break;

    case 'Incomplete':
    
        $id = $_POST['purchase_id'];
        $status = $_POST['status'];

        $request = [
            'purchase_id' => $id,
            'status' => $status
        ];

        $result = $Purchase->Incompleted($request);

        echo json_encode($result);
    
    break;

    case 'incomplete':
    
        $id = $_POST['purchase_id'];
        $incomplete = $_POST['incomplete'];

        $request = [
            'purchase_id' => $id,
            'incomplete' => $incomplete
        ];

        $result = $Purchase->incomplete($request);

        echo json_encode($result);
    
    break;

    case 'Theft':
    
        $id = $_POST['purchase_id'];
        $status = $_POST['status'];

        $request = [
            'purchase_id' => $id,
            'status' => $status
        ];

        $result = $Purchase->Thefted($request);

        echo json_encode($result);
    
    break;

    case 'theft':
    
        $id = $_POST['purchase_id'];
        $theft = $_POST['theft'];

        $request = [
            'purchase_id' => $id,
            'theft' => $theft
        ];

        $result = $Purchase->theft($request);

        echo json_encode($result);
    
    break;

    default:
        echo json_encode(['error' => "Invalid action"]);

}

?>