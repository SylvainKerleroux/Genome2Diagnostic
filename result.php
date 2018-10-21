<?php
if (is_uploaded_file($_FILES["fileToUpload"]["tmp_name"]))
{
  $temp_dir = $_FILES["fileToUpload"]["tmp_name"];
  list($none, $parent_dir, $name) = explode('/', $temp_dir);

  if (move_uploaded_file($temp_dir, "./database/input/$name")) 
  {
     if (exec("Rscript Rscript.R $name"))
     {
      $result_file = fopen("./database/output/$name", "r") 
              or die("Unable to open file!");
      echo "<table class='table'>";
      while (($line = fgetcsv($result_file)) !== false) 
      {
        echo "<tr>";
        foreach ($line as $cell) 
        {
              echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
      }
      echo "</tr></table>";
      fclose($result_file);
     } 
     else 
     {
      echo "<h2>Sorry, we are not able to parse your file.</h2>";
     }
  } 
  else 
  {
    echo "<h2>Sorry, there was an error uploading your file.</h2>";
  }
}
?>