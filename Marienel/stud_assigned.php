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
if(isset($_POST['saveSubject'])){
    try {
        $stmt = $conn->prepare("CALL addAssignment(:_assignment,:_student,:_deadline_date,:_student_score,@ret)");
        $stmt->bindParam(':_assignment', $_POST['assignment']);
        $stmt->bindParam(':_student', $_POST['student']);
        $stmt->bindParam(':_deadline_date', $_POST['deadline']);
        $stmt->bindParam(':_student_score', $_POST['studentscore']);
    
        $stmt->execute();
        $stmt = $conn->query("SELECT @ret");
        $ret = $stmt->fetchColumn();
        if($ret==1){
            echo "<script>alert('Assignment already assigned.');</script>";
        }else{
            echo "<script>alert('Record inserted successfully.');</script>";
        }
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
                        <option value="<?php echo $row['ass_no']; ?>"><?php echo $row['ass_title']; ?></option>
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
                        <option value="<?php echo $row['stud_id']; ?>"><?php echo $row['fname']." ".$row['lname']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="">Deadline</label><br>
                    <input type="date" class="input-field" name="deadline">
                </div>
                <div>
                    <label for="">Student Score</label><br>
                    <input type="number" class="input-field" name="studentscore">
                </div>
            </div>
                <button type="submit" class="custom-button" name="saveSubject">Assign</button>
                <h4 style="margin:0; margin-top: 20px;">List of assigned Assignments</h4>
                <div>
                    <input type="text" name="search" id="" class="input-field" value="<?php if(isset($_POST['search'])){echo $_POST['search'];} ?>">
                    <button type="submit" class="custom-button" name="searchStudent">Search</button>
                </div>
            <div class="table-container">
                <table class="custom-table">
                    <tr>
                        <th>Student</th>
                        <th>Assignment</th>
                        <th>Subject</th>
                        <th>Deadline</th>
                        <th>Student Score</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    <tbody>
                        <?php
                            try {
                                $stmt = $conn->prepare("CALL selectAssignment(:search)");
                                $search="%%";
                                if(isset($_POST['search'])){
                                    $search = "%".$_POST['search']."%";
                                }
                                $stmt->bindParam(':search', $search);
                                $stmt->execute();
                                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                            } catch(PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            
                            foreach($stmt->fetchAll() as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row['fname']." ".$row['lname']; ?></td>
                            <td><?php echo $row['ass_title']; ?></td>
                            <td><?php echo $row['subject_title']; ?></td>
                            <td><?php echo $row['deadline_date']; ?></td>
                            <td><?php echo $row['student_score']; ?></td>
                            <td><a href="ass_edit.php?id=<?php echo $row['ass_id']; ?>" class="update-link">Edit</a></td>
                            <td><a href="ass_delete.php?id=<?php echo $row['ass_id']; ?>" class="delete-link">Delete</a></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    
</body>
</html>