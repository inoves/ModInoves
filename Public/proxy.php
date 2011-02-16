$dom = new DomDocument();
$dom->loadXML(file_get_contents('http://cinema.sapo.pt'));
$body = $dom->documentElement->getElementsByTagName('body')->item(0);
echo $body->getAttributeNode('background')->value. "\n";

<?php
/**
* @filename: proxy.php
*
* Proxy transparent cross-domain
*    @example
*        //add rule rewrite (lighttpd): "^/proxy/(.+)$"=>"/proxy.php?$1",
*       <a href="http://proxyaddress.com/proxy.php?url=http://frameinoves/ola.php"
*            -> http://getcontenturladdress.com/arg1/arg2?foo=bar, send all headers from client via request and later send all header(cookies) back to browser
*
* @autor Steven Koch<steven.koch@sapo.pt>
*/

//make your permission whitelist
$whiteListURLs = array('prefix'=>'http://frameinoves/ola.php');
foreach($whiteListURLs as $prefix=>$checkUrl){
	if(strpos($checkUrl, urldecode($_GET['url']))==0){
		define( 'PREFIX_COOKIE', $prefix );
		define( 'URL', urldecode($_GET['url']) );
	}
}

//make resource
$ch =  curl_init();
curl_setopt($ch, CURLOPT_URL, URL);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, getHeadersFromServer(true) );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

//get contents
$response = curl_exec( $ch );
list($response_headers, $response_body) = explode("\r\n\r\n", $response, 2);

//send your header
$ary_headers = explode("\n", $response_headers );

foreach($ary_headers as $hdr) {

	if(strpos($hdr, 'Set-Cookie:')!==false){
		$hdr = str_replace('Set-Cookie: ', '', $hdr);
		$ahdr = explode("\n", $hdr);
		foreach($ahdr as $k=>$v){
			$ahdr[$k] = PREFIX_COOKIE.$v;
		}
		header('Set-Cookie: '. implode("\n", $ahdr));
	}else{
		header($hdr);
	}
}
echo $response_body;
exit(0);

//---
function getHeadersFromServer($onlyCookie=false)
{
    $headers = array();
	if($onlyCookie){
        $headers[] = 'Cookie: '.preg_replace('/'.PREFIX_COOKIE.'(.+=)?/', '$1', $_SERVER['HTTP_COOKIE']);
	}else{
	    foreach ($_SERVER as $k => $v)
	    {		
			if (substr($k, 0, 5) == "HTTP_")
		    {
		        $k = str_replace('_', ' ', substr($k, 5));
		        $k = str_replace(' ', '-', ucwords(strtolower($k)));
				if($k=='Cookie')
        			$headers[] = 'Cookie: '.preg_replace('@'.PREFIX_COOKIE.'(.+=)?@', '${1}', $v);
				else
		        	$headers[] = $k.': '.$v;
		    }
		}
    }
    return $headers;
}

