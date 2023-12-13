<?php
    if(!isset($_GET['id'])){
        header("Location: index.php");
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
        $stmt = $conn->prepare("CALL deleteStudent(:_stud_id)");
        $stmt->bindParam(':_stud_id', $_GET['id']);
    
        $stmt->execute();
        echo "<script>
        alert('Deleted successfully.');
        setTimeout(function(){
            window.location.href = 'stud_add.php';
        }, 100);
      </script>";
    } catch(PDOException $e) {
        echo "<script>
        alert('Cant be able to delete.');
        setTimeout(function(){
            window.location.href = 'stud_add.php';
        }, 100);
      </script>";
        //echo "Error: " . $e->getMessage();
    }

?>