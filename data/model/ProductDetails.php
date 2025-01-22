<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include_once('ActionLog.php');

class ProductDetails
{
    private $conn;
    private $ActionLog;

    private $getAllquery = "SELECT p.id AS product_id, category_id, barcode, p.name AS product_name, sale_price, status, max_stock, min_stock, expired_products,
    c.name AS category_name, 
    pd.id AS product_details_id, pd.lot_num, quantity, buy_price, date_added, manufacture_date, expiration_date, batch, location, expired_status, type, designation
    FROM products p
    INNER JOIN categories as c
    ON p.category_id = c.id
    LEFT JOIN product_details pd
    ON p.id = pd.product_id";


    private $orderBy = " ORDER BY p.id, batch";

    public function __construct($connection)
    {
        $this->conn = $connection;
        $this->ActionLog = new ActionLog($connection);
    }

    public function getAll()
    {
        $sql = $this->getAllquery . $this->orderBy;

        $result = $this->conn->query($sql);
        
        $this->conn->close();

        return $result->fetch_all(MYSQLI_ASSOC);

    }

    public function loadTableData()
    {
        $sql = "SELECT *, products.name AS product_name
        FROM products
        LEFT JOIN categories ON products.category_id = categories.id;";

        $result = $this->conn->query($sql);
        
        $this->conn->close();

        return $result->fetch_all(MYSQLI_ASSOC);

    }

