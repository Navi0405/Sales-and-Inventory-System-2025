<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include_once('ActionLog.php');

class Purchase
{
    private $conn;
    private $ActionLog;

    private $commonSql = "SELECT p.id AS purchase_id, orders, quantity, amount, order_date, receiving_date, supplier, status, paid, delivery, received, stock, damaged, incomplete, theft FROM purchase p";

    private $orderBy = " ORDER BY p.id ";

    public function __construct($connection)
    {
        $this->conn = $connection;
        $this->ActionLog = new ActionLog($connection);
    }

    public function getAllPurchases()
    {
        $sql = $this->commonSql . $this->orderBy ;
        $result = $this->conn->query($sql);

        $this->conn->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function save($request)
    {
        $currentDate = date('Y-m-d');

        $orders = $request['orders'];
        $quantity = $request['quantity'];
        $amount = $request['amount'];
        $order_date = $currentDate; 
        $receiving_date = $request['receiving_date'];
        $supplier = $request['supplier'];

        $sql = "INSERT INTO purchase(orders, quantity, amount, order_date, receiving_date, supplier) VALUES (?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("siisss",$orders,$quantity,$amount,$order_date,$receiving_date,$supplier);

        $result = '';
        if ($stmt->execute() === TRUE) {
            $result = "Successfully Save";

        } else {
            $result = "Error: <br>" . $this->conn->error;
        }

        $this->conn->close();

        return $result;
    }

    public function getById($purchase_id)
    {
        $sql = "SELECT id FROM purchase WHERE id = $purchase_id";
        $result = $this->conn->query($sql);

        $this->conn->close();
        return $result->fetch_assoc();
    }

    public function Pay($request)
    {
        $id = $request['purchase_id'];
        $status = $request['status'];

        $status = 1;

        $sql = "UPDATE purchase SET status = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $status, $id);

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

    public function paid($request)
    {
        $id = $request['purchase_id'];
        $paid = $request['paid'];

        $paid = date('Y-m-d');

        $sql = "UPDATE purchase SET paid = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $paid, $id);

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

    public function Deliver($request)
    {
        $id = $request['purchase_id'];
        $status = $request['status'];

        $status = 2;

        $sql = "UPDATE purchase SET status = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $status, $id);

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

    public function delivery($request)
    {
        $id = $request['purchase_id'];
        $delivery = $delivery['delivery'];

        $delivery = date('Y-m-d');

        $sql = "UPDATE purchase SET delivery = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $delivery, $id);

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

    public function Receive($request)
    {
        $id = $request['purchase_id'];
        $status = $request['status'];

        $status = 3;

        $sql = "UPDATE purchase SET status = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $status, $id);

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

    public function received($request)
    {
        $id = $request['purchase_id'];
        $received = $received['received'];

        $received = date('Y-m-d');

        $sql = "UPDATE purchase SET received = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $received, $id);

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

    public function Stocked($request)
    {
        $id = $request['purchase_id'];

        $status = $request['status'];

        $status = 4;

        $sql = "UPDATE purchase SET status = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $status, $id);

        $result = '';
        if ($stmt->execute() === TRUE) {
            $result = "Updated Successfully";
            // $this->ActionLog->saveLogs('user', 'updated');
        } else {
            $result = "Error updating record: " . $this->conn->error;
        }
    }

    public function stock($request)
    {
        $id = $request['purchase_id'];
        $stock = $stock['stock'];

        $stock ++;

        $sql = "UPDATE purchase SET stock = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $stock, $id);

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

    public function Damage($request)
    {
        $id = $request['purchase_id'];

        $status = $request['status'];

        $status = 5;

        $sql = "UPDATE purchase SET status = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $status, $id);

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

    public function damaged($request)
    {
        $id = $request['purchase_id'];
        $damaged = $damaged['damaged'];

        $damaged ++;

        $sql = "UPDATE purchase SET damaged = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $damaged, $id);

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

    public function Incompleted($request)
    {
        $id = $request['purchase_id'];

        $status = $request['status'];

        $status = 6;

        $sql = "UPDATE purchase SET status = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $status, $id);

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

    public function incomplete($request)
    {
        $id = $request['purchase_id'];
        $incomplete = $incomplete['incomplete'];

        $incomplete ++;

        $sql = "UPDATE purchase SET incomplete = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $incomplete, $id);

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

    public function Thefted($request)
    {
        $id = $request['purchase_id'];

        $status = $request['status'];

        $status = 7;

        $sql = "UPDATE purchase SET status = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $status, $id);

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

    public function theft($request)
    {
        $id = $request['purchase_id'];
        $theft = $theft['theft'];

        $theft ++;

        $sql = "UPDATE purchase SET theft = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $theft, $id);

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

    // public function getById($purchase_id)
    // {
    //     $sql = $this->getAllquery . " WHERE p.id = $purchase_id";
    //     $result = $this->conn->query($sql);

    //     $this->conn->close();
    //     return $result->fetch_assoc();
    // }

        // public function getAllPurchases()
        // {
        //     $sql = $this->PurchaseSql . $this->orderBy;
        //     $result = $this->conn->query($sql);
    
        //     $this->conn->close();

        //     return $result->fetch_all(MYSQLI_ASSOC);
        // }

}

?>