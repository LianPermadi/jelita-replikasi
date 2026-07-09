
<?php
/*
Adapter Web-API MANTRA
Programmed by: Didi Sukyadi
*/

//--------------------- Konektor CURL menggunakan metode HTTP  -----------------------------\\


function callAPI($endpoint,$operation,$accesskey='',$parameter=array(),$xmlformat=true,$callmethod='REST',$agent="MANTRA"){
	$result=false;
	$callmethod=strtoupper($callmethod);
	
	if(empty($endpoint)){ 
		$response=array('status'=>0,'code'=>10001,'message'=>'Empty URL/EndPoint','data'=>'');
		if($xmlformat){
			$result=setArray2XML('response',$response);
		}
		else{
			$result=array('response'=>$response);
		}
		return $result;
	}
	$endpoint.=substr($endpoint,-1)=='/'?'':'/';
	
	if(!empty($accesskey)) $accesskey.=substr($accesskey,-1)=='/'?'':'/';

	if(!empty($parameter)){ 
		$apar=array();
		foreach($parameter as $key=>$value){
			$apar[$key]=urlencode($value);
		}
		$parameter=$apar;
	}
	
	if($callmethod=='RESTFULL' && !empty($parameter)):
		$reqpars=implode('/',$parameter);
		$operation.='/'.$accesskey.$reqpars;
		$parameter=array();	
	endif;

	if($callmethod=='RESTFULLPAR' && !empty($parameter)):
		$reqpars='/';
		foreach($parameter as $key=>$value){
			$reqpars.=$key.'/'.$value;
		}
		$operation.='/'.$accesskey.substr($reqpars,1);
		$parameter=array();	
	endif;
	
	$par='';
	if(!empty($parameter)) $par=http_build_query($parameter);
	
	if($callmethod=='RESTFULL'){
		$uri=empty($operation)?'':$endpoint.$operation;
	}		
	elseif($callmethod=='RESTFULLPAR'){
		$uri=empty($operation)?'':$endpoint.$operation;
	}		
	elseif($callmethod=='GET'){
		$uri=empty($operation)?'':$endpoint.$operation.'/'.$accesskey.'?'.$par;
	}		
	elseif($callmethod=='POST'){
		$uri=empty($operation)?'':$endpoint.$operation.'/'.$accesskey;
	}
	else{
		$uri=empty($operation)?'':$endpoint.$operation.'/'.$accesskey.$par;
	}		
	

	if(empty($uri)){
		$response=array('status'=>0,'code'=>10002,'message'=>'Empty method','data'=>'');
		if($xmlformat){
			$result=setArray2XML('response',$response);
		}
		else{
			$result=array('response'=>$response);
		}
	}
	else{
		$ch = curl_init();
		// URL target koneksi
		curl_setopt($ch, CURLOPT_URL, $uri);            
		if($agent!='') curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		// Output dengan header=true hanya untuk meta document xml/json
		curl_setopt($ch, CURLOPT_HEADER, FALSE);         
		// Mendapatkan tanggapan
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);  
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, FALSE);
		curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);

		// Menggunakan metode HTTP GET
		if(in_array($callmethod,array('GET','REST','RESTFULL','RESTFULLPAR')) ){
			curl_setopt($ch, CURLOPT_HTTPGET, TRUE);         
		}
		
		// Menggunakan metode HTTP POST 
		if($callmethod=='POST'){
			curl_setopt($ch, CURLOPT_POST, TRUE);       
			// Sisipkan parameter    
			curl_setopt($ch, CURLOPT_POSTFIELDS,$par);  
		}

		
		// Buka koneksi dan dapatkan tanggapan
		$result=curl_exec($ch);     
		$errno=curl_errno($ch);
		$errmsg=curl_error($ch);                   


		// Periksa kesalahan
		if ($errno!=0){                            
			$response=array('status'=>0,'code'=>$errno,'message'=>$errmsg,'data'=>'');
			if($xmlformat){
				$result=setArray2XML('response',$response);
			}
			else{
				$result=array('response'=>$response);
			}
		}
		else{
			if(substr($result,0,5)!='<?xml'){
				$response=array('status'=>1,'code'=>200,'message'=>'OK','data'=>$result);
				$result=setArray2XML('response',$response);
			}
			if($xmlformat){
				$result=trim($result);
			}
			else{
				$result=setXML2Array($result);
			}
		}
		
	
		curl_close($ch);
	}

	return $result;
}

