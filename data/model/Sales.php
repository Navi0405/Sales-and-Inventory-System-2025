<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

class Sales
{
    private $conn;

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    public function getReport($dateFrom, $dateTo){
        $sql = "SELECT p.id, p.name as product_name, SUM(s.qty) AS total_sales, SUM(s.price) as total_price, s.date_purchased as bought, s.invoice_id as transact
        FROM products p
        INNER JOIN sales s
        ON p.id = s.product_id
        WHERE s.void is null and SUBSTRING(s.date_purchased,1,10) between '$dateFrom' and '$dateTo'
        GROUP by p.id, p.name";
        $result = $this->conn->query($sql);
        

        $this->conn->close();
        return $result->fetch_all(MYSQLI_ASSOC);

        // $result = $this->conn->query($sql);

        // $this->conn->close();
        // $excel = $result->fetch_all(MYSQLI_ASSOC);
        // return ['export' => $excel];  

    }

    //     public function getAll($result)
    // {
    //     $sql = $this->getReport;

    //     $result = $this->conn->query($sql);
        
    //     $this->conn->close();

    //     return $result->fetch_all(MYSQLI_ASSOC);

    // }
}
