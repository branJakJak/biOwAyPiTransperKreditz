<?php
use Sunra\PhpSimple\HtmlDomParser;
class VicidialCampaignRetriever {


    public function retrieve()
    {
    	/*request raw page*/
		$rawhtmlPage = $this->requestData("https://162.250.124.167/vicidial/admin.php?ADD=10");
		/*extract table */
		$rawTableHtml = $this->extractTableFromRaw($rawhtmlPage);
		/*extract data*/
		return $this->extractData($rawTableHtml);
    }
    protected function requestData($url , $username="admin", $password="Mad4itNOW!!")
    {
    	$curlres = curl_init($url);
    	$httpHeader = array("Authorization:Basic YWRtaW46TWFkNGl0Tk9XISE=");
    	curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($curlres, CURLOPT_SSL_VERIFYPEER, false);
    	curl_setopt($curlres, CURLOPT_SSL_VERIFYHOST, false);
    	curl_setopt($curlres, CURLOPT_HTTPHEADER, $httpHeader);
    	// curl_setopt($curlres, CURLOPT_USERNAME, $username);
    	// curl_setopt($curlres, CURLOPT_PASSWORD, $password);
    	return curl_exec($curlres);
    }
    /**
     * Extracts table from raw html page
     * @param  string $rawhtmlPage contains the raw html retrieved from curl
     * @return string              returns the extracted table
     */
    public function extractTableFromRaw($rawhtmlPage)
    {
        $dom = HtmlDomParser::str_get_html( $rawhtmlPage );
        return $dom->find("body > center > table:nth-child(1) > tbody > tr:nth-child(1) > td:nth-child(2) > table > tbody > tr:nth-child(5) > td > table > tbody > tr > td > font > center > table",0);
    }
    /**
     * Returns array containing extracted data from raw table html
     * @param  string $rawTableHtml contains raw table html
     * @return array               the extracted data ready to be use by carrdataprovider
     */
    public function extractData($rawTableHtml)
    {
    	$extractedDataArr  = array();
    	$extractedData = array();
    	$dom = HtmlDomParser::str_get_html( $rawTableHtml );
    	$index = 0;
    	foreach ($dom->find("tr") as $currentTr) {
    		/*skip first line*/
    		if ($index === 0) {
    			$index++;
    			# code...
    		}else{

    			$extractedData[] = array(
						'id'=>$index++,
						'campaign_id'=>$this->cleanData($currentTr->find("td",0)->plaintext),
						'name'=>$this->cleanData($currentTr->find("td",1)->plaintext),
						'is_active'=>$this->cleanData($currentTr->find("td",2)->plaintext),
    				);
    		}
    	}
    	return $extractedData;
    }
    private function cleanData($dirtData){
        $dirtData =str_replace("&nbsp;", "", $dirtData);
        $dirtData = ltrim($dirtData);
        $dirtData = rtrim($dirtData);
        return trim($dirtData);
    }
}