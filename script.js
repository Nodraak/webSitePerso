/* 
* @Author: Adrien Chardon
* @Date:   2014-01-22 11:51:07
* @Last Modified by:   Adrien Chardon
* @Last Modified time: 2014-01-23 16:48:12
*/
	// on load
	updateFontSize(0);

	var elemFontP = document.getElementById('fontP');
	elemFontP.onclick = function()
	{
		updateFontSize(1);
	};

	var elemFontM = document.getElementById('fontM');
	elemFontM.onclick = function()
	{
		updateFontSize(-1);
	};

	function updateFontSize(size)
	{
		var elems = document.getElementsByTagName('*');
		for (var i=0; i<elems.length; i++)
		{
			var sizeStr = getComputedStyle(elems[i], null).fontSize;
			var sizeInt = parseInt(sizeStr) + size;

	    	elems[i].style.fontSize = sizeInt + 'px';
		}

		var textElem = document.getElementsByTagName('p');
		var textSizeStr = getComputedStyle(textElem[0], null).fontSize;
		var textSizeInt = parseInt(textSizeStr);
		var elemFontSize = document.getElementById('fontSize');
		elemFontSize.innerHTML = textSizeInt;
	}
