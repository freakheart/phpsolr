<?php
class QueryExecutor
{
	/**
	 * Solr hostname.
	 *
	 * @var string
	 */
	protected $_solr_status;
	
	protected $_result;
	
	/**
	 * @method __get 
	 * @param The variable you want to get from this class 
	 * @return The selected variable of the class
	 */
	public function __get( $property )
	{
		if ( property_exists( $this, $property ) )
		{
			return $this->$property;
		}
	}
	
	/**
	 * @method __set 
	 * @param The variable you want to set 
	 * @param The variable value 
	 * @return The $this from which you can set all the values of this class
	 */
	public function __set( $property, $value )
	{
		if ( property_exists( $this, $property ) )
		{
			$this->$property = $value;
		}
		return $this;
	}
    
    /**
     * QueryExecutor Constructor
     *
     * @param 
     */
    public function __construct()
    {
    	
    }
    
    public function executeQuery($query)
    {
//     	try 
//     	{
//     		$this->pingSolr( $query->_hostname.':'.$query->_port.'/solr/' );
//     	}
//     	catch (Exception $e)
//     	{
//     		echo $e->getMessage();
//     	}
//     	$result = file_get_contents( $query->_url );
    	session_start();
    	$_SESSION['percentage']['currentPercentageIndexUpdate'] = "60";
    	$_SESSION['percentage']['info'] = $GLOBALS['text_update_status_index_curl_init'];
    	session_write_close();
    	
    	$ch = curl_init();
    	curl_setopt( $ch, CURLOPT_URL, $query->_url );
    	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    	
    	session_start();
    	$_SESSION['percentage']['currentPercentageIndexUpdate'] = "80";
    	$_SESSION['percentage']['info'] =  $GLOBALS['text_update_status_index_curl'];
    	session_write_close();
    	
    	$this->_result  = curl_exec( $ch );
    	
    	curl_close( $ch );
//     	print_r( array( $this->_result  ) );
    	
//     	error_log(print_r($this->_results ,true));
    }
    
    /**
     * @method pingSolr  To check response time.
     * @param The doamin name.
     * @return Status of the ping query.
     */
    private function pingSolr($domain)
    {
	    $starttime = microtime(true);
	    $file      = fsockopen ($domain, 80, $errno, $errstr, 10);
	    $stoptime  = microtime(true);
	    $status    = 0;
	 
	    if (!$file) 
	    {
	    	$status = -1;  // Site is down
	    	throw new Exception('Solr server is not running or it is not responding.');
	    }
	    else 
	    {
	        fclose($file);
	        $status = ($stoptime - $starttime) * 1000;
	        $status = floor($status);
	    }
	    return $status;
    }
}