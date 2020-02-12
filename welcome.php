<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<html>
<div align="center">
	<p><a href="logout.php">Logout here</a>.</p>
	<h4> Logged in user :  <?php echo $_SESSION["username"]; ?> </h4>
	<h5> Welcome <?php echo $_SESSION["firstname"]; ?> </h5>
	<h5> Lastname : <?php echo $_SESSION["lastname"]; ?></h5>
	<h5> Email : <?php echo $_SESSION["email"]; ?></h5>
	<?php if ($_SESSION["filename"]) : ?>
	<h5> Filename : <?php echo $_SESSION["filename"]; ?></h5>
	<h5 style="color:red;"> Status : <?php echo $_SESSION["fileupload"]; ?></h5>
        <p></p><a href='download.php?file=<?php echo $_SESSION["filename"]; ?>'> Download file </a>
	<h5> WordCount : <?php echo $_SESSION["wordcount"]; ?></h5>
	<?php else : ?>
	<form action="upload.php" method="post" enctype="multipart/form-data">
   	 	Select file to upload:
    		<input type="file" name="fileToUpload" id="fileToUpload">
    		<input type="submit" value="Upload File" name="submit">
	</form>
	<?php endif; ?>
	
</div>

</html>

