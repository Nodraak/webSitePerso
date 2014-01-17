<?php

exec('git rev-parse --verify HEAD 2> /dev/null', $output);
$version = $output[0];

echo '
<footer>
	<div class="left"></div>
	<div class="middle center">
		<p>
			Conception et réalisation Adrien Chardon.<br />
			Page perso, mais code public, dispo sur mon <a href="https://github.com/Nodraak/webSitePerso/tree/master/chat">github</a>.
			<span style="font-size: x-small;">commit git : '.$version.'</span>
		</p>
	</div>
	<div class="right"></div>
</footer>';

?>
