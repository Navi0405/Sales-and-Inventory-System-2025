<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include_once('ActionLog.php');

class Invoice
{
    private $conn;
    private $ActionLog;
     
    public function __construct($connection)
    {
        $this->conn = $connection;
        $this->ActionLog = new ActionLog($connection);
    }

    public function save($data, $discounted, $customerName, $osca_number, $cashPayment)
    {

        $this->conn->begin_transaction();

        try {
            $totalPrice = 0;
            date_default_timezone_set("Asia/Singapore");
            $currentDateTime = date('Y-m-d H:i:s');
            $sales = [];

            foreach ($data as $product) {

                $barcode = $product['barcode'];
                $requiredQuantity = $product['quantity'];

                $sql_product = "SELECT
                p.id AS product_id, p.name AS product_name, p.barcode AS barcode, p.sale_price AS price, p.type AS product_type,
                pd.id AS detail_id, pd.quantity AS quantity, pd.expired_status AS expired_status, pd.batch AS batch
                FROM products p 
                INNER JOIN product_details pd ON pd.product_id = p.id 
                WHERE expired_status = 0
                AND p.barcode = $barcode
                AND quantity != 0
                ORDER BY pd.batch ASC";
                $result_product = $this->conn->query($sql_product);

                $items = $result_product->fetch_all(MYSQLI_ASSOC);
                $firstLoop = true;
                foreach ($items as $item) {

                    $item_id = $item['detail_id'];
                    $remaining = $item['quantity'];

                    $sale = [
                        'product_id' => $item['product_id'],
                        'product_detail_id' => $item_id,
                        'date_purchased' => $currentDateTime,
                    ];

                    if ($requiredQuantity >= $remaining) {
                        $sale['qty'] = $remaining;
                        $requiredQuantity = $requiredQuantity - $remaining;
                        $remaining = 0;
                    } else {
                        $sale['qty'] = $requiredQuantity;
                        $remaining = $remaining - $requiredQuantity;
                        $requiredQuantity = 0;
                    }

                    //
                    $productPrice = $sale['qty'] * $item['price'];
                    if ($discounted === 'discounted') {
                        if ($item['product_type'] === 'branded') {
                            $productPrice = $productPrice - ($productPrice * 0.08);
                        } else if ($item['product_type'] === 'generic') {
                            $productPrice = $productPrice - ($productPrice * 0.2);
                        } else {
                            //
                        }
                    }
                    $totalPrice += $productPrice;

                    $sale['product_id'] = $item['product_id'];
                    $sale['price'] = $productPrice;



                    $sql_item = "UPDATE product_details SET
                    quantity = ? WHERE id = ?";
                    $stmt_item = $this->conn->prepare($sql_item);
                    $stmt_item->bind_param("ii", $remaining, $item_id);
                    $stmt_item->execute();

                    $sales[] = $sale;
                    if ($requiredQuantity == 0) {
                        break;
                    }
                }
            }



            $invoice_data = [
                'number' => date('YmdHis'),
                'user_id' => 1,
                'date_transact' => $currentDateTime,
                'total_items' => count($data),
                'total_purchase' => $totalPrice
            ];

            $discountCounter = ($discounted === "discounted") ? 1 : 0;

            $sql_invoice = "INSERT INTO invoices (number, user_id, date_transact, total_items, total_purchase, costumer_name, osca_number, cash_payment, discount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_invoice = $this->conn->prepare($sql_invoice);
            $stmt_invoice->bind_param(
                "sisidssdi",
                $invoice_data['number'],
                $invoice_data['user_id'],
                $invoice_data['date_transact'],
                $invoice_data['total_items'],
                $invoice_data['total_purchase'],
                $customerName,
                $osca_number,
                $cashPayment,
                $discountCounter
            );
            $stmt_invoice->execute();
            $last_invoice_id = $this->conn->insert_id;

            // echo '<pre>';
            // print_r($sales);
            // echo '</pre>';

            foreach ($sales as $sale) {
                $sql = "INSERT INTO sales (product_id, price, qty, date_purchased, invoice_id, product_detail_id) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param(
                    "idisii",
                    $sale['product_id'],
                    $sale['price'],
                    $sale['qty'],
                    $sale['date_purchased'],
                    $last_invoice_id,
                    $sale['product_detail_id']
                );
                $stmt->execute();
            }



            $this->conn->commit();

            $this->ActionLog->saveLogs('invoice', 'saved');
            return $last_invoice_id;
        } catch (mysqli_sql_exception $exception) {
            $this->conn->rollback();

            throw $exception;
        }
    }

    public function getAll()
    {
        $sql = "SELECT * from invoice";
        $result = $this->conn->query($sql);

        $this->conn->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalSalesToday()
    {
        $currentDate = date('Y-m-d');
        $sql = "SELECT sum(total_purchase) as total_sales from invoices where  SUBSTRING(date_transact,1,10) = '$currentDate'";
        $result = $this->conn->query($sql);

        $this->conn->close();
        return $result->fetch_assoc();
    }

    public function searchDaily($date)
    {
        $sql = "SELECT invoices.*,
        CONCAT(users.first_name, ' ', users.last_name) AS users_name
        FROM invoices
        INNER JOIN users ON users.id = invoices.user_id
        WHERE  DATE(invoices.date_transact) = '$date'";
        $result = $this->conn->query($sql);

        $this->conn->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchMonthly($yearmonth)
    {
        $sql = "SELECT invoices.*,
        CONCAT(users.first_name, ' ', users.last_name) AS users_name
        FROM invoices
        INNER JOIN users ON users.id = invoices.user_id
        WHERE YEAR(invoices.date_transact) = '$yearmonth[0]'
        AND MONTH(invoices.date_transact) = '$yearmonth[1]'";
        $result = $this->conn->query($sql);

        $this->conn->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchRange($start, $end)
    {
        $sql = "SELECT invoices.*,
        CONCAT(users.first_name, ' ', users.last_name) AS users_name
        FROM invoices
        INNER JOIN users ON users.id = invoices.user_id
        WHERE  DATE(invoices.date_transact) >= '$start'
        AND DATE(invoices.date_transact) <= '$end'
        ";
        $result = $this->conn->query($sql);

        $this->conn->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getInvoiceSales($invoice_id)
    {
        // $sql = "SELECT 
        // p.name,
        // sales.*
        // FROM `sales` 
        // INNER JOIN `products` p ON p.id =sales.product_id
        // INNER JOIN `product_details` pd ON pd.id = sales.product_detail_id
        // WHERE invoice_id = $invoice_id";
        $sql = "SELECT 
        i.id AS invoice_id,
        p.name,
        p.id AS product_id,
        SUM(price) AS price,
        SUM(qty) AS qty,
        sales.void
        FROM `sales` 
        INNER JOIN `invoices` i ON i.id = sales.invoice_id
        INNER JOIN `products` p ON p.id = sales.product_id
        INNER JOIN `product_details` pd ON pd.id = sales.product_detail_id
        WHERE invoice_id = $invoice_id
        GROUP BY p.id, sales.void";
    
        $result = $this->conn->query($sql);

        $this->conn->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function voidItem($invoice_id, $product_id)
    {

        //Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Get the username from the session
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown User';

        $sql = "SELECT * FROM
        sales
        WHERE sales.invoice_id = $invoice_id
        AND sales.product_id = $product_id
        ";
        $result = $this->conn->query($sql);

        $sales = $result->fetch_all(MYSQLI_ASSOC);

        $total_price_deduction = 0;

        foreach ($sales as $sale) {
            $total_price_deduction += $sale['price'];
            $sale_id = $sale['id'];
            $product_detail_id = $sale['product_detail_id'];


            $sql_get_pd = "SELECT * FROM product_details WHERE id = $product_detail_id";
            $result_get_pd = $this->conn->query($sql_get_pd);
            $product_detail = $result_get_pd->fetch_assoc();

            $new_pd_quantity = $product_detail['quantity'] + $sale['qty'];

            $sql_pd = "UPDATE product_details SET quantity = ? WHERE id = ?";
            $sql_pd = $this->conn->prepare($sql_pd);
            $sql_pd->bind_param("ii", $new_pd_quantity, $product_detail_id);
            $sql_pd->execute();

            $true = 1;
            $sql_void = "UPDATE sales SET void = ? WHERE id = ?";
            $sql_void = $this->conn->prepare($sql_void);
            $sql_void->bind_param("ii", $true, $sale_id);
            $sql_void->execute();
        }

        $sql_get_invoice = "SELECT * FROM invoices WHERE id = $invoice_id";
        $result_get_invoice = $this->conn->query($sql_get_invoice);
        $invoice = $result_get_invoice->fetch_assoc();


        $invoice_total_items = $invoice['total_items'] - 1;
        $invoice_new_total_purchase = $invoice['total_purchase'] - $total_price_deduction;
        $invoice_number = $invoice['number'];

        $sql_pd = "UPDATE invoices SET total_items = ?, total_purchase = ? WHERE id = ?";
        $sql_pd = $this->conn->prepare($sql_pd);
        $sql_pd->bind_param("iii", $invoice_total_items, $invoice_new_total_purchase, $invoice_id);
        $sql_pd->execute();

        $this->ActionLog->saveLogs('void', null, null, null, null, $username, $invoice_number);

        // Add a return statement with a status message or boolean
        return ["status" => "success", "message" => "Item voided successfully"];
    }

    public function getReceipt($invoice_id)
    {
        $sql = "SELECT * 
        FROM invoices i
        INNER JOIN users u 
        ON i.user_id = u.id
        WHERE i.id = $invoice_id";

        $result = $this->conn->query($sql);
        $details = $result->fetch_assoc();

        $sql = "SELECT 
		i.id AS invoice_id,
        p.barcode,
        p.name,
        p.id AS product_id,
        SUM(price) AS price,
        SUM(qty) AS qty,
        p.sale_price
        FROM `sales` 
        INNER JOIN `invoices` i ON i.id = sales.invoice_id
        INNER JOIN `products` p ON p.id =sales.product_id
        INNER JOIN `product_details` pd ON pd.id = sales.product_detail_id
        WHERE invoice_id = $invoice_id
        AND sales.void IS NULL
        GROUP BY p.id";
        $result = $this->conn->query($sql);

        $this->conn->close();
        $sales = $result->fetch_all(MYSQLI_ASSOC);

        return [
            'details' => $details,
            'sales' => $sales
        ];

    }
}