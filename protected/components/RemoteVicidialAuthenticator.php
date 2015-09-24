<?php


class RemoteVicidialAuthenticator {

	protected $cookieFile;
	private $username;
	private $password;
	function __construct() {
		$this->setCookieField(  sys_get_temp_dir().DIRECTORY_SEPARATOR.'vicidialReportCookie' );
	}

	public function getAuthenticate()
	{
		
	}

	/**
	 * Retrieves cookie file
	 *
	 * @return string the path to cookie file
	 */
	public function getCookieField() {
	    return $this->cookieField;
	}
	
	/**
	 * sets the path to cookie file
	 *
	 * @param String $newcookieField The path to cookie file
	 */
	public function setCookieField($cookieField) {
	    $this->cookieField = $cookieField;
	    return $this;
	}	

}