function getAPIXML($endpoint,$operation,$accesskey='',$parameter=array(),$callmethod='REST',$agent="MANTRA"){
	$result=false;
	$callmethod=strtoupper($callmethod);
	
	if(empty($endpoint)){ 
		$response=array('status'=>0,'code'=>10001,'message'=>'Empty URL/EndPoint','data'=>'');
		$result=setArray2XML('response',$response);
		return $result;
	}
	$endpoint.=substr($endpoint,-1)=='/'?'':'/';
	
	if(!empty($accesskey)) $accesskey.=substr($accesskey,-1)=='/'?'':'/';

	if(!empty($parameter)){ 
		$apar=array();
		foreach($parameter as $key=>$value){
			$apar[$key]=urlencode($value);
		}
		$parameter=$apar;
	}
	
	if($callmethod=='RESTFULL' && !empty($parameter)):
		$reqpars=implode('/',$parameter);
		$operation.='/'.$accesskey.$reqpars;
		$parameter=array();	
	endif;

	if($callmethod=='RESTFULLPAR' && !empty($parameter)):
		$reqpars='/';
		foreach($parameter as $key=>$value){
			$reqpars.=$key.'/'.$value;
		}
		$operation.='/'.$accesskey.substr($reqpars,1);
		$parameter=array();	
	endif;
	
	$par='';
	if(!empty($parameter)) $par=http_build_query($parameter);
	
	if($callmethod=='RESTFULL'){
		$uri=empty($operation)?'':$endpoint.$operation;
	}		
	elseif($callmethod=='RESTFULLPAR'){
		$uri=empty($operation)?'':$endpoint.$operation;
	}		
	elseif($callmethod=='GET'){
		$uri=empty($operation)?'':$endpoint.$operation.'/'.$accesskey.'?'.$par;
	}		
	elseif($callmethod=='POST'){
		$uri=empty($operation)?'':$endpoint.$operation.'/'.$accesskey;
	}
	else{
		$uri=empty($operation)?'':$endpoint.$operation.'/'.$accesskey.$par;
	}		
	

	if(empty($uri)){
		$response=array('status'=>0,'code'=>10002,'message'=>'Empty method','data'=>'');
		$result=setArray2XML('response',$response);
	}
	else{
		$ch = curl_init();
		// URL target koneksi
		curl_setopt($ch, CURLOPT_URL, $uri);            
		if($agent!='') curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		// Output dengan header=true hanya untuk meta document xml/json
		curl_setopt($ch, CURLOPT_HEADER, FALSE);         
		// Mendapatkan tanggapan
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);  
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, FALSE);
		curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);

		// Menggunakan metode HTTP GET
		if(in_array($callmethod,array('GET','REST','RESTFULL','RESTFULLPAR')) ){
			curl_setopt($ch, CURLOPT_HTTPGET, TRUE);         
		}
		
		// Menggunakan metode HTTP POST 
		if($callmethod=='POST'){
			curl_setopt($ch, CURLOPT_POST, TRUE);       
			// Sisipkan parameter    
			curl_setopt($ch, CURLOPT_POSTFIELDS,$par);  
		}

		
		// Buka koneksi dan dapatkan tanggapan
		$result=curl_exec($ch);     
		$errno=curl_errno($ch);
		$errmsg=curl_error($ch);                   


		// Periksa kesalahan
		if ($errno!=0){                            
			$response=array('status'=>0,'code'=>$errno,'message'=>$errmsg,'data'=>'');
			$result=setArray2XML('response',$response);
		}
		else{
			if(substr($result,0,5)!='<?xml'){
				$response=array('status'=>1,'code'=>200,'message'=>'OK','data'=>$result);
				$result=setArray2XML('response',$response);
			}
			$result=trim($result);
		}
		
	
		curl_close($ch);
	}

	return $result;
}

