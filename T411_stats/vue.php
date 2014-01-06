<?php

include_once('get.php');

//////////////////////////////////////////////////////////////////////////

function ft_get_path_previous_file($dataPath)
{
	$path = ft_get_previous_file($dataPath, $_GET['page']);

	if ($path != NULL)
	{
		if (isset($_GET['duration']))
			$path .= '&duration='.$_GET['duration'];
		if (isset($_GET['sort']))
			$path .= '&sort='.$_GET['sort'];
	}

	return $path;
}

function ft_get_path_next_file($dataPath)
{
	$path = ft_get_next_file($dataPath, $_GET['page']);

	if ($path != NULL)
	{
		if (isset($_GET['duration']))
			$path .= '&duration='.$_GET['duration'];
		if (isset($_GET['sort']))
			$path .= '&sort='.$_GET['sort'];
	}

	return $path;
}

///////////////////////////////////////////////////////////////////////

function ft_build_url_with_options($option, $expect)
{
	$path = '?page='.$option['page'];

	if ($path != NULL)
	{
		if (isset($except))
			unset($options[$except]);

		if (isset($option['duration']))
			$path .= '&duration='.$option['duration'];
		if (isset($option['sort']))
			$path .= '&sort='.$option['sort'];
	}

	return $path;
}

/////////////////////////////////////////////////////////////////


function ft_print_stats_page($dataPath)
{	
	$pathFilePrev = ft_get_path_previous_file($dataPath);
	$pathFileNext = ft_get_path_next_file($dataPath);

	$urlWithoutDuration = ft_build_url_with_options($_GET, 'duration');
	$urlWithoutSort = ft_build_url_with_options($_GET, 'sort');

	//=== MENU ===
	echo '
		<ul>
			<li>Homes</li>
			<ul>
				<li><a href="..">web site Home</a></li>
				<li><a href=".">T411 stat Home</a></li>
			</ul>

			<li>Pages</li>
			<ul>
				<li>Previous : <a href="?page='.$pathFilePrev.'">'.$pathFilePrev.'</a></li>
				<li>Next : <a href="?page='.$pathFileNext.'">'.$pathFileNext.'</a></li>
			</ul>

			<li>Analyse duration</li>
			<ul>
				<li><a href="'.$urlWithoutDuration.'">All</a></li>
				<li><a href="'.$urlWithoutDuration.'&duration=1">Daily</a></li>
				<li><a href="'.$urlWithoutDuration.'&duration=7">Weekly</a></li>
				<li><a href="'.$urlWithoutDuration.'&duration=30">Monthly</a></li>
			</ul>
		</ul>';

	//=== TABLE ===
	echo '
		<table>
			<tr>
				<th><a href="'.$urlWithoutSort.'&sort=title">Title</a></th>
				<th><a href="'.$urlWithoutSort.'&sort=down">Down</a></th>
				<th><a href="'.$urlWithoutSort.'&sort=up">Up</a></th>
				<th><a href="'.$urlWithoutSort.'&sort=ratio">Ratio</a></th>
			 <th><a href="'.$urlWithoutSort.'&sort=pot">Potentiel download</a></th>
		</tr>';


		if (!isset($_GET['duration']))
		{
 			$dataAll = ft_get_stats($dataPath.$_GET['page']);
		}
		else
		{
 			$data1 = ft_get_stats($dataPath.$_GET['page']);
			
			$ref = ft_get_previous_file($dataPath, $_GET['page']);
			if ($ref == NULL)
				$data2 = $data1;
			else
			{	
				for ($i = 0; $i < $_GET['duration']; $i++)
				{
					$newRef = ft_get_previous_file($dataPath, $ref);
					if ($newRef != NULL)
						$ref = $newRef;
				}
				$data2 = ft_get_stats($dataPath.$ref);
			}
			$dataAll = ft_sub_stats($data1, $data2);
		}

		if (isset($_GET['sort']))	$key = $_GET['sort'];
		else											$key = 'none';
		$dataAll = ft_sort_data($dataAll, $key);
		ft_print_stats($dataAll);

		$statAll = ft_get_total($dataAll);
		ft_print_total($statAll);

	echo '</table>';
}


