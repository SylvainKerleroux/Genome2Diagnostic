<html>

<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>	

<body>   
	<br>
	<main role="main" class="container">

   	<div style="width:50%" class="alert alert-secondary" role="alert">
      	<h1> 
      		Genome2Diagostic	
  		</h1>
	</div>

	<div style="width:50%" class="alert alert-primary">
		<form action="index.php" method="post" enctype="multipart/form-data">
			Find out what your risk factors are by uploading your genomique snippet in .csv format :<br>
			<input type="file" accept=".csv, application/vnd.ms-excel" name="fileToUpload" id="fileToUpload"><br>
			<input type="submit" value="Upload" name="submit">
		</form>
	</div>

    <?php
    if ($_FILES["fileToUpload"]["tmp_name"])
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
	  
	By Sylvain Kerleroux
    </main>
</body>

</html>