function getAPIJSON($endpoint,$operation,$accesskey='',$parameter=array(),$callmethod='REST',$agent="MANTRA"){
	$result=false;
	$callmethod=strtoupper($callmethod);
	
	if(empty($endpoint)){ 
		$response=array('status'=>0,'code'=>10001,'message'=>'Empty URL/EndPoint','data'=>'');
		$result=array('response'=>$response);
		return $result;
	}
	$endpoint.=substr($endpoint,-1)=='/'?'':'/';
	
	if(!empty($accesskey)) $accesskey.=substr($accesskey,-1)=='/'?'':'/';

	if(!empty($parameter)){ 
		$apar=array();
		foreach($parameter as $key=>$value){
			$apar[$key]=urlencode($value);
		}
		$parameter=$apar;
	}
	
	if($callmethod=='RESTFULL' && !empty($parameter)):
		$reqpars=implode('/',$parameter);
		$operation.='/'.$accesskey.$reqpars;
		$parameter=array();	
	endif;

	if($callmethod=='RESTFULLPAR' && !empty($parameter)):
		$reqpars='/';
		foreach($parameter as $key=>$value){
			$reqpars.=$key.'/'.$value;
		}
		$operation.='/'.$accesskey.substr($reqpars,1);
		$parameter=array();	
	endif;
	
	$par='';
	if(!empty($parameter)) $par=http_build_query($parameter);
	
	if($callmethod=='RESTFULL'){
		$uri=empty($operation)?'':$endpoint.$operation;
	}		
	elseif($callmethod=='RESTFULLPAR'){
		$uri=empty($operation)?'':$endpoint.$operation;
	}		
	elseif($callmethod=='GET'){
		$uri=empty($operation)?'':$endpoint.$operation.'/'.$accesskey.'?'.$par;
	}		
	elseif($callmethod=='POST'){
		$uri=empty($operation)?'':$endpoint.$operation.'/'.$accesskey;
	}
	else{
		$uri=empty($operation)?'':$endpoint.$operation.'/'.$accesskey.$par;
	}		
	

	if(empty($uri)){
		$response=array('status'=>0,'code'=>10002,'message'=>'Empty method','data'=>'');
		$result=json_encode(array('response'=>$response),JSON_FORCE_OBJECT);
	}
	else{
		$ch = curl_init();
		// URL target koneksi
		curl_setopt($ch, CURLOPT_URL, $uri);            
		if($agent!='') curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		// Output dengan header=true hanya untuk meta document xml/json
		curl_setopt($ch, CURLOPT_HEADER, FALSE);         
		// Mendapatkan tanggapan
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);  
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, FALSE);
		curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);

		// Menggunakan metode HTTP GET
		if(in_array($callmethod,array('GET','REST','RESTFULL','RESTFULLPAR')) ){
			curl_setopt($ch, CURLOPT_HTTPGET, TRUE);         
		}
		
		// Menggunakan metode HTTP POST 
		if($callmethod=='POST'){
			curl_setopt($ch, CURLOPT_POST, TRUE);       
			// Sisipkan parameter    
			curl_setopt($ch, CURLOPT_POSTFIELDS,$par);  
		}

		
		// Buka koneksi dan dapatkan tanggapan
		$result=curl_exec($ch);     
		$errno=curl_errno($ch);
		$errmsg=curl_error($ch);                   


		// Periksa kesalahan
		if ($errno!=0){                            
			$response=array('status'=>0,'code'=>$errno,'message'=>$errmsg,'data'=>'');
			$result=json_encode(array('response'=>$response),JSON_FORCE_OBJECT);
		}
		else{

			if(substr($result,0,5)=='<?xml'){
				$result=setXML2Array($result);
				if(!isset($result['response'])) $result=array('response'=>array('status'=>1,'code'=>200,'message'=>'OK','data'=>$result));
				$result=json_encode($result,JSON_FORCE_OBJECT);
			}
			elseif(substr($result,0,1)!='{'){
				$result=json_decode($result,true);
				if(!isset($result['response'])) $result=array('response'=>array('status'=>1,'code'=>200,'message'=>'OK','data'=>$result));
				$result=json_encode($result,JSON_FORCE_OBJECT);
			}

		}
		
	
		curl_close($ch);
	}

	return $result;
}



