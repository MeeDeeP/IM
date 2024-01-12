<?php
    if(!isset($_GET['id'])){
        header("Location: Student.php");
    }
    include_once '../includes/config1.php';
    try {
        $stmt = $conn->prepare("CALL deleteStudent(:_stud_id)");
        $stmt->bindParam(':_stud_id', $_GET['id']);
    
        $stmt->execute();
        echo "<script>
        alert('Student Deleted Successfully.');
        setTimeout(function(){
            window.location.href = 'Student.php';
        }, 100);
    </script>";
    } catch(PDOException $e) {
        echo "<script>
        alert('Oops! Balika.');
        setTimeout(function(){
            window.location.href = 'Student.php';
        }, 100);
    </script>";
    }

?>