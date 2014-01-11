<?php
	echo '<p><form method="post" action="index.php?page=login">
			<table>
				<tr>
					<td><label for="pseudo">Pseudo : </label></td>
					<td><input type="text" name="pseudo" id="pseudo" required /></td>
				</tr><tr>
					<td><label for="pass">Mot magique :</label></td>
					<td><input type="password" name="pass" id="pass" required /></td>
				</tr><tr>
					<td colspan="2" class="center"><input type="submit" value="Se connecter" /></td>
				</tr>
			</table>
		</form></p>';
	
	echo '<p><a href="?page=lost_pass">Mot de passe oublié ?</a></p>';

	echo '<h2>Nouveau ?</h2>
			<p>Inscrivez vous en <a href="index.php?page=signup">cliquant ici</a>.</p>';
?>