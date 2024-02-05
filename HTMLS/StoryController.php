<?php 

include 'db_connection.php';

class StoryController {

    //Krijon lidhjen/constructin per lidhjen e Klases me databaze
    public function __construct() {
        global $conn; // Use the global keyword to access the $conn variable
        $this->conn = $conn;
    }
    //Merr te gjitha vlerat prej tabeles images
    public function all() {
        $query = "SELECT * FROM images";
        $result = $this->conn->query($query);
        return $result;
    }

    //Merr vlerat e percaktume nga ID (te Edit dmth kur klikon butonin edit te njeres Story)
    public function get(){
        $storyID = $_GET['id'];
        $query = "SELECT * FROM images WHERE ID = $storyID";
        $result = $this->conn->query($query);
        return $result;
    }
    

    public function edit($editedStoryName, $editedStoryDescription, $editedStoryImage) {
        $storyID = $_GET['id'];
    
        // Kontrollon nese eshte upload foto tjeter
        if (!empty($editedStoryImage['name'])) {
            $editedStoryImagePath = 'uploads/' . $editedStoryImage['name'];
    
            // Kaloje foton ne poziten e duhur ne databaze
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
            // Boja update vlerave ne databaze te cilat jane tekst (name,descrption)
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
        //StoryImagePath run pathin per uploads/ ku merret fotoja dhe lidhet me storyImage
        $storyImagePath = 'uploads/' . $storyImage['name'];
        
        $storyDate = date('y/m/d'); //Koha e caktume kur e shton storyn

        // Levrite foton e caktuar ne pathin e percaktuar me lart /uploads
        if (move_uploaded_file($storyImage['tmp_name'], $storyImagePath)) {
            //Shtimi i vlerave ne tabele per cfaredo vlere (ssss jon parametrat te cilat zevendsohen)
            //ne vlerat e shtuara ne databaze
            $insertQuery = "INSERT INTO Images (name, descrption, time, imgPath) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($insertQuery);
            $stmt->bind_param("ssss", $storyName, $storyDescription, $storyDate, $storyImagePath);
            $stmt->execute();//ekzekuton procesin
    
            // Redirect to refresh the page and avoid form resubmission
            header('Location: Home.php?action=manageStories');
            exit();
        } else {
            echo "Error moving the uploaded file.";
        }
    }
    
    
    //Caktohet StoryId qe bohet delete tani prej qasaj thirret query qe tani te perdoret query ntabele
    public function delete(){
        $StoryIDtoDelete = $_GET['deleteStory'];
        $deleteQuery = "DELETE FROM images WHERE ID = $StoryIDtoDelete";
        $this->conn->query($deleteQuery);
    }

    //GetLatest Stories merr te gjitha Stories prej imgs ne menyre descending 10 copa
    public function getLatestStories($limit = 10) {
        $latestStoryQuery = "SELECT * FROM Images ORDER BY time DESC LIMIT ?";
        $stmt = $this->conn->prepare($latestStoryQuery);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        //array empty v
        $latestStories = [];
    
        $result = $stmt->get_result();
        //percakton fotot vlerat ku ruhen ne vlerat row sipas yes.
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