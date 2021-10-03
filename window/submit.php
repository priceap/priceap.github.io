<?php // You need to add server side validation and better error handling here

$data = array();

if(isset($_GET['files']))
{	
	$error = false;
	$files = array();
	$uploaddir = 'uploads/';
	$lat = $_POST['lat'];
	$lon = $_POST['lon'];
	//$input_file = $uploaddir . basename($_FILES["file_upload"]["name"]);
	$input_file = $uploaddir . basename($_FILES[0]["name"]);
	$fileExtension = pathinfo($input_file,PATHINFO_EXTENSION);
	$today = date("Y-m-d_H:i:s"); 
	$target_file = $uploaddir . basename($lat) . "_" . basename($lon) . "_" . $today . "." . $fileExtension ;

	foreach($_FILES as $file)
	{
		//if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name'])))
		if(move_uploaded_file($file['tmp_name'], $target_file ))
		{
			$files[] = $uploaddir .$file['name'];
			
//			$cmd = "ffmpegLNX\ffmpeg -y -i uploads\test.MOV uploads\testConvert.mp3";
//			$cmd = "ffmpegLNX/ffmpeg -y -i uploads/test.MOV audiosources/testConvert.mp3";
			$cmd = "ffmpegLNX/ffmpeg -y -i " . $target_file . " " . " uploads/" . basename($lat) . "_" . basename($lon) . "_" . $today . ".mp3" ;
			exec($cmd);
			
			//$msg = "A new upload has been made to Listening Glass.\n\nhttp://accad.osu.edu/~aprice/window/uploads/" . basename($target_file) . "\n\nYou may wish to run\n\nffmpegLNX/ffmpeg -y -i uploads/" . basename($target_file) . " audiosources/" . basename($lat) . "_" . basename($lon) . "_" . $today . ".mp3" ;
			$msg = "A new upload has been made to Listening Glass.\n\nhttp://accad.osu.edu/~aprice/window/uploads/" . basename($lat) . "_" . basename($lon) . "_" . $today . ".mp3" ;
			// send email
			mail("price.ap@gmail.com","new upload notice",$msg);
		}
		else
		{
		    $error = true;
		}
	}
	$data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
}
else
{
	$data = array('success' => 'Form was submitted', 'formData' => $_POST);

}

echo json_encode($data);

?>
