<?php
	include_once('modele/init.php');
					function ft_print_signup_form()
					{
						echo '<p><form method="post" action="index.php?page=signup">
									<table>
										<tr>
											<td><label for="pseudo">Pseudo : </label></td>
											<td><input type="text" name="pseudo" id="pseudo" maxlength="10" required /></td>
										</tr><tr>
											<td><label for="pass">Mot de passe :</label></td>
											<td><input type="password" name="pass" id="pass" required /></td>
										</tr><tr>
											<td><label for="passre">Vérification du mot de passe :</label></td>
											<td><input type="password" name="passre" id="passre" required /></td>
										</tr><tr>
											<td><label for="mail">Adresse email :</label></td>
											<td><input type="email" name="mail" id="mail" size="30" required /></td>
										</tr><tr>
											<td colspan="2" class="center"><input type="submit" value="S\'inscrire" /></td>
										</tr>
									</table>
									</form></p>';
					}
?>

