<?php 
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'vendor/autoload.php';

use Sunra\PhpSimple\HtmlDomParser;

$fileOutput = dirname(__FILE__).DIRECTORY_SEPARATOR.'data.log';
$curlURL = "http://hs3x.com/read-sms-447441911018.html?act=update";
$curlres = curl_init($curlURL);
curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
$curlResRaw = curl_exec($curlres);
$dom = HtmlDomParser::str_get_html( $curlResRaw );
$dTable =  $dom->find("table",0);
$index = 0;
foreach ($dTable->find("tbody > tr") as $currentRow) {
	if ($index !== 0) {
		if (strpos(strtolower($currentRow->find("td",1)->plaintext), "opt")) {
			echo sprintf("%s",$currentRow->find("td",0)->plaintext).PHP_EOL;
			file_put_contents($fileOutput, sprintf("%s",$currentRow->find("td",0)->plaintext).PHP_EOL,FILE_APPEND);
		}
	}
	$index++;
}
?>