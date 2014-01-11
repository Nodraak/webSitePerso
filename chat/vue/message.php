<?php

	echo '<h2>'.$forum->get_title().'</h2>';

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

?>