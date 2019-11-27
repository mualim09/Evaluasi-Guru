<?php
if($_SERVER['SERVER_ADDR']=="8.8.8.8"){
    // Production config DB
    define('HOST','localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD','password');
    define('DB_NAME','alulod_db');
    define('DB_DRIVER','mysql');
    define('CHARSET','utf8');
}
else{
    // Developer server
    define('HOST','localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD','');
    define('DB_NAME','alulod_db');
    define('DB_DRIVER','mysql');
    define('CHARSET','utf8');
}
$conn = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DB_NAME) or die("ERROR");
session_start();

if (isset($_REQUEST["action"])){
	if ($_REQUEST["action"] == "export")
		{
		$tables = array();
	    $query = mysqli_query($conn, 'SHOW TABLES');
	    while($row = mysqli_fetch_row($query)) {
	    	$tables[] = $row[0];
		}
		$result = "";
		foreach($tables as $table) {
			$query = mysqli_query($conn, 'SELECT * FROM '.$table);
			$num_fields = mysqli_num_fields($query);

			$result .= 'DROP TABLE IF EXISTS '.$table.';';
			$row2 = mysqli_fetch_row(mysqli_query($conn, 'SHOW CREATE TABLE '.$table));
			$result .= "\n\n".$row2[1].";\n\n";

			for ($i = 0; $i < $num_fields; $i++) {
				while($row = mysqli_fetch_row($query)) {
					$result .= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j<$num_fields; $j++) {
						$row[$j] = addslashes(htmlspecialchars($row[$j]));
	       				$row[$j] = str_replace("\n","\\n",$row[$j]);
	       				if(isset($row[$j])){
			   				$result .= '"'.$row[$j].'"' ; 
						}else{ 
							$result .= '""';
						}
						if($j<($num_fields-1)){ 
							$result .= ',';
						}
					}
					$result .= ");\n";
				}
			}
			$result .="\n\n";
		}

		$folder = '../db_backup/';
		if (!is_dir($folder))
		mkdir($folder, 0777, true);
		chmod($folder, 0777);

		$date = date('m-d-Y');
		$filename = $folder."alulod_db(".$date.")";
		$handle = fopen($filename.'.sql','w+');
		fwrite($handle,$result);
		fclose($handle);
		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary"); 
		header("Content-disposition: attachment; filename=\"" . basename($filename.'.sql') . "\""); 
		readfile($filename.'.sql');

	}
	if ($_REQUEST["action"] == "import")
	{
		error_reporting(0);
		$output  = array();
		$filename = $_FILES['db_file']['name'];
		$target_dir = $_SERVER['DOCUMENT_ROOT'].'/alulod-tes/dashboard/db_backup/';
		$target_file = $target_dir . basename($_FILES["db_file"]["name"]);
		$filetmp = $_FILES['db_file']['name'];
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

		if($imageFileType != "sql" && $imageFileType != "SQL") {
            // echo "<script type='text/javascript'>alert ('Data restoration failed. File extension must be .SQL')</script>";
            $output["error"] = "Data restoration failed. File extension must be .SQL";
            
    	} else {
    		move_uploaded_file($_FILES["db_file"]["tmp_name"], $target_file);
        	$lines = fopen($target_file,"r");
			$templine = '';

			$templine ="";
			while(! feof($lines))
			  {
			  	 $this_line = fgets($lines). "<br />";
			  	 if(substr($this_line, 0, 2) == '--' || $this_line == '')
			  	 	continue;
			  	 $templine .= $this_line;
			  	 if (substr(trim($this_line), -1, 1) == ';') {

    				mysqli_query($conn, $templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error() . '<br /><br />');
    				
    				$templine = '';
				}
				// echo $templine;
			  	
			  }

			unlink($target_file);
 			// echo "<script type='text/javascript'>alert ('Database successfully restored..')</script>";
 			$output["success"] = "Database successfully restored..";
            
    	}      
	echo json_encode($output);      
   

	}

   

}