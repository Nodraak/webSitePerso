/* 
* @Author: Adrien Chardon
* @Date:   2014-01-22 11:51:07
* @Last Modified by:   Adrien Chardon
* @Last Modified time: 2014-01-23 16:48:12
*/


function updateCurrent(id)
{
	var current = document.getElementById('current');
	current.innerHTML = id;

	playMusic(id);
}

function playMusic(id)
{
	var xmlHttp = null;

	xmlHttp = new XMLHttpRequest();
	xmlHttp.open('GET', 'play.php?id='+id, true);
	xmlHttp.send(null);
	return xmlHttp.responseText;
}

function updateSoundP()
{
	var xmlHttp = null;

	xmlHttp = new XMLHttpRequest();
	xmlHttp.open('GET', 'play.php?level=P', true);
	xmlHttp.send(null);
	return xmlHttp.responseText;
}

function updateSoundM()
{
	var xmlHttp = null;

	xmlHttp = new XMLHttpRequest();
	xmlHttp.open('GET', 'play.php?level=M', true);
	xmlHttp.send(null);
	return xmlHttp.responseText;
}

