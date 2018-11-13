<?php

function remove_directory($directory, $empty=FALSE)
{
	if(substr($directory,-1) == '/')
	{
		$directory = substr($directory,0,-1);
	}

	if(!file_exists($directory) || !is_dir($directory))
	{
		return FALSE;

	}
	elseif(!is_readable($directory)){
		return FALSE;

	}else{
		$handle = opendir($directory);

		while (FALSE !== ($item = readdir($handle)))
		{
			if($item != '.' && $item != '..')
			{
				$path = $directory.'/'.$item;

				if(is_dir($path)) 
				{
					// we call this function with the new path
					remove_directory($path);

				}else{
					unlink($path);
				}
			}
		}
		
		closedir($handle);

		
		if($empty == FALSE)
		{
			if(!rmdir($directory))
			{
				return FALSE;
			}
		}
		
		return TRUE;
	}
}


function dir_exists($dir_name = false, $path = './') {
    if(!$dir_name) return false;
   
    if(is_dir($path.$dir_name)) return true;
   
    $tree = glob($path.'*', GLOB_ONLYDIR);
    if($tree && count($tree)>0) {
        foreach($tree as $dir)
            if(dir_exists($dir_name, $dir.'/'))
                return true;
    }
   
    return false;
}
?>