function setXML2Array($xmldata){
	return XML2Array::createArray($xmldata);
}

function setArray2XML($nodename,$data){
	$xml=Array2XML::createXML($nodename,$data);
	return $xml->saveXML();
}


/**
 * XML2Array: A class to convert XML to array in PHP
 * It returns the array which can be converted back to XML using the Array2XML script
 * It takes an XML string or a DOMDocument object as an input.
 *
 * Created by: Lalit Patel
 *
 * Usage:
 *       $array = XML2Array::createArray($xml);
 */

class XML2Array {

    private static $xml = null;
	private static $encoding = 'UTF-8';

    /**
     * Initialize the root XML node [optional]
     * @param $version
     * @param $encoding
     * @param $format_output
     */
    public static function init($version = '1.0', $encoding = 'UTF-8', 
    	$format_output = true) {
        self::$xml = new DOMDocument($version, $encoding);
        self::$xml->formatOutput = $format_output;
		self::$encoding = $encoding;
    }

    /**
     * Convert an XML to Array
     * @param string $node_name - name of the root node to be converted
     * @param array $arr - aray to be converterd
     * @return DOMDocument
     */
    public static function &createArray($input_xml) {
        $xml = self::getXMLRoot();
		if(is_string($input_xml)) {
			$parsed = $xml->loadXML($input_xml); // untuk sistem 64bit gunakan: loadXML($input_xml,LIBXML_PARSEHUGE);
			if(!$parsed) {
				throw new Exception('[XML2Array] Error parsing the XML string.');
			}
		} else {
			if(get_class($input_xml) != 'DOMDocument') {
				throw new Exception('[XML2Array] The input XML object should be of type: DOMDocument.');
			}
			$xml = self::$xml = $input_xml;
		}
		$array[$xml->documentElement->tagName] = self::convert($xml->documentElement);
        self::$xml = null;    // clear the xml node in the class for 2nd time use.
        return $array;
    }

    /**
     * Convert an Array to XML
     * @param mixed $node - XML as a string or as an object of DOMDocument
     * @return mixed
     */
    private static function &convert($node) {
		$output = array();

		switch ($node->nodeType) {
			case XML_CDATA_SECTION_NODE:
				$output['@cdata'] = trim($node->textContent);
				break;

			case XML_TEXT_NODE:
				$output = trim($node->textContent);
				break;

			case XML_ELEMENT_NODE:

				// for each child node, call the covert function recursively
				for ($i=0, $m=$node->childNodes->length; $i<$m; $i++) {
					$child = $node->childNodes->item($i);
					$v = self::convert($child);
					if(isset($child->tagName)) {
						$t = $child->tagName;

						// assume more nodes of same kind are coming
						if(!isset($output[$t])) {
							$output[$t] = array();
						}
						$output[$t][] = $v;
					} else {
						//check if it is not an empty text node
						if($v !== '') {
							$output = $v;
						}
					}
				}

				if(is_array($output)) {
					// if only one node of its kind, 
					// assign it directly instead if array($value);
					foreach ($output as $t => $v) {
						if(is_array($v) && count($v)==1) {
							$output[$t] = $v[0];
						}
					}
					if(empty($output)) {
						//for empty nodes
						$output = '';
					}
				}

				// loop through the attributes and collect them
				if($node->attributes->length) {
					$a = array();
					foreach($node->attributes as $attrName => $attrNode) {
						$a[$attrName] = (string) $attrNode->value;
					}
					// if its an leaf node, store the value in @value 
					// instead of directly storing it.
					if(!is_array($output)) {
						$output = array('@value' => $output);
					}
					$output['@attributes'] = $a;
				}
				break;
		}
		return $output;
    }

