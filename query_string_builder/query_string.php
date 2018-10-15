<?php
class Querystring
{

    /**
     * Queries storage.
     *
     * @var array
     */
    protected $_fields = array();

    /**
     * Sub-queries storage.
     *
     * @var array
     */
    protected $_subQueries = array();

    /**
     * Default operator for joining fields
     *
     * @var string
     */
    protected $_fieldSeparator = 'AND';
    
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
     * Add a field to Querystring
     *
     * @param Field $field
     * @param String $key  OPTIONAL identifier to use later for removing or overwriting
     * @return Querystring
     */
    public function addField(Field $field, $key = null)
    {
        if ($key) {
            $this->_fields[$key] = $field;
        }
        else {
            $this->_fields[] = $field;
        }

        return $this;
    }

    /**
     * Add another Querystring object to current query
     *
     * @param Querystring $query
     * @param String $key  OPTIONAL identifier to use later for removing or overwriting
     * @return Querystring
     */
    public function addSubQuery(Querystring $query, $key = null)
    {
        if ($key) {
            $this->_subQueries[$key] = $query;
        }
        else {
            $this->_subQueries[] = $query;
        }
    }

    /**
     * Set the operator for joining Fields
     *
     * @param  String $separator  AND|OR
     * @return String Querystring
     */
    public function setFieldSeparator($separator)
    {
        if ($separator == 'AND' || $separator == 'OR') {
            $this->_fieldSeparator = $separator;
        }

        return $this;
    }

    /**
     * Removes a sub-Query using key
     *
     * @param  $key
     * @return Querystring
     */
    public function removeSubQuery($key)
    {
        unset($this->_subQueries[$key]);
        return $this;
    }

    /**
     * Removes a Field using key
     *
     * @param  $key
     * @return Querystring
     */
    public function removeField($key)
    {
        unset($this->_fields[$key]);
        return $this;
    }


    /**
     * Build RAW query string
     *
     * @return string
     */
    public final function __toString()
    {
        $output = trim($this->_renderRawOutput());

        if (!empty($this->_subQueries)) {
            $subOutput = ' ('. implode(') ' . $this->_fieldSeparator . ' (', $this->_subQueries) . ') ';
            if (!empty($output)) {
                $output .= ' ' . $this->_fieldSeparator . $subOutput;
            }
            else {
                $output = $subOutput;
            }
        }
        return $output;
    }

    protected function _renderRawOutput()
    {
        if (!empty($this->_fields)) {
            return implode(' ' . $this->_fieldSeparator . ' ', $this->_fields);
        }

        return "";
    }
    
    /**
     * Escape a value for special query characters such as ':', '(', ')', '*', '?', etc.
     *
     * @param string $value
     * @return string
     */
    public function escape($string)
    {
    	//Replace multiple spaces with a single space
    	$string = preg_replace('!\s+!', ' ', $string);
    	
       	$pattern = '/(\+|-|&&|\|\||!|\(|\)|\{|}|\[|]|\^|"|~|\*|\?|:|\\\)/';
    	$replace = '\\\$1';
    
    	$string = preg_replace($pattern, $replace, $string);
    	
    	$pattern = '#(/)#';
    	$replace = '\\\$1';

// 		return htmlentities(trim(preg_replace($pattern, $replace, $string)), ENT_QUOTES, 'UTF-8');
    	return trim(preg_replace($pattern, $replace, $string));
	}
}