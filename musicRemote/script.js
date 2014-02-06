/* 
* @Author: Adrien Chardon
* @Date:   2014-01-22 11:51:07
* @Last Modified by:   Adrien Chardon
* @Last Modified time: 2014-02-06 17:37:02
*/


var timer;
var timerOn = 0;

window.onload = checkIfPlaying();

function playMusic(id)
{
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

	document.getElementById('timeCurrent').innerHTML = timeToStr(data[3]);
	document.getElementById('timeLeft').innerHTML = timeToStr(data[4]-data[3]);

	if (timerOn == 1)
		window.clearInterval(timer);
	timer = setInterval(function(){updateInfo()}, 1000);
	timerOn = 1;
}


function updateInfo()
{
	if (strToTime(document.getElementById('timeLeft').innerHTML) <= 0)
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
	else if (timerOn == 1)
	{
		document.getElementById('timeCurrent').innerHTML = timeToStr(strToTime(document.getElementById('timeCurrent').innerHTML) + 1);

		document.getElementById('timeLeft').innerHTML = timeToStr(strToTime(document.getElementById('timeLeft').innerHTML) - 1);
	}
}

function timeToStr(time)
{
	var mn = Math.floor(time / 60);
	var sec = time % 60;

	if (sec < 10)
		secStr = '0'+sec;
	else
		secStr = sec;

	return mn + ':' + secStr;
}

function strToTime(str)
{
	var data = str.split(':');
	var mn = data[0];
	var sec = data[1];
	
	return parseInt(mn)*60 + parseInt(sec); // and fuck js -> parseInt
}

function checkIfPlaying()
{
	var xmlHttp = null;

	xmlHttp = new XMLHttpRequest();
	xmlHttp.open('GET', 'play.php?action=getIfPlaying', false);
	xmlHttp.send(null);

	var ret = xmlHttp.responseText;
	
	if (ret == 'PLAY')
	{
		getInfo();
		if (timerOn == 1)
			window.clearInterval(timer);
		timer = setInterval(function(){updateInfo()}, 1000);
		timerOn = 1;
	}
}


