<?php
$msg = "";
//ISSET CHECKS TO SEE IF A VARIBLE EXISTS. RETURNS TRUE IF IT DOES AND FALSE IF IT DOES NOT. 
if(isset($_POST['create'])){
  $success = mkdir('parent/child/sub-child', 0777, true);
  /*NOT ALL SUBDIRECTORIES MAY HAVE THE PROPER FILE PERMISSIONS SO I WILL MANUALLY SET THEM WITH CHMOD*/
  chmod('parent', 0777);
  chmod('parent/child', 0777);
  chmod('parent/child/sub-child', 0777);

  /*I WILL ALSO ADD SOME FILES*/
  $file = fopen("parent/child/child-file1.txt","w") or die("Cannot Open File");
  $content = "This is child file 1";
  fwrite($file,$content);
  fclose($file);


  /*I WILL ALSO ADD SOME FILES*/
  $file = fopen("parent/child/sub-child/file1.txt","w") or die("Cannot Open File");
  $content = "This is sub-child file 1";
  fwrite($file,$content);
  fclose($file);

  $file = fopen("parent/child/sub-child/file2.txt","w") or die("Cannot Open File");
  $content = "This is sub-child file 2";
  fwrite($file,$content);
  fclose($file);

  if($success){
    $msg = "Directories Created";
  }
  else{
    $msg = "There was a problem";
  }
  
}
if(isset($_POST['remove'])){
   
   $count = 0;
  /* PHP DELETED FUNCTION (CUSTOM) DEALS WITH DIRECTORIES RECRUSIVELY */
  function delete_files($target) {
      /* IS_DIR() CHECKS TO SEE IF THE TARGET IS A DIRECTORY,*/
      if(is_dir($target)){
          /*GLOB RETURNS AN ARRAY CONTAINING THE MATCHED FILES/DIRECTORIES, AN EMPTY ARRAY IF NO FILE MATCHED OR FALSE ON ERROR.  IN THIS CASE GLOB RETURNS AND ARRAY OF ANY SUBFOLDERS OR FILES*/
          $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK ADDS A SLASH TO EACH DIRECTORY 
          echo "<pre>";
          print_r($files);
          echo "</pre>";
          
          /*THE FOREACH LOOPS THROUGH THE ARRAY RETURNED BY GLOB AND IF THEIR ARE ANY FILES IN THAT ARRAY IT WILL DELETE THEM BY CALLING DELETE FILE AGAIN.  IF THE ARRAY ONLY CONTAINS A DIRECTORY  IT WILL GET THE NEXT CHILD DIRECTORY */
          foreach( $files as $file ){
            echo "file per iteration is - ".$file."<br>";
            
            /* IF THIS IS A FILE THEN REMOVE IT OTHERWISE CHECK FOR ANOTHER SUB DIRECTORY AND ADD IT BECOMES TARGET*/
            delete_files($file);
          }


          /*I NEEDED TO DO A FINAL CHECK TO MAKE SURE THE TARGET WAS A DIRECTORY, BEFORE I WAS GETTING A WARNING THAT THE FILE DID NOT EXIST BECAUSE IT HAD CALLED DELETE_FILES PREVIOUSLY*/
          if(is_dir($target)){
            echo "Directory deleted is - ".$target."<br>";
            rmdir($target);
          }
          
      /*IS_FILE CHECKES TO SEE IF THE TARGET IS A FILE AND IF SO REMOVES IT.*/    
      } 

      elseif(is_file($target)) {
          echo "File deleted is - ".$target."<br>";
          unlink($target);  
      }
  }
  delete_files('parent');


  

  /*FILE_EXISTS CHECKS TO SEE IF THE DIRECTORY OR FILE EXISTS*/
  if(!file_exists ('parent')){
    $msg = "Directories Removed";
  }
  else{
    $msg = "There was a problem";
  }
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Multiple Directory</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="public/css/main.css">
  </head>
  <body>
    <div id="wrapper" class="container">
      <h1>Multiple Directory</h1>
      <p><?php echo $msg; ?></p>
      <p>This example demonstrates how to create and remove a single "empty" directory.</p>
      <p>NOTE: In order for this to work the folder this file is in <code>php-directories</code> had to have permissions of 0777.</p>
      <form action="mult-directories.php" method="POST">
        <input type="submit" class="btn btn-primary" name="create" value="Create Multiple Directories">
        <input type="submit" class="btn btn-primary" name="remove" value="Remove Multiple Directories">
      </form>
      
    </div>
    

  </body>
</html>