<?php // block any attempt to the filesystem
if (isset($_GET['file']) && basename($_GET['file']) == $_GET['file']) 
{
   $filename = $_GET['file'];	
}
else
{
   $filename = NULL;
   $err = 'Sorry, the file you are requesting is unavailable.';
}
if (!$filename)
{
   echo $err;
} 
else 
{
   // define the path to your download folder plus assign the file name
   $path = 'uploads/'.$filename;
   // check that file exists and is readable
   if (file_exists($path) && is_readable($path)) 
   {
       // get the file size and send the http headers
       $size = filesize($path);
       header('Content-Type: application/octet-stream');
       header('Content-Length: '.$size);
       header('Content-Disposition: attachment; filename='.$filename);
       header('Content-Transfer-Encoding: binary');
    }
}
?>

