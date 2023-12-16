<?php
require "database.php";
class backend{
public function dologin($user,$pass){
    return self::login($user,$pass);
}
public function doregister($userid,$firstname,$lastname,$user,$pass,$address,$email,$user_role){
    return self::register($userid,$firstname,$lastname,$user,$pass,$address,$email,$user_role);
}
public function doupdate($userid, $firstname, $lastname, $username, $address, $email, $user_role,$counterlock){
    return self::update($userid, $firstname, $lastname, $username, $address, $email, $user_role,$counterlock);
}
public function doCreateStudent($studid, $firstname, $lastname, $gender, $section){
    return self::CreateStudent($studid, $firstname, $lastname, $gender, $section);
}
private function register($userid,$firstname,$lastname,$user,$pass,$address,$email,$user_role){
    try {
        if($this->checkIfVallidreg($userid,$firstname,$lastname,$user,$pass,$address,$email,$user_role)){
            $db = new database();
            if($db->getStatus()){
                $stmt = $db->getCon()->prepare("call sp_reg(?,?,?,?,?,?,?,?)");
                $stmt->bindValue(1,$userid);
                $stmt->bindValue(2,$firstname);
                $stmt->bindValue(3,$lastname);
                $stmt->bindValue(4,$user);
                $stmt->bindValue(5,md5($pass));
                $stmt->bindValue(6,$address);
                $stmt->bindValue(7,$email);
                $stmt->bindValue(8,$user_role);
                $stmt->execute();
                $result = $stmt->fetchAll();
                if(!$result){
                    $db->closeConnection();
                    return "200";
                }else{
                    $db->closeConnection();
                    return "404";
                }
            }
        }
    } catch (PDOException $th) {
        return $th->getMessage();
    }
}
private function login($user,$pass){
    try {
        if($this->checkIfVallid($user,$pass)){
            $db = new database();
            if($db->getStatus()){
                $tmp = md5($pass);
                $stmt=$db->getCon()->prepare("call sp_login(?,?)");
                $stmt->bindValue(1,$user);
                $stmt->bindValue(2,$tmp);
                $stmt->execute();
                $result = $stmt->fetch();
                if($result){
                    $_SESSION['userid'] = $result['userid'];
            $_SESSION['username'] = $user;
            $_SESSION['password'] = $tmp;
            $_SESSION['role'] = $result['user_role'];
            $_SESSION['counterlock'] = $result['counterlock'];
            if($result['user_role']==1){
                $db->closeConnection();
                
                return 1;
            }else if($result['user_role']==2){
                $db->closeConnection();
                
                return 2;
            }else{
                $db->closeConnection();

                return "404";
            }
                }else{
                $db->closeConnection();
                return "403";
                }
                
            }
        }
    } catch (PDOException $th) {
        return $th->getMessage();
    }
}

private function update($userid, $firstname, $lastname, $username, $address, $email, $user_role,$counterlock){

    try{
        if($this->checkIfValidUpdate($userid, $firstname, $lastname, $username, $address, $email, $user_role,$counterlock)){
            $db = new database();
            if($db->getStatus())
            {
                $stmt = $db->getCon()->prepare("call sp_update(?,?,?,?,?,?,?,?)");
                $stmt->bindValue(1,$userid);
                $stmt->bindValue(2,$firstname);
                $stmt->bindValue(3,$lastname);
                $stmt->bindValue(4,$username);
                $stmt->bindValue(5,$address);
                $stmt->bindValue(6,$email);
                $stmt->bindValue(7,$user_role);
                $stmt->bindValue(8,$counterlock);
                $stmt->execute();
                $result = $stmt->fetchAll();
                if(!$result)
                {
                    $db->closeConnection();
                    return "200";
                }
                else
                {
                    $db->closeConnection();
                    return "404";
                }

            }
        }
    }
    catch(PDOException $up)
    {
        return $up->getMessage();
    }

}

private function checkIfValidUpdate($userid, $firstname, $lastname, $username, $address, $email, $user_role,$counterlock){
    if($firstname != "" && $lastname != "" && $username != "" && $address != "" && $email != "" && $user_role != "" && $counterlock != ""){
        return true;
    }
    else
    {
        return false;
    }
}

private function getId(){
    try {
        $db = new database();
        if ($db->getStatus()) {
            $stmt = $db->getCon()->prepare("call sp_login(?,?)");
            $stmt->bindValue(1,$_SESSION['username']);
            $stmt->bindValue(2,$_SESSION['password']);
            $stmt->execute();
            $tmp = null;
            while ($row = $stmt->fetch()) {
                $tmp = $row['userid'];
            }
            $db->closeConnection();
            return $tmp;
        }
    } catch (PDOException $th) {
        echo $th;
    }        
}
private function checkIfVallid($user, $pass)
    {
        if ($user != "" && $pass != "")
            return true;
        else
            return false;
    }
    private function checkIfVallidreg($userid,$firstname,$lastname,$user,$pass,$address,$email,$user_role)
        {
            if ($userid !="" && $firstname !="" && $lastname !="" && $user != "" && $pass != "" && $address != "" && $email != "" && $user_role !="")
                return true;
            else
                return false;
        }
}

?>