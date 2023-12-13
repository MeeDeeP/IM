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
if(isset($_POST['saveStudent'])){
    try {
        $stmt = $conn->prepare("CALL AddStudent(:_fname, :_lname, :_gender,:_age,:_bdate,:_address,@ret)");
        $stmt->bindParam(':_fname', $_POST['fname']);
        $stmt->bindParam(':_lname', $_POST['lname']);
        $stmt->bindParam(':_gender', $_POST['gender']);
        $stmt->bindParam(':_age', $_POST['age']);
        $stmt->bindParam(':_bdate', $_POST['bdate']);
        $stmt->bindParam(':_address', $_POST['address']);
    
        $stmt->execute();
        $stmt = $conn->query("SELECT @ret");
        $ret = $stmt->fetchColumn();
        if($ret==1){
            echo "<script>alert('Student already existed.');</script>";
        }else{
            echo "<script>alert('Record Inserted successfully.');</script>";
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
    <title>Students</title>
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
                    <label for="">Firstname</label> <br>
                    <input type="text" name="fname" class="input-field">
                </div>
                <div>
                    <label for="">Lastname</label><br>
                    <input type="text" name="lname" id="" class="input-field">
                </div>
                <div>
                    <label for="">Age</label><br>
                    <input type="number" name="age" id="" class="input-field">
                </div>
                <div>
                    <label for="">Gender</label><br>
                    <select name="gender" id="" class="select-field">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div>
                    <label for="">Birthdate</label><br>
                    <input type="date" name="bdate" id="" class="input-field">
                </div>
                <div>
                    <label for="">Address</label><br>
                    <input type="text" name="address" id="" class="input-field">
                </div>
            </div>
                <button type="submit" class="custom-button" name="saveStudent">Add Student</button>
                <h4 style="margin:0; margin-top: 20px;">List of Students</h4>
                <div>
                    <input type="text" name="search" id="" class="input-field" value="<?php if(isset($_POST['search'])){echo $_POST['search'];} ?>">
                    <button type="submit" class="custom-button" name="searchStudent">Search</button>
                </div>
            <div class="table-container">
                <table class="custom-table">
                    <tr>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Birthdate</th>
                        <th>Address</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    <tbody>
                        <?php
                            try {
                                $stmt = $conn->prepare("Call selectStudents(:search)");
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
                            <td><?php echo $row['gender']; ?></td>
                            <td><?php echo $row['age']; ?></td>
                            <td><?php echo $row['bdate']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><a href="stud_edit.php?id=<?php echo $row['stud_id']; ?>" class="update-link">Edit</a></td>
                            <td><a href="stud_delete.php?id=<?php echo $row['stud_id']; ?>" class="delete-link">Delete</a></td>
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