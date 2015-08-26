function getCookieIdioma(c_name)
{
    var i,x,y,ARRcookies=document.cookie.split(";");
    for (i=0;i<ARRcookies.length;i++)
    {
        x = ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
        x = x.replace(/^\s+|\s+$/g,"");
        if (x == c_name)
        {
            return unescape(y);
        }
    }
}

var idioma = getCookieIdioma("siacc_lang_sigla");
if ((idioma == null) || (idioma == "") || (idioma == "undefined"))
	idioma = "pt-BR";

var head = document.getElementsByTagName('head')[0];
var script = document.createElement('script');
script.type = 'text/javascript';
script.src = 'js/lang/' + idioma + '.js';
head.appendChild(script);