    public function getAllByProductId($product_id)
    {
        $sql = $this->getAllquery . " WHERE product_id = $product_id " . $this->orderBy;

        $result = $this->conn->query($sql);
        
        $this->conn->close();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($product_details_id)
    {
        $sql = $this->getAllquery . " WHERE pd.id = $product_details_id";
        $result = $this->conn->query($sql);

        $this->conn->close();
        return $result->fetch_assoc();
    }

    public function getAllAlertExpired()
    {
        $sql = $this->getAllquery . ' where (DATE(expiration_date) < ADDDATE(DATE(NOW()), +7) ) and designation = 0 ' . $this->orderBy;

        $result = $this->conn->query($sql);
        
        $this->conn->close();

        return $result->fetch_all(MYSQLI_ASSOC);

    }

    public function getAllExpired()
    {
        $sql = $this->getAllquery . ' WHERE expired_status = 1 and quantity != 0' . $this->orderBy;

        $result = $this->conn->query($sql);
        
        $this->conn->close();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllDesignated()
    {
        $sql = $this->getAllquery . ' WHERE expired_status = 2 and designation != 0' . $this->orderBy;

        $result = $this->conn->query($sql);
        
        $this->conn->close();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByAlertId($product_details_id)
    {
        $sql = $this->getAllquery . " WHERE product_id = $product_details_id AND expired_status = 1" . $this->orderBy;

        $result = $this->conn->query($sql);
        
        $this->conn->close();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // public function getAllByStockStatus()
    // {
    //     $sql = $this->getAllquery . ' where stock_status > max ' . $this->orderBy;

    //     $result = $this->conn->query($sql);
        
    //     $this->conn->close();

    //     return $result->fetch_all(MYSQLI_ASSOC);

    // }

    public function save($request)
    {
        $product_id = $request['product_id'];
        $lot_num = $request['lot_num'];
        $quantity = $request['quantity'];
        $buying_price = $request['buying_price'];
        $manufature_date = $request['manufature_date'];
        $expiraton_date = $request['expiraton_date'];
        $date_added = date("Y-m-d H:i:s");
        $location = $request['location'];

        //Added lot_num & NOW() Funcion
        $sql = "INSERT INTO product_details (product_id, lot_number, quantity, buy_price, date_added, manufacture_date, expiration_date, location) VALUES (?,?,?,?,NOW(),?,?,?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issdsss", $product_id, $lot_num, $quantity, $buying_price, $manufature_date, $expiraton_date, $location);
        
        $result = '';
        if ($stmt->execute() === TRUE) {
            $result = "Successfully Save";
            $this->adjustBatchNumber($product_id);
            $this->ActionLog->saveLogs('product_details', 'saved');
        } else {
            $result = "Error: " . $sql . "<br>" . $this->conn->error;
        }

        $this->conn->close();

        return $result;
    }

    
    public function registerProduct($request)
    {
        $txt_product_barcode = $request['txt_product_barcode'];
        $txt_product_name = $request['txt_product_name'];
        $slc_product_category = $request['slc_product_category'];
        $slc_status = $request['slc_status'];
        $slc_type = $request['slc_type'];
        $newly_added = -1;

        $sql = "INSERT INTO products (barcode, name, category_id, status, type, stock_status) VALUES(?,?,?,?,?,?)";   
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssi", $txt_product_barcode, $txt_product_name, $slc_product_category, $slc_status, $slc_type, $newly_added);
        
        $result = '';
        if ($stmt->execute() === TRUE) {
            $result = "Successfully Save";
            $this->ActionLog->saveLogs('add_product_details', 'registered', null, $txt_product_name, null);
        } else {
            $result = "Error: " . $sql . "<br>" . $this->conn->error;
        }

        $this->conn->close();

        return $result;
    }

    public function update($request)
    {
        $product_id = $request['product_id'];
        $product_details_id = $request['product_details_id'];
        $buying_price = $request['buying_price'];
        $lot_num = $request['lot_num'];
        $manufature_date = $request['manufature_date'];
        $expiraton_date = $request['expiraton_date'];
        $quantity = $request['quantity'];
        $location = $request['location'];

        $sql = "UPDATE product_details 
        SET buy_price= ?, lot_number= ?, manufacture_date= ?, expiration_date= ?, quantity= ?, location= ?
        WHERE id= ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("dsssisi", $buying_price, $lot_num, $manufature_date, $expiraton_date, $quantity, $location, $product_details_id);


        $result = '';
        if ($stmt->execute() === TRUE) {
            $result = "Updated Successfully";
            $this->adjustBatchNumber($product_id);
            $this->ActionLog->saveLogs('product_details', 'updated');
        } else {
            $result = "Error updating record: " . $this->conn->error;
        }

        $this->conn->close();

        return $result;
    }

    public function getDesignations()
    {
        $sql = $this->getAllquery . ' WHERE designation = 1 or designation = 2 or designation = 3 ' . $this->orderBy;

        $result = $this->conn->query($sql);
        
        $this->conn->close();

        return $result->fetch_all(MYSQLI_ASSOC);

    }
    public function adjustBatchNumber($product_id)
    {
        $sql = "SELECT id, expiration_date  from product_details WHERE product_id = $product_id and expired_status = 0 ";
        $result = $this->conn->query($sql);

        $product_details = $result->fetch_all(MYSQLI_ASSOC);

        usort($product_details, 'date_compare');

        $counter = 1;
        foreach ($product_details as $product_detail) {
            $product_details_id = $product_detail['id'];
            $sql = "UPDATE product_details SET batch='$counter' WHERE id=$product_details_id";

            $this->conn->query($sql);

            $counter++;
        }
    }

    public function updateExpiredStatus()
    {
        $date_today = date("Y-m-d");

        $sql = "UPDATE product_details SET expired_status = 1 WHERE expiration_date <= '$date_today' AND designation = 0";
        
        $this->conn->query($sql);

        $sql = "SELECT count(*) as total_expired FROM product_details WHERE expired_status = 1 AND expiration_date <= '$date_today'";
       
        $result = $this->conn->query($sql);
        $count = $result->fetch_assoc();

        $_SESSION['alert']['expiredToday'] = $count['total_expired'];
        
        // $this->conn->close();
    }
    public function updateNearExpiration()
    {
        $date_ahead = date('Y-m-d', strtotime('+7 days'));

        $sql = "UPDATE product_details SET expired_status = 0 WHERE expiration_date > '$date_ahead'";
        
        $this->conn->query($sql);

        $sql = "SELECT count(*) as total_near FROM product_details WHERE expired_status = 0 AND (DATE(expiration_date) < ADDDATE(DATE(NOW()), +7) )";
       
        $result = $this->conn->query($sql);
        $count = $result->fetch_assoc();

        $_SESSION['alert']['nearExpire'] = $count['total_near'];
        
        // $this->conn->close();
    }
    
    public function Exchange($request)
    {
        $id = $request['product_details_id'];
        $expired_status = $request['expired_status'];
        $designation = $request['designation'];

        $expired_status = 2;
        $designation = 1;

        $sql = "UPDATE product_details SET expired_status = ?, designation = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $expired_status, $designation, $id);

        $result = '';
        if ($stmt->execute() === TRUE) {
            $result = "Updated Successfully";
            // $this->ActionLog->saveLogs('user', 'updated');
        } else {
            $result = "Error updating record: " . $this->conn->error;
        }

        $this->conn->close();

        return $result;
    }

    public function Return($request)
    {
        $id = $request['product_details_id'];
        $expired_status = $request['expired_status'];
        $designation = $request['designation'];        

        $expired_status = 2;
        $designation = 2;

        $sql = "UPDATE product_details SET expired_status = ?, designation = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $expired_status, $designation, $id);

        $result = '';
        if ($stmt->execute() === TRUE) {
            $result = "Updated Successfully";
            // $this->ActionLog->saveLogs('user', 'updated');
        } else {
            $result = "Error updating record: " . $this->conn->error;
        }

        $this->conn->close();

        return $result;
    }

    public function Decompose($request)
    {
        $id = $request['product_details_id'];
        $expired_status = $request['expired_status'];
        $designation = $request['designation'];

        $expired_status = 2;
        $designation = 3;

        $sql = "UPDATE product_details SET expired_status = ?, designation = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $expired_status, $designation, $id);

        $result = '';
        if ($stmt->execute() === TRUE) {
            $result = "Updated Successfully";
            // $this->ActionLog->saveLogs('user', 'updated');
        } else {
            $result = "Error updating record: " . $this->conn->error;
        }

        $this->conn->close();

        return $result;
    }              
}



function date_compare($element1, $element2) {
    $datetime1 = strtotime($element1['expiration_date']);
    $datetime2 = strtotime($element2['expiration_date']);
    return $datetime1 - $datetime2;
} 