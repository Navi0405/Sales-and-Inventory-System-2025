<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

include_once('ActionLog.php');

class Category
{
    private $conn;
    private $ActionLog;

    public function __construct($connection)
    {
        $this->conn = $connection;
        $this->ActionLog = new ActionLog($connection);
    }

    public function getAll()
    {
        $sql = "SELECT id, name from categories";
        $result = $this->conn->query($sql);

        $this->conn->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($category_id)
    {
        $sql = "SELECT id, name FROM categories WHERE id = $category_id";
        $result = $this->conn->query($sql);

        $this->conn->close();
        return $result->fetch_assoc();
    }

    public function save($request)
    {
        $category_name = $request['name'];

        $sql = "INSERT INTO categories(name) VALUES (?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s",$category_name);

        $result = '';
        if ($stmt->execute() === TRUE) {
            $result = "Successfully Save";

            $this->ActionLog->saveLogs('add_category', 'added', $category_name, null, null);
        } else {
            $result = "Error: <br>" . $this->conn->error;
        }

        $this->conn->close();

        return $result;
    }

    public function update($request)
    {
        $category_id = $request['id'];
        $category_name = $request['name'];

        $sql = "UPDATE categories SET name=? WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si",$category_name, $category_id);

        $result = '';
        if ($stmt->execute() === TRUE) {
            $result = "Updated Successfully";

            $this->ActionLog->saveLogs('update_category', 'updated', $category_name);
        } else {
            $result = "Error updating record: " . $this->conn->error;
        }

        $this->conn->close();

        return $result;
    }

    public function delete($category_id, $category_name)
    {
        $sql = "DELETE FROM categories WHERE id=$category_id";

        $result = '';
        if ($this->conn->query($sql) === TRUE) {
            $result = "Deleted Successfully";

            $this->ActionLog->saveLogs('category', 'deleted', $category_name);
        } else {
            $result = "Error deleting record: " . $this->conn->error;
        }

        $this->conn->close();

        return $result;


    }

    public function getReportLastSixMonths()
    {
        $month = date("Y-m", strtotime("-5 months"));
        $date = $month . '-' . '01';
    
        $sql = "SELECT c.name AS category_name,  SUBSTRING(s.date_purchased,1,7) as month, sum(s.qty) as total
        FROM categories c 
        INNER JOIN products p 
        ON c.id = p.category_id 
        INNER JOIN sales s 
        ON p.id = s.product_id
        WHERE s.date_purchased >= $date and s.void is null
        GROUP BY c.name,  SUBSTRING(s.date_purchased,1,7)
        ORDER BY SUBSTRING(s.date_purchased,1,7), c.name, sum(s.qty)";

        $result = $this->conn->query($sql);

        $this->conn->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
