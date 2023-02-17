<?php
session_start();
require "dbcred.php";

    if (isset($_POST['submit'])) {
        $title= $_POST["title"];
        $note= $_POST["note"];
        if(empty($title)&& empty($note)){
           $_SESSION["message"]= "Kindly fill up the title and the note ";
           header("location:index.php");
        }else{

        $query = "INSERT INTO note_tb (`title`,`note`) VALUES (?,?)";
        $stmt=$connect->prepare($query);
        $stmt->bind_param("ss",$title,$note);
        $execute=$stmt->execute();
        if($execute){
            $_SESSION["message"]="Note added successfully";
            $_SESSION["status"]=true;

        }else{
            $_SESSION["message"]="Something went wrong!";
            $_SESSION["status"]=false;
        }

        header("location:index.php");
        }

    }else{
        echo "Incorrect";

    }



    
 
?>