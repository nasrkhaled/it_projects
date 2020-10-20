<?php
 session_start();
$dsn   =  "mysql:host=localhost;dbname=shop;charset=utf8";
 $user  =  "root";
 $pass  =   "";
 $option=   array (
               PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"           
                   );
  try {
    $con = new PDO ($dsn,$user,$pass,$option);
    $con -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
     //echo "connection"; testing
     }
  catch (PDOException $e)
    {
      echo "connectionless".$e->getMessage();
    }
if (isset($_SESSION['username'])) 
  {
 $stmt = $con->prepare("DELETE FROM users  WHERE UserID = :zcatid");
                    $stmt->bindParam(":zcatid",$_SESSION['userid']);
                    $stmt->execute();
               session_unset();
               session_destroy();
               exit();
    }
  else
    {
      header('location:login.php');
      exit();
    }
?>