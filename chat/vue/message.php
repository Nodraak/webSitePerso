<?php

/******************************************************************************* 
*
*   File : 
*
*   Author : Adrien Chardon
*   Date :   2014-01-11 19:09:34
*
*   Last Modified by :   Adrien Chardon
*   Last Modified time : 2014-01-17 22:57:56
*
*******************************************************************************/

	function ft_print_offset_links()
	{
		$forum = new Forum($_GET['id']);

		$nbPages = (int)(($forum->get_nbMessage()-1) / NB_MESSAGES_PER_PAGE) + 1;
		
		$baseUrl = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		$baseUrl = removeqsvar($baseUrl, 'offset');
		$baseUrl = removeqsvar($baseUrl, 'error');

		echo '<div class="pagesBar">';
			echo '<span><<</span>';
		for ($i = 1; $i <= $nbPages; $i++)
		{
			if (isset($_GET['offset']) && $i == $_GET['offset'])
				$actual = 'class="actual"';
			else
				$actual = '';

			echo '<a href="'.$baseUrl.'&offset='.$i.'" '.$actual.'>'.$i.'</a>';
		}
		echo '<span>>></span>';
		echo '</div>';
	}

	echo '<h2>'.$forum->get_title().'</h2>';
	
	/*=== page (offset links) ===*/
	ft_print_offset_links();

	/*=== mesages ===*/
	while ($data = $ret->fetch())
	{
		$message = new Message($data['id']);
		$author = new Membre($message->get_author());
		
		echo '
		<table>
			<tr class="topBar">
				<td class="author"><a href="index.php?page=user&id='.$message->get_author().'">'.$author->get_pseudo().'</a></td>
				<td class="timeEdit">
					<div class="time">Posté (ou édité) le '.date('d/m/Y à H\hi', $message->get_posted()).'</div>'
					.$author->get_edit($message).'</td>
			</tr>
			<tr class="content">
				<td class="avatar"><img src="'.$author->get_avatar(80).'" alt="avatar" style="max-width: 80px; max-height: 80px;"/></td>
				<td class="textSignBorder">
					<div class="textSign">
						<div class="text">'.$message->get_text_parse().'</div>
						'.$author->get_sign().'
					</div>
				</td>
			</tr>
		</table>';
	}

	ft_print_offset_links();

	/*=== form post : new message ===*/
	$nbPages = (int)(($forum->get_nbMessage()-1) / NB_MESSAGES_PER_PAGE) + 1;

	if (isset($_GET['offset']) && $_GET['offset'] == $nbPages)
	{
		echo '<div class="post_message"><p>
				<form method=post action=index.php?page=post>
					<label for=message>Votre mesage :</label>
				<br />
					<textarea name=message id=message rows=10 cols=75 required></textarea>
					<input type=hidden name=thread_id value='.$_GET['id'].' />
				<br />
					<input type=submit value=Poster />
				</form>
			</div></p>';
	}
	else
	{
		$baseUrl = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		$baseUrl = removeqsvar($baseUrl, 'offset');
		$baseUrl = removeqsvar($baseUrl, 'error');

		echo '<div class="post_message center"><p>
				Pour poster un message, lisez d\'abord ceux qui ont<br/>
				déja été postés, le formulaire est à la <a href="'.$baseUrl.'&offset=last">dernière page</a>.
			</div></p>';
	}
?>