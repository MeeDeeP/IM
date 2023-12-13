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
        $stmt = $conn->prepare("CALL addAssignmentlist(:_ass_title,:_total_score,:_subject,@ret)");
        $stmt->bindParam(':_ass_title', $_POST['title']);
        $stmt->bindParam(':_total_score', $_POST['score']);
        $stmt->bindParam(':_subject', $_POST['subject']);
    
        $stmt->execute();
        $stmt = $conn->query("SELECT @ret");
        $ret = $stmt->fetchColumn();
        if($ret==1){
            echo "<script>alert('Assignment already existed.');</script>";
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
            <div style="display: flex;">
                <div>
                    <label for="">Title</label> <br>
                    <input type="text" name="title" class="input-field">
                </div>
                <div>
                    <label for="">Score</label> <br>
                    <input type="number" name="score" class="input-field">
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
                            
                            foreach($stmt->fetchAll() as $row) {
                        ?>
                        <option value="<?php echo $row['subjectId']; ?>"><?php echo $row['subject_title']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
                <button type="submit" class="custom-button" name="saveAssignment">Add Assignment</button>
                <h4 style="margin:0; margin-top: 20px;">List of Assignments</h4>
                <div>
                    <input type="text" name="search" id="" class="input-field" value="<?php if(isset($_POST['search'])){echo $_POST['search'];} ?>">
                    <button type="submit" class="custom-button" name="searchStudent">Search</button>
                </div>
            <div class="table-container">
                <table class="custom-table">
                    <tr>
                        <th>Title</th>
                        <th>Score</th>
                        <th>Subject</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    <tbody>
                        <?php
                            try {
                                $stmt = $conn->prepare("CALL selectAssignmentList(:search)");
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
                            <td><?php echo $row['ass_title']; ?></td>
                            <td><?php echo $row['total_score']; ?></td>
                            <td><?php echo $row['subject_title']; ?></td>
                            <td><a href="assignment_edit.php?id=<?php echo $row['ass_no']; ?>" class="update-link">Edit</a></td>
                            <td><a href="assignment_delete.php?id=<?php echo $row['ass_no']; ?>" class="delete-link">Delete</a></td>
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