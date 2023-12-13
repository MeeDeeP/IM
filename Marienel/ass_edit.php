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
if(isset($_POST['updateAssign'])){
    try {
        $stmt = $conn->prepare("CALL updateAssignment(:_assignment,:_student,:_deadline_date,:_student_score,:_ass_id)");
        $stmt->bindParam(':_assignment', $_POST['assignment']);
        $stmt->bindParam(':_student', $_POST['student']);
        $stmt->bindParam(':_deadline_date', $_POST['deadline']);
        $stmt->bindParam(':_student_score', $_POST['studentscore']);
        $stmt->bindParam(':_ass_id', $_GET['id']);
    
        $stmt->execute();
        echo "<script>alert('Edited Successfully.');</script>";
        header("Location: stud_assigned.php");
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
    <title>Assigning</title>
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
                header("Location: stud_add.php");
            }
            try {
                $stmt = $conn->prepare("SELECT * FROM tblassignment where ass_id=:id");
                $stmt->bindParam(':id', $_GET['id']);
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $rowCount = $stmt->rowCount();
            if($rowCount==0){
                header("Location: stud_add.php");
            }
            foreach($stmt->fetchAll() as $assignmentRow) {
        ?>
            <div style="display: flex;">
                <div>
                    <label for="">Assigment</label><br>
                    <select name="assignment" id="" class="select-field">
                        <?php
                            try {
                                $stmt = $conn->prepare("SELECT * FROM tblassignmentlist");
                                $stmt->execute();
                                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                            } catch(PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            
                            foreach($stmt->fetchAll() as $row) {
                        ?>
                        <option value="<?php echo $row['ass_no']; ?>" <?php if($assignmentRow['assignment']==$row['ass_no']) {echo "selected";}?>><?php echo $row['ass_title']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="">Student</label><br>
                    <select name="student" id="" class="select-field">
                        <?php
                            try {
                                $stmt = $conn->prepare("SELECT * FROM tblstudent");
                                $stmt->execute();
                                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                            } catch(PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            
                            foreach($stmt->fetchAll() as $row) {
                        ?>
                        <option value="<?php echo $row['stud_id']; ?>" <?php if($assignmentRow['student']==$row['stud_id']) {echo "selected";}?>><?php echo $row['fname']." ".$row['lname']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="">Deadline</label><br>
                    <input type="date" class="input-field" value="<?php echo $assignmentRow['deadline_date']; ?>" name="deadline">
                </div>
                <div>
                    <label for="">Student Score</label><br>
                    <input type="number" class="input-field" value="<?php echo $assignmentRow['student_score']; ?>" name="studentscore">
                </div>
            </div>
        <?php
            }
        ?>
                <button type="submit" class="custom-button" name="updateAssign">Update Assign</button>
        </form>
    </div>
    
</body>
</html>