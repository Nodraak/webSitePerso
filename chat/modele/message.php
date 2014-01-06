
<?php

function ft_parse_text($in)
{
	$tmp = nl2br(htmlspecialchars($in));


	// escape char, must be first
	$tmp = str_replace('\[', '&#91', $tmp);
	// tab
	$tmp = str_replace('\t', '&nbsp;&nbsp;&nbsp;&nbsp;', $tmp);

	// smiley must be before color (purple)
	$tmp = str_replace(':p', '<span class="smiley_p"></span>', $tmp);

	$tmp = preg_replace('#\[b\](.+)\[/b\]#sU', '<span class="bold">$1</span>', $tmp);
	$tmp = preg_replace('#\[i\](.+)\[/i\]#sU', '<span class="italic">$1</span>', $tmp);
	$tmp = preg_replace('#\[u\](.+)\[/u\]#sU', '<span class="underline">$1</span>', $tmp);
	$tmp = preg_replace('#\[s\](.+)\[/s\]#sU', '<span class="barre">$1</span>', $tmp);
	$tmp = preg_replace('#\[c\](.+)\[/c\]#sU', '<div class="center">$1</div>', $tmp);


	// color
	$tmp = preg_replace('#\[color=(.+)\](.+)\[/color\]#sU', '<span style="color:$1;">$2</span>', $tmp);
	// link
	$tmp = preg_replace('#\[a=(.+)\](.+)\[/a\]#sU', '<a href="http://$1">$2</a>', $tmp);
	// size
	$tmp = preg_replace('#\[size=(.+)\](.+)\[/size\]#sU', '<span class="fontSize$1">$2</span>', $tmp);





	return $tmp;
}

?>

