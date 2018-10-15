<?php
class QueryResponseParser
{
	protected $_total;
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
     * QueryResponseParser Constructor
     *
     * @param 
     */
    public function __construct()
    {
    	
    }
    
    public function parseOutput($output)
    {
    	$result = json_decode ($output, true);
//     	error_log(print_r($result,true));
// 		error_log(print_r($this->addHeaderInfo($result), true ));
		$this->_result = $this->convertResults($result);
// 		error_log(print_r( $this->_result , true ));
    }

    /**
     * Parses header data (if available) and adds it to result data and Parses the results also
     *
     * @param  array $data
     * @param  array $result
     * @return mixed
     */
    public function convertResults($data)
    {
    	$result = array();
    	
    	if (isset($data['responseHeader']))
    	{
    		$result['status'] = $data['responseHeader']['status'];
    		$result['queryTime'] = $data['responseHeader']['QTime'];
    	}
    	
    	if(isset($data['response']))
    	{
    		$result['numFound'] = $data['response']['numFound'];
    		$result['docs'] = $data['response']['docs'];
    	}
    	elseif(isset($data['grouped']))
    	{
    		foreach ($data['grouped'] as $key=>$value)
    		{
    			if ( isset( $data['grouped'][$key]['ngroups'] ) ) {
    				$result['ngroups'] = $data['grouped'][$key]['ngroups'];
    			}
    			$result['numFound'] = $data['grouped'][$key]['matches'];
    			$result['docs'] = $data['grouped'][$key]['groups'];
    		}
    	}
//     	error_log(print_r($data,true));
    	if(isset($data['spellcheck']['suggestions']))
    	{
    		if(isset($data['spellcheck']['suggestions'][1]['suggestion']))
    		{
    			foreach($data['spellcheck']['suggestions'][1]['suggestion'] as $cuVal)
    			{
    				$result['spellcheck'][] = $cuVal;
    			}
    		}
    	}
//     	error_log(print_r($result,true));
    	return $result;
    }
}