    /*
     * Get the root XML node, if there isn't one, create it.
     */
    private static function getXMLRoot(){
        if(empty(self::$xml)) {
            self::init();
        }
        return self::$xml;
    }
}

/**
 * Array2XML: A class to convert array in PHP to XML
 * It also takes into account attributes names unlike SimpleXML in PHP
 * It returns the XML in form of DOMDocument class for further manipulation.
 * It throws exception if the tag name or attribute name has illegal chars.
 *
 * Author : Lalit Patel
 *
 * Usage:
 *       $xml = Array2XML::createXML('root_node_name', $php_array);
 *       echo $xml->saveXML();
 */

class Array2XML {

    private static $xml = null;
	private static $encoding = 'UTF-8';

    /**
     * Initialize the root XML node [optional]
     * @param $version
     * @param $encoding
     * @param $format_output
     */
    public static function init($version = '1.0', $encoding = 'UTF-8', $format_output = true) {
        self::$xml = new DomDocument($version, $encoding);
        self::$xml->formatOutput = $format_output;
		self::$encoding = $encoding;
    }

    /**
     * Convert an Array to XML
     * @param string $node_name - name of the root node to be converted
     * @param array $arr - aray to be converterd
     * @return DomDocument
     */
    public static function &createXML($node_name, $arr=array()) {
        $xml = self::getXMLRoot();
        $xml->appendChild(self::convert($node_name, $arr));

        self::$xml = null;    // clear the xml node in the class for 2nd time use.
        return $xml;
    }

    /**
     * Convert an Array to XML
     * @param string $node_name - name of the root node to be converted
     * @param array $arr - aray to be converterd
     * @return DOMNode
     */
    private static function &convert($node_name, $arr=array()) {

        //print_arr($node_name);
        $xml = self::getXMLRoot();
        $node = $xml->createElement($node_name);

        if(is_array($arr)){
            // get the attributes first.;
            if(isset($arr['@attributes'])) {
                foreach($arr['@attributes'] as $key => $value) {
                    if(!self::isValidTagName($key)) {
                    	//file_put_contents(TMPDIR."array2xml.txt",'Illegal character in attribute name. attribute: '.$key.' in node: '.$node_name);
                        throw new Exception('[Array2XML] Illegal character in attribute name. attribute: '.$key.' in node: '.$node_name);
                    }
                    $node->setAttribute($key, self::bool2str($value));
                }
                unset($arr['@attributes']); //remove the key from the array once done.
            }

            // check if it has a value stored in @value, if yes store the value and return
            // else check if its directly stored as string
            if(isset($arr['@value'])) {
                $node->appendChild($xml->createTextNode(self::bool2str($arr['@value'])));
                unset($arr['@value']);    //remove the key from the array once done.
                //return from recursion, as a note with value cannot have child nodes.
                return $node;
            } else if(isset($arr['@cdata'])) {
                $node->appendChild($xml->createCDATASection(self::bool2str($arr['@cdata'])));
                unset($arr['@cdata']);    //remove the key from the array once done.
                //return from recursion, as a note with cdata cannot have child nodes.
                return $node;
            }
        }

        //create subnodes using recursion
        if(is_array($arr)){
            // recurse to get the node for that key
            foreach($arr as $key=>$value){
                if(!self::isValidTagName($key)) {
                    //file_put_contents(TMPDIR."array2xml.txt",'Illegal character in tag name: '.$key.' in node: '.$node_name);
                    throw new Exception('[Array2XML] Illegal character in tag name. tag: '.$key.' in node: '.$node_name);
                }
                if(is_array($value) && is_numeric(key($value))) {
                    // MORE THAN ONE NODE OF ITS KIND;
                    // if the new array is numeric index, means it is array of nodes of the same kind
                    // it should follow the parent key name
                    foreach($value as $k=>$v){
                        $node->appendChild(self::convert($key, $v));
                    }
                } else {
                    // ONLY ONE NODE OF ITS KIND
                    $node->appendChild(self::convert($key, $value));
                }
                unset($arr[$key]); //remove the key from the array once done.
            }
        }

        // after we are done with all the keys in the array (if it is one)
        // we check if it has any text value, if yes, append it.
        if(!is_array($arr)) {
            $node->appendChild($xml->createTextNode(self::bool2str($arr)));
        }

        return $node;
    }

