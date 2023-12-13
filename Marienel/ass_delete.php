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
        $stmt = $conn->prepare("CALL deleteAssignment(:_ass_id)");
        $stmt->bindParam(':_ass_id', $_GET['id']);
    
        $stmt->execute();
        echo "<script>
        alert('Deleted successfully.');
        setTimeout(function(){
            window.location.href = 'stud_assigned.php';
        }, 100);
      </script>";
    } catch(PDOException $e) {
        echo "<script>
        alert('Unable to delete.');
        setTimeout(function(){
            window.location.href = 'assign.php';
        }, 100);
      </script>";
        //echo "Error: " . $e->getMessage();
    }

?>