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
if(isset($_POST['updateSubject'])){
    try {
        $stmt = $conn->prepare("CALL updateSubject(:_subject,:_teacher,:subjectId)");
        $stmt->bindParam(':_subject', $_POST['subject']);
        $stmt->bindParam(':_teacher', $_POST['teacher']);
        $stmt->bindParam(':subjectId', $_GET['id']);
    
        $stmt->execute();
        echo "<script>alert('Edited Successfully.');</script>";
        header("Location:subjects.php");
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
    <title>Subjects</title>
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
                header("Location: subject.php");
            }
            try {
                $stmt = $conn->prepare("SELECT * FROM tblsubject where subjectId=:id");
                $stmt->bindParam(':id', $_GET['id']);
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $rowCount = $stmt->rowCount();
            if($rowCount==0){
                header("Location: subject.php");
            }
            foreach($stmt->fetchAll() as $row) {
        ?>
            <div style="display: flex;">
                <div>
                    <label for="">Subject</label> <br>
                    <input type="text" name="subject" value="<?php echo $row['subject_title']; ?>"; class="input-field">
                </div>
                <div>
                    <label for="">Teacher</label> <br>
                    <input type="text" name="teacher" value="<?php echo $row['teacher']; ?>"; class="input-field">
                </div>
            </div>
        <?php
            }
        ?>
            <button type="submit" class="custom-button" name="updateSubject">Update Subject</button>
        </form>
    </div>
    
</body>
</html>