function ft_sub_stats($data1, $data2)
{
	$ret = array();

	foreach ($data1 as $line1)
	{
		foreach ($data2 as $line2)
		{
			if (strcmp($line1['title'], $line2['title']) == 0)
			{
				$tmp = array('title' => $line1['title'],
											'down' => $line1['down']-$line2['down'],
											'up' => $line1['up']-$line2['up'],
											'ratio' => 1,
											'pot' => 0);
				$tmp['ratio'] = 1;
				$tmp['pot'] = $tmp['up'] * 4/3 - $tmp['down'];

				$ret[] = array('title' => $tmp['title'],
												'down' => $tmp['down'],
												'up' => $tmp['up'],
												'ratio' => $tmp['ratio'],
												'pot' => $tmp['pot']);
			}
		}
	}

	return $ret;
}


function ft_print_stats($dataAll)
{
	// print array
	foreach ($dataAll as $data)
	{
		echo '<tr>';

		// title
		echo '<td>'.$data['title'].'</td>';
	
		// down
		$unit = ft_get_prefix($data['down']);
		$number = ft_get_significant_number($data['down'], $unit, 3);
		echo '<td class="nb">'.$number.$unit.'</td>';
						
		// up
		$unit = ft_get_prefix($data['up']);
		$number = ft_get_significant_number($data['up'], $unit, 3);
		echo '<td class="nb">'.$number.$unit.'</td>';

		// ratio
		if ($data['ratio'] < 0.75)		$class = 'colorRed';
		else if ($data['ratio'] > 3)	$class = 'colorGreen';
		else													$class = '';

		echo '<td class="ratio '.$class.'">'.number_format($data['ratio'], 2).'</td>';

		// potentiel
		$unit = ft_get_prefix($data['pot']);
		$number = ft_get_significant_number($data['pot'], $unit, 3);

		if ($number < 0)										$class = 'colorRed';
		else if (strcmp($unit, ' Go') == 0)	$class = 'colorGreen';
		else																$class = '';

		echo '<td class="nb '.$class.'">'.$number.$unit.'</td>';

		echo '</tr>';
	}

}

function ft_print_total($total)
{
				echo '<tr>';

					echo '<th>'.$total['title'].'</th>';
					
					$unit = ft_get_prefix($total['down']);
					$number = ft_get_significant_number($total['down'], $unit, 3);
					echo '<th class="nb">'.$number.$unit.'</th>';

					$unit = ft_get_prefix($total['up']);
					$number = ft_get_significant_number($total['up'], $unit, 3);
					echo '<th class="nb">'.$number.$unit.'</th>';

					if ($total['down'] == 0)
						$totalRatio = 1;
					else
						$totalRatio = $total['up'] / $total['down'];
					echo '<th class="ratio">'.round($totalRatio, 2).'</th>';

					$unit = ft_get_prefix($total['pot']);
					$number = ft_get_significant_number($total['pot'], $unit, 3);
					echo '<th class="nb">'.$number.$unit.'</th>';

			echo '</tr>';

}


function ft_print_links($dataPath)
{
	$data = ft_get_files($dataPath);

	if ($data != NULL)
	{
		echo '<h2>Stats files found :</h2>';

		echo '<table>';
		echo '<tr>';
			echo '<th>File</th>';
			echo '<th>Torrents</th>';
		echo '</tr>';
		foreach($data as $file)
		{
			if (strcmp($file, '.') != 0 && strcmp($file, '..') != 0)
			{
				echo '<tr>';
					echo '<td><a href="?page='.$file.'">'.$file.'</a></td>';
					echo '<td class="center">'.ft_count_lines($dataPath.$file).'</td>';

				echo '</tr>';
			}
		}
		echo '</table>';
	}
}