    /*
     * Get the root XML node, if there isn't one, create it.
     */
    private static function getXMLRoot(){
        if(empty(self::$xml)) {
            self::init();
        }
        return self::$xml;
    }

    /*
     * Get string representation of boolean value
     */
    private static function bool2str($v){
        //convert boolean to text value.
        $v = $v === true ? 'true' : $v;
        $v = $v === false ? 'false' : $v;
        return $v;
    }

    /*
     * Check if the tag name or attribute name contains illegal characters
     * Ref: http://www.w3.org/TR/xml/#sec-common-syn
     */
    private static function isValidTagName($tag){
        $pattern = '/^[a-z_]+[a-z0-9\:\-\.\_]*[^:]*$/i';
        return preg_match($pattern, $tag, $matches) && $matches[0] == $tag;
    }
}

/**
 * This file is part of the array_column library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Ben Ramsey (http://benramsey.com)
 * @license http://opensource.org/licenses/MIT MIT
 */

if (!function_exists('array_column')) {
    /**
     * Returns the values from a single column of the input array, identified by
     * the $columnKey.
     *
     * Optionally, you may provide an $indexKey to index the values in the returned
     * array by the values from the $indexKey column in the input array.
     *
     * @param array $input A multi-dimensional array (record set) from which to pull
     *                     a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the
     *                         integer key of the column you wish to retrieve, or it
     *                         may be the string key name for an associative array.
     * @param mixed $indexKey (Optional.) The column to use as the index/keys for
     *                        the returned array. This value may be the integer key
     *                        of the column, or it may be the string key name.
     * @return array
     */
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();

        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }

        if (!is_array($params[0])) {
            trigger_error(
                'array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given',
                E_USER_WARNING
            );
            return null;
        }

        if (!is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }

        if (isset($params[2])
            && !is_int($params[2])
            && !is_float($params[2])
            && !is_string($params[2])
            && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }

        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;

        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }

        $resultArray = array();

        foreach ($paramsInput as $row) {
            $key = $value = null;
            $keySet = $valueSet = false;

            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }

            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }

            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }

        }

        return $resultArray;
    }

}

function count_dimension($Array, $count = 0) {
   if(is_array($Array)) {
      return count_dimension(current($Array), ++$count);
   } else {
      return $count;
   }
}


function nav_table($navid,$maxpage)
{	
	if($maxpage>1){
	?>
	<div class="page-nav" style="text-align:right;margin-bottom:8px;font-family:sans-serif;font-size:14px;">
	<span>Data: <?php echo $maxpage;?> Halaman.&nbsp;</span>
	<button type="button" style="padding:4px;width:24px;border:1px solid silver;background:#fafafa;color:#333;cursor:pointer;outline:none;" onclick="goPageTable('<?php echo $navid;?>','page','<','<?php echo $maxpage;?>');">&laquo;</button>
	<button type="button" style="padding:4px;width:24px;border:1px solid silver;background:#fafafa;color:#333;cursor:pointer;outline:none;" onclick="goPageTable('<?php echo $navid;?>','page','-','<?php echo $maxpage;?>');">&lsaquo;</button>
	<span id="nav-pagenum<?php echo $navid;?>" >
		<script runat="server" type="text/javascript" autoload="true">	
			goPageTable('<?php echo $navid;?>','page','<','<?php echo $maxpage;?>');			
		</script>
	</span>
	<button type="button" style="padding:4px;width:24px;border:1px solid silver;background:#fafafa;color:#333;cursor:pointer;outline:none;" onclick="goPageTable('<?php echo $navid;?>','page','+','<?php echo $maxpage;?>');">&rsaquo;</button>
	<button type="button" style="padding:4px;width:24px;border:1px solid silver;background:#fafafa;color:#333;cursor:pointer;outline:none;" onclick="goPageTable('<?php echo $navid;?>','page','>','<?php echo $maxpage;?>');">&raquo;</button>
	</div>
	<?php
	}
}

