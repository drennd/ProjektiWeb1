<?php 

include 'db_connection.php';

class StoryController {

    public function __construct() {
        global $conn; // Use the global keyword to access the $conn variable
        $this->conn = $conn;
    }

    public function all() {
        $query = "SELECT * FROM images";
        $result = $this->conn->query($query);
        return $result;
    }

    public function get(){
        $storyID = $_GET['id'];
        $query = "SELECT * FROM images WHERE ID = $storyID";
        $result = $this->conn->query($query);
        return $result;
    }
    
    public function edit($editedStoryName, $editedStoryDescription, $editedStoryImage) {
        $storyID = $_GET['id'];
    
        // Check if a new image file is uploaded
        if (!empty($editedStoryImage['name'])) {
            $editedStoryImagePath = 'uploads/' . $editedStoryImage['name'];
    
            // Move uploaded image to the specified path
            if (move_uploaded_file($editedStoryImage['tmp_name'], $editedStoryImagePath)) {
                // Update story data including the new image path
                $updateStoryQuery = "UPDATE Images SET name=?, descrption=?, imgPath=? WHERE ID=?";
                $stmt = $this->conn->prepare($updateStoryQuery);
                $stmt->bind_param("sssi", $editedStoryName, $editedStoryDescription, $editedStoryImagePath, $storyID);
                $stmt->execute();
            } else {
                echo "Error moving the uploaded file.";
            }
        } else {
            // Update story data without changing the image
            $updateStoryQuery = "UPDATE Images SET name=?, descrption=? WHERE ID=?";
            $stmt = $this->conn->prepare($updateStoryQuery);
            $stmt->bind_param("ssi", $editedStoryName, $editedStoryDescription, $storyID);
            $stmt->execute();
        }
    
        // Redirect back to the story management section
        header('Location: Home.php?action=manageStories');
        exit();
    }

    public function addStory($storyName, $storyDescription, $storyImage) {
        // Handle form submission to add a new story
        $storyImagePath = 'uploads/' . $storyImage['name'];
        $storyDate = date('y/m/d');
        // Move uploaded image to the specified path
        if (move_uploaded_file($storyImage['tmp_name'], $storyImagePath)) {
            // Insert new story into the database
            $insertQuery = "INSERT INTO Images (name, descrption, time, imgPath) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($insertQuery);
            $stmt->bind_param("ssss", $storyName, $storyDescription, $storyDate, $storyImagePath);
            $stmt->execute();
    
            // Redirect to refresh the page and avoid form resubmission
            header('Location: Home.php?action=manageStories');
            exit();
        } else {
            echo "Error moving the uploaded file.";
        }
    }
    
    

    public function delete(){
        $StoryIDtoDelete = $_GET['deleteStory'];
        $deleteQuery = "DELETE FROM images WHERE ID = $StoryIDtoDelete";
        $this->conn->query($deleteQuery);
    }


    public function getLatestStories($limit = 10) {
        $latestStoryQuery = "SELECT * FROM Images ORDER BY time DESC LIMIT ?";
        $stmt = $this->conn->prepare($latestStoryQuery);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
    
        $latestStories = [];
    
        $result = $stmt->get_result();
    
        while ($row = $result->fetch_assoc()) {
            $latestStories[] = [
                'imgPath' => $row['imgPath'],
                'name' => $row['name'],
                'descrption' => $row['descrption'],
                'time' => date("d F Y", strtotime($row['time']))
            ];
        }
    
        return $latestStories;
    }

}

?>