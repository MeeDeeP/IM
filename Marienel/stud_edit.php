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
if(isset($_POST['updateStudent'])){
    try {
        $stmt = $conn->prepare("CALL updateStudent(:_fname, :_lname, :_gender,:_age,:_bdate,:_address,:_stud_id)");
        $stmt->bindParam(':_fname', $_POST['fname']);
        $stmt->bindParam(':_lname', $_POST['lname']);
        $stmt->bindParam(':_gender', $_POST['gender']);
        $stmt->bindParam(':_age', $_POST['age']);
        $stmt->bindParam(':_bdate', $_POST['bdate']);
        $stmt->bindParam(':_address', $_POST['address']);
        $stmt->bindParam(':_stud_id', $_GET['id']);
    
        $stmt->execute();
        echo "<script>alert('Edited Successfully.');</script>";
        header("Location: stud_add.php");
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
        <?php 
            if(!isset($_GET['id'])){
                header("Location: stud_add.php");
            }
            try {
                $stmt = $conn->prepare("SELECT * FROM tblStudent where stud_id=:id");
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
            foreach($stmt->fetchAll() as $row) {
        ?>
            <div style="display: flex;">
                <div>
                    <label for="">Firstname</label> <br>
                    <input type="text" name="fname" value="<?php echo $row['fname']; ?>" class="input-field">
                </div>
                <div>
                    <label for="">Lastname</label><br>
                    <input type="text" name="lname" id="" value="<?php echo $row['lname']; ?>" class="input-field">
                </div>
                <div>
                    <label for="">Age</label><br>
                    <input type="number" name="age" id="" value="<?php echo $row['age']; ?>" class="input-field">
                </div>
                <div>
                    <label for="">Gender</label><br>
                    <select name="gender" id="" class="select-field">
                        <option value="Male" <?php if($row['gender']=="Male"){echo "selected";} ?>>Male</option>
                        <option value="Female" <?php if($row['gender']=="Female"){echo "selected";} ?>>Female</option>
                    </select>
                </div>
                <div>
                    <label for="">Birthdate</label><br>
                    <input type="date" name="bdate" id="" value="<?php echo $row['bdate']; ?>" class="input-field">
                </div>
                <div>
                    <label for="">Address</label><br>
                    <input type="text" name="address" id="" value="<?php echo $row['address']; ?>" class="input-field">
                </div>
            </div>
        <?php
            }
        ?>
            <button type="submit" class="custom-button" name="updateStudent">Update Student</button>
        </form>
    </div>
</body>
</html>