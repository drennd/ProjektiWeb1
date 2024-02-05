< <?php 

include 'db_connection.php';

class UserController {

    public function __construct() {
        global $conn;  
        $this->conn = $conn;
    }

    public function all() {
        // Merr të gjitha të dhënat nga tabela 'users'
        $query = "SELECT * FROM users";
        $result = $this->conn->query($query);
        return $result;
    }

    public function get(){
        // Merr një përdorues nga tabela 'users' bazuar në ID e marrë nga URL
        $userID = $_GET['id'];
        $query = "SELECT * FROM users WHERE ID = $userID";
        $result = $this->conn->query($query);
        return $result;
    }
    
    public function edit($username, $email, $role){
        // Merr ID e përdoruesit nga URL dhe ben update të dhënat e përdoruesit në bazën e të dhënave
        $userID = $_GET['id'];
        $updateQuery = "UPDATE users SET username='$username', email='$email', role='$role' WHERE ID=$userID";
        $this->conn->query($updateQuery);
        // Kthehet prapa në seksionin e menaxhimit të përdoruesve
        header('Location: Dashboard.php?action=manageUsers');
        exit();
    }

    public function delete(){
        // Merr ID e përdoruesit për të fshirë dhe ekzekuton një query DELETE në tabelën 'users'
        $userIDToDelete = $_GET['deleteUser'];
        $deleteQuery = "DELETE FROM users WHERE ID = $userIDToDelete";
        $this->conn->query($deleteQuery);
    }

}

?>
