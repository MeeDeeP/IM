<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "proj1";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
if(isset($_POST['saveAssignment'])){
    try {
        $stmt = $conn->prepare("CALL updateAssignmentlist(:_ass_title,:_total_score,:_subjectId,:_ass_no)");
        $stmt->bindParam(':_ass_title', $_POST['title']);
        $stmt->bindParam(':_total_score', $_POST['score']);
        $stmt->bindParam(':_subjectId', $_POST['subject']);
        $stmt->bindParam(':_ass_no', $_GET['id']);
    
        $stmt->execute();
        echo "<script>alert('Edited Successfully.');</script>";
        header("Location: assignment.php");
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Assignment List</title>
</head>
<body>
    
<nav class="navbar">
        <div class="container">
            <div class="menu">
                <a href="stud_add.php">Students</a>
                <a href="subjects.php">Subjects</a>
                <a href="assignment.php">Assignments</a>
                <a href="stud_assigned.php">Assign</a>
            </div>
        </div>
    </nav>

    <div class="content">
        <form action="" method="POST" style="border: 1px solid #000; padding: 20px;">
        <?php 
            if(!isset($_GET['id'])){
                header("Location: assignment.php");
            }
            try {
                $stmt = $conn->prepare("SELECT * FROM tblassignmentlist where ass_no=:_ass_no");
                $stmt->bindParam(':_ass_no', $_GET['id']);
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $rowCount = $stmt->rowCount();
            if($rowCount==0){
                header("Location: assignment.php");
            }
            foreach($stmt->fetchAll() as $row) {
        ?>
            <div style="display: flex;">
                <div>
                    <label for="">Title</label> <br>
                    <input type="text" name="title" value="<?php echo $row['ass_title']; ?>" class="input-field">
                </div>
                <div>
                    <label for="">Score</label> <br>
                    <input type="number" name="score" value="<?php echo $row['total_score']; ?>" class="input-field">
                </div>
                <div>
                    <label for="">Subject</label><br>
                    <select name="subject" id="" class="select-field">
                        <?php
                            try {
                                $stmt = $conn->prepare("SELECT * FROM tblsubject");
                                $stmt->execute();
                                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                            } catch(PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            
                            foreach($stmt->fetchAll() as $Subjectrow) {
                        ?>
                        <option value="<?php echo $Subjectrow['subjectId']; ?>" 
                            <?php if($Subjectrow['subjectId']==$row['subject']){echo "selected";} ?>><?php echo $Subjectrow['subject_title']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
            <?php
            }
            ?>
                <button type="submit" class="custom-button" name="saveAssignment">Update Assignment</button>
        </form>
    </div>
    
</body>
</html>