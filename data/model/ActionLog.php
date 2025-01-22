<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

class ActionLog
{
    private $conn;

    public function __construct($connection)
    {
        $this->conn = $connection;
        date_default_timezone_set('Asia/Singapore');
    }

    public function getAll()
    {
        $sql = "SELECT * from action_logs";
        $result = $this->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function save($request)
    {
        date_default_timezone_set("Asia/Singapore");
        $datetime = $request['datetime'];
        $role = $request['role'];
        $username = $request['username'];
        $action = $request['action'];

        $sql = "INSERT INTO action_logs(datetime,role,username,action) VALUES (?,?,?,?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss",$datetime,$role,$username,$action);

        $result = '';
        if ($stmt->execute() === TRUE) {
            $result = "Successfully Save";
        } else {
            $result = "Error: <br>" . $this->conn->error;
        }

        return $result;
    }

    public function saveLogs($method, 
                             $action = null, 
                             $category_name = null, 
                             $product_name = null, 
                             $txt_product_name = null, 
                             $username = null,
                             $invoice_number = null
                             )
    {
        $role = '';

        switch ($_SESSION['user']['role']) {
            case 1:
                $role = 'Owner';
                break;
            case 2:
                $role = 'Admin';
                break;
            case 3:
                $role = 'User';
                break;
            
            default:
                # code...
                break;
        }

        $request = [
            'datetime' => date("Y-m-d H:i:s"),
            'role' => $role,
            'username' => $_SESSION['user']['username'],
            'action' => ''
        ];


        switch ($method) {
            case 'add_category':
                $request['action'] = 'Successfully ' . $action . ' the Category ' . $category_name;
                break;
            case 'update_category':
                $request['action'] = 'Successfully ' . $action . ' the Category ' . $category_name;
                break;
            case 'update_product':
                $request['action'] = 'Successfully ' . $action . ' the Product ' . $product_name;
                break;
            case 'add_product_details':
                $request['action'] = 'Successfully ' . $action . ' the Product '. $txt_product_name;
                break;
            case 'user':
                $request['action'] = 'Successfully ' . $action . ' ' . $username . ' as a User';
                break;
            case 'invoice':
                $request['action'] = 'Successfully ' . $action . ' the Invoice';
                break;
            case 'login':
                $request['action'] = $username . ' has logged in';
                break;
            case 'logout':
                $request['action'] = $username . ' has logged out';
                break;
            case 'void':
                $request['action'] = $username . ' voided the invoice ' . $invoice_number;
                break;
            default:
                # code...
                break;
        }

        $this->save($request);
    }
}
