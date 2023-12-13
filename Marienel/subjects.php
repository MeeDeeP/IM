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
        $stmt = $conn->prepare("CALL addSubject(:_subject,:_teacher,@ret)");
        $stmt->bindParam(':_subject', $_POST['subject']);
        $stmt->bindParam(':_teacher', $_POST['teacher']);
    
        $stmt->execute();
        $stmt = $conn->query("SELECT @ret");
        $ret = $stmt->fetchColumn();
        if($ret==1){
            echo "<script>alert('Subject already existed.');</script>";
        }else{
            echo "<script>alert('Record added successfully.');</script>";
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
            <div style="display: flex;">
                <div>
                    <label for="">Subject</label> <br>
                    <input type="text" name="subject" class="input-field">
                </div>
                <div>
                    <label for="">Teacher</label> <br>
                    <input type="text" name="teacher" class="input-field">
                </div>
            </div>
                <button type="submit" class="custom-button" name="saveSubject">Add Subject</button>
                <h4 style="margin:0; margin-top: 20px;">List of Subjects</h4>
                <div>
                    <input type="text" name="search" id="" class="input-field" value="<?php if(isset($_POST['search'])){echo $_POST['search'];} ?>">
                    <button type="submit" class="custom-button" name="searchStudent">Search</button>
                </div>
            <div class="table-container">
                <table class="custom-table">
                    <tr>
                        <th>Subject</th>
                        <th>Teacher</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    <tbody>
                        <?php
                            try {
                                $stmt = $conn->prepare("CALL selectSubject(:search)");
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
                            <td><?php echo $row['subject_title']; ?></td>
                            <td><?php echo $row['teacher']; ?></td>
                            <td><a href="sub_edit.php?id=<?php echo $row['subjectId']; ?>" class="update-link">Edit</a></td>
                            <td><a href="sub_delete.php?id=<?php echo $row['subjectId']; ?>" class="delete-link">Delete</a></td>
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