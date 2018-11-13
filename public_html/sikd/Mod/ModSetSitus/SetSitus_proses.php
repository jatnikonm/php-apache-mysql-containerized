<?php
	if($task == "upload"){
		if($_FILES["file"]["name"] != ""){
			$path = 'images/Frontpage/';
			$NAME = $_FILES["file"]["name"];
			$n=strrchr(trim($NAME,'/\\'),'.'); 
			if((strpos('\\',$n)!==false) && (strpos('/',$n)!==false)){
				$n='';
			}
			
			if ( ($_FILES["file"]["type"] == "image/png") || 
				($_FILES["file"]["type"] == "image/x-png") || 
				($_FILES["file"]["type"] == "image/gif") || 
				($_FILES["file"]["type"] == "image/jpeg") || 
				($_FILES["file"]["type"] == "image/jpg") || 
				($_FILES["file"]["type"] == "image/pjpeg") ){
				
				if (($n == ".jpg") || 
					($n == ".gif") || 
					($n == ".jpeg") || 
					($n == ".png")){
					
					//delete all Existing beside Default
					$sql = "select FrontImage from master_front";
					$res = mysql_query($sql);
					while($row = mysql_fetch_array($res)){
						$exist = str_replace('images/Frontpage/', "", $row["FrontImage"]);
					}
					
					$mydir = opendir($path);
					while(false !== ($file = readdir($mydir))) {
						if($file != "." && $file != "..") {
							if($file != $exist){
								unlink($path . $file);
							}
						}
					}
					
					$newname = date('Ymdhis') . $n;
					UploadFile($path, $newname);
					chmod($path . $newname, 0777);
					die("<script>
						var vReturnValue = new Object();
						vReturnValue.ImgFile = '" . $newname . "';
						window.returnValue = vReturnValue;
						window.close();
						</script>");
				}else{
					die("<script>
						alert('Jenis File Gambar haruslah *.jpg, *.jpeg, *.gif, *.png !');
						history.go(-1);
						</script>");
				}
			}
			else{
				die("<script>
					alert('Jenis File Gambar haruslah *.jpg, *.jpeg, *.gif, *.png !');
					history.go(-1);
					</script>");
			}
		}
	}
	
	if($task == "update"){
		$sql = "update master_front 
			set FrontTitle='" . $data[2] . "', 
				FrontLabel='" . $data[3] . "' ";
		if($data[1] != ""){
			 $sql .= ", FrontImage='images/Frontpage/" . $data[1] . "' ";
		}
		//die($sql);
		mysql_query($sql);
		die("<script>location.href='index2.php?option=" . $option . "';</script>");
	}
	
?>