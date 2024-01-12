<?php
include_once '../includes/config1.php';

if(isset($_POST['saveStudent'])){
    try {
        $stmt = $conn->prepare("CALL addStudent(:_fname, :_lname, :_gender, :_age, :_address, :_section,@ret)");
        $stmt->bindParam(':_fname', $_POST['fname']);
        $stmt->bindParam(':_lname', $_POST['lname']);
        $stmt->bindParam(':_gender', $_POST['gender']);
        $stmt->bindParam(':_age', $_POST['age']);
        $stmt->bindParam(':_address', $_POST['address']);
        $stmt->bindParam(':_section', $_POST['section']);
    
        $stmt->execute();
        $stmt = $conn->query("SELECT @ret");
        $ret = $stmt->fetchColumn();
        if($ret==1){
            echo "<script>alert('Student already existed.');</script>";
        }else{
            echo "<script>alert('Inserted successfully.');</script>";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/student.css"> 
    <title>Teacher's Account</title>
</head>
<body style="background: lightcyan;">
    
    <nav class="navbar" style="background: black;">
        <div class="container">
            <div class="menu">
                <a href="../afterindex.php">Teacher List</a>
                <a href="Student.php">Students</a>
            </div>
        </div>
    </nav>

    <div class="content">
        <form action="" method="POST" style=" padding: 20px;">
            <div>
            <div style="display: flex;">
                <div>
                    <input type="text" name="fname" class="input-field" placeholder="First Name" v-model="fname">
                </div>
                <div>
                    <input type="text" name="lname" class="input-field" placeholder="Last Name" v-model="lname">
                </div>
                <div>
                    <input type="text" name="gender" class="input-field" placeholder="Gender" v-model="gender">
                </div>
                <div>
                    <input type="number" name="age" class="input-field" placeholder="Age" v-model="age">
                </div>
                <div>
                    <input type="text" name="address" class="input-field" placeholder="Address" v-model="address">
                </div>
                <div>
                    <input type="text" name="section" class="input-field" placeholder="Deparment" v-model="section">
                </div>
            </div>
            </div>
            
                <button type="submit" class=" btn btn-primary" name="saveStudent">Add Student</button>
                <h4 style="margin:0; margin-top: 20px;">List of Students</h4>
                <div>
                    <input type="text" name="search"  class="input-field" value="<?php if(isset($_POST['search'])){echo $_POST['search'];} ?>">
                    <button type="submit" class="btn btn-primary" name="searchStudent">Search</button>
                </div>
            <div class="table-container" >
                <table class=" table table-bordered">
                    <tr>
                        <th class="bg-dark text-light">FullName</th>
                        <th class="bg-dark text-light">Gender</th>
                        <th class="bg-dark text-light">Age</th>
                        <th class="bg-dark text-light">Address</th>
                        <th class="bg-dark text-light">Section</th>
                        <th class="bg-dark text-light">Edit</th>
                        <th class="bg-dark text-light">Delete</th>
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
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['section']; ?></td>
                            <td><a href="Update.php?id=<?php echo $row['stud_id']; ?>" class="update-link bi bi-pencil-square btn btn-success"></a></td>
                            <td><a href="Delete.php?id=<?php echo $row['stud_id']; ?>" class="delete-link bi bi-trash btn btn-danger"></a></td>
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