<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

class Sale
{
    private $conn;

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    public function searchDaily($date)
    {
        $sql = "SELECT
        i.number AS invoice_number,
        p.name,
        SUM(sales.price) AS price,
        SUM(sales.qty) AS quantity,
        date_purchased,
        invoice_id
        FROM `sales` 
        INNER JOIN products p ON p.id = sales.product_id
        INNER JOIN invoices i ON i.id = sales.invoice_id
        WHERE void IS NULL
        AND DATE(date_purchased) = '$date'
        GROUP BY i.number,p.name, date_purchased, invoice_id";

        $result = $this->conn->query($sql);

        $this->conn->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchMonthly($yearmonth)
    {
        $sql = "SELECT
        i.number AS invoice_number,
        p.name,
        SUM(sales.price) AS price,
        SUM(sales.qty) AS quantity,
        date_purchased,
        invoice_id
        FROM `sales` 
        INNER JOIN products p ON p.id = sales.product_id
        INNER JOIN invoices i ON i.id = sales.invoice_id
        WHERE void IS NULL
        AND YEAR(date_purchased) = '$yearmonth[0]'
        AND MONTH(date_purchased) = '$yearmonth[1]'
        GROUP BY i.number,p.name, date_purchased, invoice_id";
        $result = $this->conn->query($sql);

        $this->conn->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchRange($start, $end)
    {
        $sql = "SELECT
        i.number AS invoice_number,
        p.name,
        SUM(sales.price) AS price,
        SUM(sales.qty) AS quantity,
        date_purchased,
        invoice_id
        FROM `sales` 
        INNER JOIN products p ON p.id = sales.product_id
        INNER JOIN invoices i ON i.id = sales.invoice_id
        WHERE void IS NULL
        AND DATE(date_purchased) >= '$start'
        AND DATE(date_purchased) <= '$end'
        GROUP BY i.number,p.name, date_purchased, invoice_id";

        $result = $this->conn->query($sql);

        $this->conn->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
