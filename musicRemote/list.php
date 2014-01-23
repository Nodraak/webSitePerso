<?php

/******************************************************************************* 
*
*   File : list.php
*
*   Author : Adrien Chardon
*   Date :   2014-01-23 18:18:25
*
*   Last Modified by :   Adrien Chardon
*   Last Modified time : 2014-01-23 18:20:55
*
*******************************************************************************/

	$path = '/home/adur/Music/music/';

	$filesRaw = scandir($path, 1);
	$filesReturn = array();

echo '<pre>';
print_r($filesRaw);
echo '</pre>';

	if ($filesRaw != FALSE)
	{
		foreach($filesRaw as $file)
		{
			$filesReturn[] = $file;
		}
	
		return $filesReturn;
	}


/*
	exec('git rev-parse --verify HEAD 2> /dev/null', $output);
	$version = $output[0];
*/

?>