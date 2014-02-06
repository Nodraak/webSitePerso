/* 
* @Author: Adrien Chardon
* @Date:   2014-01-22 11:51:07
* @Last Modified by:   Adrien Chardon
* @Last Modified time: 2014-02-06 17:37:02
*/


var timer;
var timerOn = 0;

function playMusic(id)
{
	var currentMusic = document.getElementById('current');
	currentMusic.innerHTML = 'Playing : ' + id;

	var xmlHttp = null;

	xmlHttp = new XMLHttpRequest();
	xmlHttp.open('GET', 'play.php?action=playMusic&id='+id, false);
	xmlHttp.send(null);

	getInfo();

	if (timerOn == 1)
		window.clearInterval(timer);
	timer = setInterval(function(){updateInfo()}, 1000);
	timerOn = 1;

	return xmlHttp.responseText;
}

function soundUp()
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

function play()
{
	var xmlHttp = null;

	xmlHttp = new XMLHttpRequest();
	xmlHttp.open('GET', 'play.php?action=play', true);
	xmlHttp.send(null);

	getInfo();
	if (timerOn == 1)
		window.clearInterval(timer);
	timer = setInterval(function(){updateInfo()}, 1000);
	timerOn = 1;

	return xmlHttp.responseText;
}

function pause()
{
	var xmlHttp = null;

	xmlHttp = new XMLHttpRequest();
	xmlHttp.open('GET', 'play.php?action=pause', true);
	xmlHttp.send(null);
	
	if (timerOn == 1)
	{
		window.clearInterval(timer);
		timerOn = 0;
	}

	return xmlHttp.responseText;
}

function getInfo()
{
	var xmlHttp = null;

	xmlHttp = new XMLHttpRequest();
	xmlHttp.open('GET', 'play.php?action=getInfo', false);
	xmlHttp.send(null);

	var data = xmlHttp.responseText.split("#");

	document.getElementById('title').innerHTML = 'Titre : ' + data[1];
	document.getElementById('album').innerHTML = 'Album : ' + data[2];
	document.getElementById('artist').innerHTML = 'Artiste : ' + data[0];

	document.getElementById('timeCurrent').innerHTML = data[3];
	document.getElementById('timeLeft').innerHTML = data[4]-data[3];

	if (timerOn == 1)
		window.clearInterval(timer);
	timer = setInterval(function(){updateInfo()}, 1000);
	timerOn = 1;
}


function updateInfo()
{
	document.getElementById('timeCurrent').innerHTML ++;
	document.getElementById('timeLeft').innerHTML --;

	if (document.getElementById('timeLeft').innerHTML <= 0)
	{
		if (timerOn == 1)
		{
			window.clearInterval(timer);
			timerOn = 0;
		}
		
		document.getElementById('title').innerHTML = 'Titre : -';
		document.getElementById('album').innerHTML = 'Album : -';
		document.getElementById('artist').innerHTML = 'Artiste : -';

		document.getElementById('timeCurrent').innerHTML = '-';
		document.getElementById('timeLeft').innerHTML = '-';

	}
}


