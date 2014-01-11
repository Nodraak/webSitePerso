<?php
	echo '<p><form method="post" action="index.php?page=new_thread">
			<table>
				<tr>
					<td><label for="title">Titre du sujet :</label></td>
				</tr><tr>
					<td><input type="text" name="title" id="title" size="99" required /></td>
				</tr><tr>
					<td><label for="text">Votre message :</label></td>
				</tr><tr>
					<td><textarea name="text" id="text" rows=10 cols=75 required></textarea></td>
				</tr><tr>
					<td class="center"><input type="submit" value="Créer le sujet" /></td>
				</tr>
			</table>
		</form><p>';
?>