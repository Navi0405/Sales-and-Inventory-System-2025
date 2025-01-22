<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include_once('ActionLog.php');

class User
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
        $sql = "SELECT id, first_name, last_name, username, password, role, status, last_login from users where role != 1";
        $result = $this->conn->query($sql);

        $this->conn->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($user_id)
    {
        $sql = "SELECT id, first_name, last_name, username, password, role, status, last_login FROM users WHERE id = $user_id";
        $result = $this->conn->query($sql);

        $this->conn->close();
        return $result->fetch_assoc();
    }

    public function save($request)
    {
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $username = $request['username'];
        $password = $request['password'];
        $role = $request['role'];
        $status = $request['status'];

        $password = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users(first_name, last_name, username, password, role, status) 
        VALUES (?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssii", $first_name, $last_name, $username, $password, $role, $status);

        $result = '';
        if ($stmt->execute() === TRUE) {
            $result = "Successfully Save";
            $this->ActionLog->saveLogs('user', 'registered', null, null, null, $username);
        } else {
            $result = "Error: <br>" . $this->conn->error;
        }

        $this->conn->close();

        return $result;
    }

    public function update($request)
    {
        $user_id = $request['user_id'];
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $username = $request['username'];
        $role = $request['role'];
        $status = $request['status'];

        $sql = "UPDATE users SET first_name=?, last_name=?, username=?, role=?, status=? WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssiii", $first_name, $last_name, $username, $role, $status, $user_id);

        $result = '';
        if ($stmt->execute() === TRUE) {
            $result = "Updated Successfully";
            $this->ActionLog->saveLogs('user', 'updated');
        } else {
            $result = "Error updating record: " . $this->conn->error;
        }

        $this->conn->close();

        return $result;
    }

    public function update_password($request)
    {
        $password = $request['password'];
        $user_id = $request['user_id'];

        $password = password_hash($password, PASSWORD_BCRYPT);

        $sql = "UPDATE users SET password=? WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $password, $user_id);

        $result = '';
        if ($stmt->execute() === TRUE) {
            $result = "Updated Successfully";
            $this->ActionLog->saveLogs('user', 'change password');
        } else {
            $result = "Error updating record: " . $this->conn->error;
        }

        $this->conn->close();

        return $result;
    }

    public function update_login_details($user_id)
    {

        // $user_id = $request['user_id'];
        date_default_timezone_set("Asia/Singapore");
        $last_login = date('Y-m-d H:i:s');
        // echo $last_login;

        $sql = "UPDATE users SET last_login=? WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $last_login, $user_id);

        $result = '';
        if ($stmt->execute() === TRUE) {
            $result = "Updated Successfully";
        } else {
            $result = "Error updating record: " . $this->conn->error;
        }

        return $result;
    }

    public function update_login_attempt($user_id, $login_attempt)
    {

        $sql = "UPDATE users SET login_attempt=? WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $login_attempt, $user_id);

        $result = '';
        if ($stmt->execute() === TRUE) {
            $result = "Updated Successfully";
        } else {
            $result = "Error updating record: " . $this->conn->error;
        }

        return $result;
    }

    public function update_status($user_id, $status)
    {

        $sql = "UPDATE users SET status=? WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $status, $user_id);

        $result = '';
        if ($stmt->execute() === TRUE) {
            $result = "Updated Successfully";
        } else {
            $result = "Error updating record: " . $this->conn->error;
        }

        return $result;
    }

    public function verify_login($request)
    {
        $username = $request['username'];
        $password = $request['password'];

        $sql = "SELECT id, password, first_name, last_name, role, login_attempt, status FROM users where username = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();


        $id = 0;
        $db_password = "";
        $first_name = "";
        $last_name = "";
        $role = "";
        $login_attempt = "";
        $status = "";
        $stmt->bind_result($id, $db_password, $first_name, $last_name, $role, $login_attempt, $status);
        $stmt->fetch();


        if ($status == 0) {
            return "Account is deactivated";
        } else if (password_verify($password, $db_password)) {
            $stmt->free_result();

            $_SESSION['user'] = [
                'id' => $id,
                'fullname' => $first_name . ' ' . $last_name,
                'role' => $role,
                'username' => $username,
                'password' => $password,
            ];
            $this->update_login_attempt($id, 0);
            $this->update_login_details($id);

            $this->ActionLog->saveLogs('login', null, null, null, null, $username);
            return "Validated";
        } else {
            $stmt->free_result();

            $login_attempt ++;

            if ($role != 1){
            $this->update_login_attempt($id, $login_attempt);
            }
            if ($login_attempt == 3) {
                $this->update_status($id, 0);
                return "Your Account has been lock due to many attempts. Please contact System admin.";
            }
            return "Invalid Username or Password";
        }
    }

    // public function delete($user_id)
    // {
    //     $sql = "DELETE FROM users WHERE id=$user_id";

    //     $result = '';
    //     if ($this->conn->query($sql) === TRUE) {
    //         $result = "Deleted Successfully";

    //         $this->ActionLog->saveLogs('user', 'deleted');
    //     } else {
    //         $result = "Error deleting record: " . $this->conn->error;
    //     }

    //     $this->conn->close();

    //     return $result;
    // }

    public function validateAdminPassword($password)
    {
        $sql = "SELECT username,password from users where role != 3 and status = 1";
        $result = $this->conn->query($sql);

        $this->conn->close();
        $adminUsers =  $result->fetch_all(MYSQLI_ASSOC);

        $match = false;
        foreach ($adminUsers as $adminUser) {
            if (password_verify($password, $adminUser['password'])) {
                $match = true;
            }
        }
        return $match;
    }

    public function getCurrentPassword($password)
    {
        $sql = "SELECT password from user";
        $result = $this->conn->query($sql);

        return $result;
    }








}
