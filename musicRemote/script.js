/* 
* @Author: Adrien Chardon
* @Date:   2014-01-22 11:51:07
* @Last Modified by:   Adrien Chardon
* @Last Modified time: 2014-02-06 17:18:38
*/

function playMusic(id)
{
	var currentMusic = document.getElementById('current');
	currentMusic.innerHTML = id;

	var xmlHttp = null;

	xmlHttp = new XMLHttpRequest();
	xmlHttp.open('GET', 'play.php?action=playMusic&id='+id, true);
	xmlHttp.send(null);

	return xmlHttp.responseText;
}

function soundup()
{
	var xmlHttp = null;

	xmlHttp = new XMLHttpRequest();
	xmlHttp.open('GET', 'play.php?action=soundUp', true);
	xmlHttp.send(null);
	
	return xmlHttp.responseText;
}

function soundDown()
{
	var xmlHttp = null;

	xmlHttp = new XMLHttpRequest();
	xmlHttp.open('GET', 'play.php?action=soundDown', true);
	xmlHttp.send(null);
	
	return xmlHttp.responseText;
}

