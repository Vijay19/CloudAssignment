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
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
   // if($check !== false)
    // {
   //     echo "File is an image - " . $check["mime"] . ".";
   //     $uploadOk = 1;
   // } 
   // else 
    //{
     //   echo "File is not an image.";
     //   $uploadOk = 0;
    //}
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
	// Allow certain file formats
   // if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    //   echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    //   $uploadOk = 0;
   // }
    // break
        if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
    }
        else {
               // echo "target file$target_file";
                $file_to_upload = $_FILES["fileToUpload"]["tmp_name"];
                //echo "adad$file_to_upload\n";
                $uploaded = is_uploaded_file($file_to_upload);
                echo "file uploaded $uploaded";
                echo "<html> <br></html>";
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
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
           //$query_f = "UPDATE users SET filename = $actual_filename, wordcount = $wc WHERE username = $uname";
	   //$res = mysqli_query($db_f, $query_f);
	   echo "<p><br></p><a href='download.php?file=$actual_filename'>Download file</a>";
	   echo "<p><br></p><a href='welcome.php'>HOME </a>";
	   //begin of world
	   $mysqli = new mysqli("localhost", "root", "anubhav", "loginsystem");
           if($mysqli->connect_error) {
               exit('Error connecting to database'); //Should be a message a typical user could understand in production
           }
           mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	   $mysqli->set_charset("utf8mb4");
	   $stmt = $mysqli->prepare("UPDATE users SET filename = ?, wordcount = ? WHERE username = ?");
	   //echo "NAME : ";
	   //echo $uname;
           $stmt->bind_param("sss", $actual_filename, $wc, $uname);
           $stmt->execute();
           $stmt->close();
	   //$sql = "UPDATE users SET filename = ?,wordcount = ? where username = ?";
	   //echo $sql;
          // if($stmt = mysqli_prepare($link, $sql)){
		   // Bind variables to the prepared statement as parametersi
	    //echo "hi";
            //mysqli_stmt_bind_param($stmt, "sss", $param_filename, $param_wc, $param_name);
            //mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set parameters
            //$param_name = $uname;
           // $param_wc = $wc;
           // $param_filename = $actual_filename;

	    //mysqli_stmt_bind_param($stmt, "sss", $param_filename, $param_wc, $param_name);
	    //echo $stmt;
	    //if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
	   // header("location: login.php");
	      //echo "Update DB success";
           // } //else{
             //   echo "Something went wrong. Please try again later. exec";
           // }

            // Close statement
	    //mysqli_stmt_close($stmt);
	    //}
            // Close connection
            //mysqli_close($link);

	   //ENd of world
        }
                  else
                  {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

