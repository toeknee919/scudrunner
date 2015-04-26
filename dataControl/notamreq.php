<?php session_start();
#this script retreives notams for an airport from the FAA website.
# pass in the 4 leter identifier to get the notams for that airport.
	$apt = $_GET['airport'];


	$url = "https://www.notams.faa.gov/dinsQueryWeb/queryRetrievalMapAction.do";
	$ch = curl_init($url);

	$header = array('Host: www.notams.faa.gov', 'Content-Type: application/x-www-form-urlencoded', 'Cache-Control: max-age=0', 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,/*;q=0.8', 'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36', 'Referer: https://www.notams.faa.gov/dinsQueryWeb/', 'Accept-Encoding: gzip,deflate', 'Accept-Language: en-US,en;q=0.8', 'Origin: https://www.notams.faa.gov');

	$data = 'retrieveLocId='. $apt . '&reportType=Raw&submit=View+NOTAMSs&actionType=notamRetrievalByICAOs';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$response = curl_exec($ch);

	#set up to look through html for notams
	$dom = new DOMDocument();
	$dom->loadHTML($response);

	$xpath = new DOMXPath($dom);

	/* Query all <td> nodes containing specified class name */
	$nodes = $xpath->query("//td[@class='textBlack12']");

	$output = array();

	/* Traverse the DOMNodeList object to output each DomNode's nodeValue */
	foreach ($nodes as $node) {
		if($node->textContent){
			array_push($output, $node->textContent, '<br>');
		}
	}

	foreach($output as $a){
		echo $a;
	}

	curl_close($ch);

?>