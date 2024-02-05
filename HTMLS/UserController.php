<?php 

include 'db_connection.php';

class UserController {

    public function __construct() {
        global $conn; // Use the global keyword to access the $conn variable
        $this->conn = $conn;
    }

    public function all() {
        $query = "SELECT * FROM users";
        $result = $this->conn->query($query);
        return $result;
    }

    public function get(){
        $userID = $_GET['id'];
        $query = "SELECT * FROM users WHERE ID = $userID";
        $result = $this->conn->query($query);
        return $result;
    }
    
    public function edit($username, $email, $role){
        $userID = $_GET['id'];
        // Update user data in the database
        $updateQuery = "UPDATE users SET username='$username', email='$email', role='$role' WHERE ID=$userID";
        $this->conn->query($updateQuery);
        // Redirect back to the user management section
        header('Location: Dashboard.php?action=manageUsers');
        exit();
    }

    public function delete(){
        $userIDToDelete = $_GET['deleteUser'];
        $deleteQuery = "DELETE FROM users WHERE ID = $userIDToDelete";
        $this->conn->query($deleteQuery);
    }

}

?>