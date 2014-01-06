
<?php
/*
function ft_get_current_url()
{
	$fullUrl = $_SERVER["REQUEST_URI"];
	$urlArray = explode('/', $fullUrl);
	$urlPage = end($urlArray);
	return $urlPage;
}*/


function ft_get_stats($filePath)
{
				$docRaw = file_get_contents($filePath);
				$docLine = explode("\n", $docRaw);
				$dataAll = array();

				// fill array
				foreach ($docLine as $line)
				{
					$tmpRaw = explode("\t", $line);

					// if title exist, the row is not empty
					if ($tmpRaw[0] != NULL)
					{
						$tmpData = array('title' => $tmpRaw[0], 'down' => $tmpRaw[1], 'up' => $tmpRaw[2],
															'ratio' => 1, 'pot' => 0);
						if ($tmpData['down'] != 0)
							$tmpData['ratio'] = $tmpData['up'] / $tmpData['down'];
						else
							$tmpData['ratio'] = 1;
						$tmpData['pot'] = $tmpData['up'] * 4 / 3 - $tmpData['down'];

						$dataAll[] = array('title' => $tmpData['title'], 'down' => $tmpData['down'], 'up' => $tmpData['up'],
																'ratio' => $tmpData['ratio'], 'pot' => $tmpData['pot']);
					}
				}
				
				return $dataAll;
}

function ft_sort_data($dataAll, $key)
{				
				$sortingFunction = function($a, $b) use ($key)
				{
					// last line
					if (strcmp($a['title'], 'Total : ') == 0)
						return 1;
					if (strcmp($b['title'], 'Total : ') == 0)
						return -1;

					// key : none
					if (strcasecmp($key, "none") == 0)
					{
						return 1;
					}
					// key : string
					else if (strcasecmp($key, "title") == 0)
					{
						if (strcasecmp($b[$key], $a[$key]) == 0)
							return 0;
						return (strcasecmp($b[$key], $a[$key]) < 0 ? 1 : -1);
					}
					// key : number
					else
					{	
						if ($b[$key] == $a[$key])
							return 0;
						return ($b[$key] < $a[$key] ? -1 : 1);
					}
				};

				uasort($dataAll, $sortingFunction);
				
				return $dataAll;
}

function ft_get_total($dataAll)
{
	$stat = array('title' => '', 'down' => 0, 'up' => 0, 'ratio' => 1, 'pot' => 0);
	$i = 0;

	foreach($dataAll as $data)
	{
		$stat['up'] += $data['up'];
		$stat['down'] += $data['down'];
		$stat['pot'] += $data['pot'];

		$i++;
	}

	if ($stat['down'] == 0)
		$stat['ratio'] = 1;
	else
		$stat['ratio'] = $stat['up'] / $stat['down'];
	$stat['title'] = 'Total : '.$i;

	return $stat;
}

///////////////////////////////////////////////////////////////////////////////////////////

function ft_count_lines($path)
{
	$cmd = 'wc -l '.$path;
	$retRaw = shell_exec($cmd);
	$retArray = explode(' ', $retRaw);
	return $retArray[0];
}

function ft_get_files($path)
{
	$filesRaw = scandir($path, 1);
	$filesReturn = array();

	if ($filesRaw != FALSE)
	{
		foreach($filesRaw as $file)
		{
			$filesReturn[] = $file;
		}
	
		return $filesReturn;
	}

	return NULL;
}

function ft_get_next_file($path, $fileToFind)
{
	$filesRaw = ft_get_files($path);
	$file = current($filesRaw);

	while ($file != FALSE)
	{
		if (strpos($file, $fileToFind) !== FALSE)
		{
			$file = prev($filesRaw);
			
			if (strcmp($file, '.') != 0 && strcmp($file, '..') != 0)
				return $file;
			else
				return NULL;
		}
		$file = next($filesRaw);
	}

	return NULL;
}


function ft_get_previous_file($path, $fileToFind)
{
	$filesRaw = ft_get_files($path);
	$file = current($filesRaw);

	while ($file != FALSE)
	{
		if (strpos($file, $fileToFind) !== FALSE)
		{
			$file = next($filesRaw);

			if (strcmp($file, '.') != 0 && strcmp($file, '..') != 0)
				return $file;
			else
				return NULL;
		}
		$file = next($filesRaw);
	}

	return NULL;
}


/////////////////////////////////////////////////////////////////////

function ft_get_significant_number($number, $mod, $n)
{
	if ($number == 0 || $n <= 0)
		return 0;
	
	if ($number < 0)
	{
		$sign = '-';
		$number *= -1;
	}
	else
		$sign = '';
	
	if (strcmp($mod, ' Ko') == 0)
		$number /= 1024;

	if (strcmp($mod, ' Mo') == 0)
		$number /= (1024*1024);

	if (strcmp($mod, ' Go') == 0)
		$number /= (1024*1024*1024);

	$i = 0;
	$number_cpy = $number;
	while ($number_cpy > 1)
	{
		$i++;
		$number_cpy /= 10;
	}

	return $sign.round($number, $n - $i);
}

function ft_get_prefix($nb)
{
	if ($nb < 0)
		$nb *= -1;

	if ($nb > 1024*1024*1024)
		return ' Go';
	
	if ($nb > 1024*1024)
		return ' Mo';
	
	if ($nb > 1024)
		return ' Ko';

	return ' o';
}


?>

