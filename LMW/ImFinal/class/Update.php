<?php
include_once '../includes/config1.php';
if(isset($_POST['updateStudent'])){
    try {
        $stmt = $conn->prepare("CALL updateStudent(:_fname, :_lname, :_gender,:_section,:_stud_id)");
        $stmt->bindParam(':_fname', $_POST['fname']);
        $stmt->bindParam(':_lname', $_POST['lname']);
        $stmt->bindParam(':_gender', $_POST['gender']);
        $stmt->bindParam(':_section', $_POST['section']);
        $stmt->bindParam(':_stud_id', $_GET['id']);
    
        $stmt->execute();
        echo "<script>alert('Updated successfully.');</script>";
        header("Location:Student.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <title>Students</title>
</head>
<body style="background: linear-gradient(to right, white, aqua);;">
    
    <nav class="navbar" style="background: black;">
        <div class="container">
            <div class="menu">
                <a href="../afterindex.php">User List</a>
                <a href="Student.php">Student_List</a>
                
            </div>
        </div>
    </nav>

    <div class="content">
        <form action="" method="POST">
        <?php 
            if(!isset($_GET['id'])){
                header("Location: Student.php");
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
                header("Location: Student.php");
            }
            foreach($stmt->fetchAll() as $row) {
        ?>
            <div>
            <div class="row text-center">
                <div class="col-lg-12">
                    <input type="text" name="fname" value="<?php echo $row['fname']; ?>" class="input-field" placeholder="First name">
                </div>
                <div class="col-lg-12">
                    <input type="text" name="lname"  value="<?php echo $row['lname']; ?>" class="input-field" placeholder="Last Name">
                </div>
                <div class="col-lg-12">
                    <input type="text" name="gender"  value="<?php echo $row['gender']; ?>" class="input-field" placeholder="Gender">
                </div>
                <div class="col-lg-12">
                    <input type="text" name="section" value="<?php echo $row['section']; ?>" class="input-field" placeholder="Section">
                </div>
            </div>
            </div>
        <?php
            }
        ?>
            <button type="submit" class="btn btn-primary" name="updateStudent" style="margin-left: 750px;">Update Student</button>
        </form>
    </div>
</body>
</html>