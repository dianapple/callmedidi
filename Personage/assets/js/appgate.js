/**
 * Theme starting point
 * Author    : Mohsen Heydari
 * Version   : 1.0
 * Web site  : http://devmash.net
 * Contact   : mohsenheydari@live.com
 */

(function(){

	var appscript     = document.createElement('script');
	appscript.type    = 'text/javascript';
	appscript.src     = appdata.path.js + '/require.js';
	appscript.setAttribute('data-main', appdata.path.js + '/' + appdata.appname);
	document.body.appendChild(appscript);
	
	//Run extra scripts here
	if( '' != appdata.extrajs )
		eval(appdata.extrajs);

})();