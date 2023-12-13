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
        $stmt = $conn->prepare("CALL deleteSubject(:_subjectId)");
        $stmt->bindParam(':_subjectId', $_GET['id']);
    
        $stmt->execute();
        echo "<script>
        alert('Deleted successfully.');
        setTimeout(function(){
            window.location.href = 'subjects.php';
        }, 100);
      </script>";
    } catch(PDOException $e) {
        echo "<script>
        alert('Cant delete this subject.');
        setTimeout(function(){
            window.location.href = 'subjects.php';
        }, 100);
      </script>";
    }

?>