function view_table($data,$key,$rowsperpage=5){
	if(isset($data) and is_array($data)){
		$data=array_column($data,$key);
		if(is_array($data) and (count($data)>0)){
			$data=current($data);
			if(count_dimension($data)<2) $data=array($data);
			$header=current($data);
			$maxdata=count($data);
			$maxpage=$maxdata>$rowsperpage?ceil($maxdata/$rowsperpage):1;
			reset($data);
			nav_table(1,$maxpage);
			for($page=1;$page<=$maxpage;$page++){
				$datapage=array();
				for($row=0;$row<$rowsperpage;$row++)
				if(current($data)){
					$datapage[]=current($data);
					$x=next($data);
				}
				$display=$page==1?"display:block;":"display:none;";
				echo '<div id="page'.$page.'" class="page" style="'.$display.'overflow-x:scroll;font-family:sans-serif;font-size:14px;">';
				echo '<table style="table-layout:auto;width:100%;border-collapse:separate;border-spacing:1px;border:1px solid silver;">';
				echo '<tr>';
				foreach($header as $key=>$field) echo "<th style='padding:4px;background-color:#008bca;color:#fff;'>".strtoupper($key)."</th>";
				echo '</tr>';
				foreach($datapage as $records){
					echo '<tr>'; 
					foreach($records as $field){
						echo "<td style='padding:4px;background-color:#eaeaea;color:#000;'>";
						echo is_array($field)?var_export($field):$field;
						echo "</td>";
					}
					echo '</tr>';		
				}
				echo '</table>';
				echo '</div>';
			}
			echo '<br/>';
		}
	}
}


?>

<script runat="server" type="text/javascript">

function eraseChild(el)
{
	if(el) while(el.hasChildNodes()) el.removeChild(el.firstChild);
}

function createPageNumber(navID,className,pageNum,maxPage,interval)
{
	if(interval<1) interval=1;
	skip=pageNum>interval?pageNum-interval:0;
	step=maxPage<interval?maxPage:interval;
	idxPage=new Array();
	for(i=1;i<=step;i++) idxPage[i-1]=skip+i;

	el = document.getElementById('nav-pagenum'+navID);
	if(el)
	{
		eraseChild(el);
		for(i=0;i<idxPage.length;i++) 
		{
			obj=document.createElement('button');
			obj.style.margin='0 2px';
			obj.style.padding='4px';
			obj.style.minWidth='32px';
			obj.style.border='1px solid silver';
			if(pageNum==idxPage[i]){
				obj.style.backgroundColor='#008bca';
				obj.style.color='#fff';
			}
			else{
				obj.style.backgroundColor='#fafafa';
				obj.style.color='#333';
			}
			obj.style.cursor='pointer';
			obj.style.outline='none';
			obj.appendChild(document.createTextNode(idxPage[i]));
			obj.onclick=function()
			{
				goPageTable(navID,className,this.firstChild.nodeValue,maxPage);
			}
			el.appendChild(obj);	
		}
	}
}

function goPageTable(navID,className,sign,maxPage)
{
	currentPage=0;
	for(i=1;i<=maxPage;i++)
	{
		el = document.getElementById(className+i);
		if(el){
			if(el.style.display=='block') currentPage=i;
			el.style.display='none';
		}
	}

	switch(sign)
	{
		case '<':pageNum=1;break;
		case '-':pageNum=currentPage-1<1?1:currentPage-1;break;
		case '+':pageNum=currentPage+1>maxPage?maxPage:currentPage+1;break;
		case '>':pageNum=maxPage;break;
		default :pageNum=parseInt(sign);break;
	}
	createPageNumber(navID,className,pageNum,maxPage,5);

	el=document.getElementById(className+pageNum);
	if(el) el.style.display='block';
}
</script>



