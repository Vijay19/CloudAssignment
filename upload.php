<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$param_wc="";
$param_username="";
$param_filename="";
session_start();
require_once "config.php";
$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if(isset($_POST["submit"])) 
{
    if (file_exists($target_file))
    {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) 
    {
       echo "Sorry, your file is too large.";
       $uploadOk = 0;
    }
    if ($uploadOk == 0)
    {
       echo "Sorry, your file was not uploaded.";
       // if everything is ok, try to upload file
    }
    else 
    {
       $file_to_upload = $_FILES["fileToUpload"]["tmp_name"];
       $uploaded = is_uploaded_file($file_to_upload);
       echo "file uploaded $uploaded";
       echo "<html> <br></html>";
       if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
       {
           $actual_filename = basename( $_FILES["fileToUpload"]["name"]);
           echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
           $command_wc = "wc -w uploads/$actual_filename | cut -d ' ' -f1";
           echo "<html> <br></html>";
           echo "file Name : $actual_filename";
           echo "<html> <br></html>";
           echo "uploaded file word count : ";
           $wc = system($command_wc);
           $_SESSION['filename'] = $actual_filename;
	   $uname = $_SESSION['username'];
	   $_SESSION['wordcount'] = $wc;
	   echo "<p><br></p><a href='download.php?file=$actual_filename'>Download file</a>";
	   echo "<p><br></p><a href='welcome.php'>HOME </a>";
	   $mysqli = new mysqli("localhost", "c_user", "p_user", "users");
           if($mysqli->connect_error) {
               exit('Error connecting to database'); //Should be a message a typical user could understand in production
           }
           mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	   $mysqli->set_charset("utf8mb4");
	   $stmt = $mysqli->prepare("UPDATE users SET filename = ?, wordcount = ? WHERE username = ?");
           $stmt->bind_param("sss", $actual_filename, $wc, $uname);
           $stmt->execute();
           $stmt->close();
	   $_SESSION['fileupload'] = "File Upload Success";
	   header("Location: welcome.php");
	   exit();
        }
	else
	{
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

