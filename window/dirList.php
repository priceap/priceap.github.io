<?PHP

$dirlist = getFileList("uploads");
  //echo "<pre>",print_r($dirlist),"</pre>";
  //echo $dirlist;
  echo json_encode($dirlist);
  
  
  function getFileList($dir)
  {
    // array to hold return value
    $retval = array();

    // add trailing slash if missing
    if(substr($dir, -1) != "/") $dir .= "/";

    // open pointer to directory and read list of files
    $d = @dir($dir) or die("getFileList: Failed opening directory $dir for reading");
    while(false !== ($entry = $d->read())) {
      // skip hidden files
      if($entry[0] == ".") continue;
	  //if (strncmp($entry,"39.",3) != 0) continue;
	  if (stripos($entry,".mp3") == FALSE) continue;
	  if(is_readable("$dir$entry")) {
        $retval[] = "$entry";
      }
    }
    $d->close();

    return $retval;
  }
?>