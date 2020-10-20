<?php
  
    $itemid = $_POST['itemid'];

     include 'includes/functions/function.php';
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



   $stmt = $con->prepare("SELECT comment.*, UserName As UserName
                            FROM comment INNER JOIN users
                             ON users.UserID = comment.Member_ID
                             WHERE Item_ID =?
                             AND Status  =1
                             ORDER BY ID DESC ");
                                                                                     
                           $stmt->execute(array($itemid));
                           $comments  = $stmt->fetchAll();
                    print_r($comments);
?>