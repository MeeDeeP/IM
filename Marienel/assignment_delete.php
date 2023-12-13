<?php
    if(!isset($_GET['id'])){
        header("Location: stud_add.php");
    }
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
    try {
        $stmt = $conn->prepare("CALL deleteAssignmentlist(:_ass_no)");
        $stmt->bindParam(':_ass_no', $_GET['id']);
    
        $stmt->execute();
        echo "<script>
        alert('Deleted successfully.');
        setTimeout(function(){
            window.location.href = 'assignment.php';
        }, 100);
      </script>";
    } catch(PDOException $e) {
        echo "<script>
        alert('Cant delete this Assignment.');
        setTimeout(function(){
            window.location.href = 'assignment.php';
        }, 100);
      </script>";
    }

?>