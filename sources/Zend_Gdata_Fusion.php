<?php
// $Id:$
/**
 * @file
 * Integration with Google Fusion Tables. API class.
 */
require_once 'Zend/Gdata.php'; 

/**
 * Google fusion client class
 *
 * This is an API wrapper for querying fusion tables
 *
 */
class Zend_Gdata_Fusion extends Zend_Gdata {
	const AUTH_SERVICE_NAME = 'fusiontables';
	
	protected $_defaultPostUri = 'http://tables.googlelabs.com/api/query';
	protected $tableList;
	
	/**
	 * Class constructor
	 */
	public function __construct($client = NULL, $applicationId = 'MyCompany-MyApp-1.0') {
		$this->registerPackage('Zend_Gdata_Fusion');
//		$this->registerPackage('Zend_Gdata_Gbase_Extension');

		parent::__construct($client, $applicationId);
		$this->_httpClient->setParameterPost('service', self::AUTH_SERVICE_NAME);
	}

	/**
	 * Create table
	 *
	 * @param $name string
	 *	 Table name. Use only alphanumeric characters or underscores.
	 * @param $schema array()
	 *	 Array of multiple field => type elements.
	 *	 Example: array('name' => 'STRING', age => 'NUMBER');
	 *	 Field types are: 'NUMBER', 'STRING', 'LOCATION', 'DATETIME'
	 *
	 * @return int
	 *	 Table id if successful
	 */
	public function createTable($name, $schema) {
		$fields = array();
		foreach ($schema as $field_name => $field_type) {
			$fields[] = $field_name . ': ' . $field_type;
		}
		$sql = 'CREATE TABLE ' . $name . ' (' . implode(', ', $fields) . ')';
		$response = $this->_query($sql);
		if ($response) {
			$this->tableList = NULL;
			return $response->get_value();
		}
		else {
			return FALSE;
		}
	}

	/**
	 * Drop (delete) a table.
	 *
	 * @param $table_id
	 *	 Fusion Table id as returned by createTable().
	 *
	 * @return response code as scalar value if successful, FALSE otherwise.
	 */
	public function dropTable($table_id) {
		$response = $this->_query('DROP TABLE '. $table_id);
		if ($response) {
			return $response->get_value();
		}
		else {
			return FALSE;
		}
	}

	/**
	 * Insert a single row into the table
	 *
	 * @param $table_id int
	 *	 Table id
	 * @param $data object or array
	 *	 Object or structured array containing data to store in single row
	 *
	 * @return int
	 *	 Row id of the new created. FALSE if failed
	 *	 In any case will be something that evaluates to TRUE the operation is successful
	 */
	public function insertRow($table_id, $data) {
		$values = (array)$data;
		$sql = $this->sqlInsert($table_id, array_keys($values), $values);
		$response = $this->_query($sql);
		if ($response) {
			return (int)$response->get_value();
		}
		else {
			return FALSE;
		}
	}
	

	
	

	
	/**
	 * Updates a single row of the table
	 *
	 * @param $table_id int
	 *	 Table id
	 * @param $data object or array
	 *	 Object or structured array containing data to store in single row
	 * @param  $rowId  String  - id of row to be updated
	 * 
	 * @return boolean
	 *	 TRUE if ok,  FALSE if failed
	 *	 
	 */
	public function updateRow($table_id, $data, $rowId) {
		$sql = $this->sqlUpdate($table_id, $data, $rowId);
//		die($sql);
		$response = $this->_query($sql);
		if ($response) {
			return strtolower(trim($response->get_csv())) == 'ok';
		}else{
			return FALSE;
		}
	}

	/**
	 * Insert bulk data into the table
	 *
	 * Multiple insert statements can be grouped into a single request so this should speed up bulk operations
	 *
	 * @param $table_id int
	 *	 Table id
	 * @param $fields array
	 *	 Array of (ordered) field names to insert into
	 * @param $data array
	 *	 Array of arrays with (ordered) values to insert into the fields
	 *
	 * @return array
	 *	 Array of ids for newly created rows, if successful.
	 */
	public function insertData($table_id, $fields, $data) {
		$statements = array();
		foreach ($data as $row) {
			$statements[] = $this->sqlInsert($table_id, $fields, $row);
		}
		$sql = implode('; ', $statements);
	$response = $this->_query($sql);
		if ($response) {
			return $response->get_column();
		}
		else {
			return FALSE;
		}
	}

	/**
	 * Get tables under user account
	 *
	 * Note: SHOW TABLES will only display tables for which the authenticated user is listed as
	 * an owner, collaborator, contributor, or viewer on the table.
	 * See http://code.google.com/apis/fusiontables/docs/developers_guide.html#Exploring
	 *
	 * The table list is an array with table_id => table_name
	 *
	 * @param $refresh
	 *	 Refresh table list from server
	 */
	public function getTables($refresh = FALSE) {
		if (!isset($this->tableList) || $refresh) {
			$response = $this->_query("SHOW TABLES");
			if ($response) {
				$this->tableList = array_combine($response->get_column(0), $response->get_column(1));
			}
			else {
				// The request failed so we just set an empty array for not to retry again
				$this->tableList = array();
			}
		}
		return $this->tableList;
	}

	/**
	 * Set user table list, in case we know about the tables we are using beforehand
	 *
	 * This will skip querying for tables and will also allow using tables not owned by the user
	 *
	 * @param $tables
	 *	 Array with table_id => table_name
	 */
	public function setTables($tables) {
		$this->tableList = $tables;
	}

	/**
	 * Get Id for a table name
	 *
	 * @param $name
	 *	 Table name
	 * @return int
	 *	 Table id or FALSE if table not found
	 */
	public function getTableId($name) {
		return array_search($name, $this->getTables());
	}

	/**
	 * Build simple insert statement
	 */
	public static function sqlInsert($table_id, $fields, $values) {
		return 'INSERT INTO ' . $table_id . '(' . implode(', ', $fields) . ') VALUES (' . implode(', ', array_map(array('Zend_Gdata_Fusion_Utils', 'escape_value'), $values)) . ');';
	}
	
	
	
	protected static function preUpdate($data){
		$ret = array();
		foreach($data as $k => $v){
			$ret[] = $k .' = '. Zend_Gdata_Fusion_Utils::escape_value($v);
		}
		return $ret;
	}
	
	/**
	 * Build simple update statement
	 */
	public static function sqlUpdate($table_id, $data, $rowId) {
		$data = self::preUpdate($data);
		$rowId =  Zend_Gdata_Fusion_Utils::escape_value($rowId);
		return 'UPDATE ' . $table_id . ' SET ' . implode(', ', $data) . ' WHERE ROWID =  \'' . $rowId . '\';';
	}

	/**
	 * Run SQL query against Google Fusion tables
	 *
	 * The SQL has a special syntax defined here
	 * http://code.google.com/apis/fusiontables/docs/developers_reference.html
	 *
	 * @see db_query()
	 *
	 * @param $sql
	 *	 SQL statement with placeholders for values
	 * @param $args
	 *	 Array of arguments to be replaced in the placeholders.
	 *	 Just like db_query()
	 *
	 * @return Zend_Gdata_Fusion_Response
	 *	 Response object if successful. FALSE otherwise.
	 */
	public function query($query) {
		$args = func_get_args();
		array_shift($args);

		// We do table/key replacement here
		$query = $this->replace_tables($query);
		if (isset($args[0]) and is_array($args[0])) { // 'All arguments in one array' syntax
			$args = $args[0];
		}
		if ($args) {
			Zend_Gdata_Fusion_Utils::query_callback($args, TRUE);
			$query = preg_replace_callback(DB_QUERY_REGEXP, array('Zend_Gdata_Fusion_Utils', 'query_callback'), $query);
		}
		return $this->_query($query);
	}

	/**
	 * Resolve table names to table ids.
	 *
	 * Replaces table names enclosed in {} with their table ids. This is similar to Drupal table prefixing.
	 */
	protected function replace_tables($query) {
		$tables = array();
		foreach ($this->getTables() as $id => $name) {
			$tables['{' . $name . '}'] = $id;
		}
		return strtr($query, $tables);
	}

	/**
	 * Raw query
	 *
	 * @param $sql
	 *	 SQL query
	 *
	 *
	 *
	 * @return Zend_Gdata_Fusion_Response
	 *	 Response object if successful. FALSE otherwise.
	 */
	protected function _query($sql) {
		$response = $this->post(array('sql' => $sql));
		if ($response) {
			$result = new Zend_Gdata_Fusion_Response($response);
			$result->query = $sql;
			return $result;
		}
		else {
			// @todo Exception object
			return FALSE;
		}
	}
	
	
	/**
	 * Post parameters
	 */
	public function post($params, $remainingRedirects = null, $url = null) {
        $method = 'POST';
        if(!$url) $url = $this->_defaultPostUri;
        if($remainingRedirects === null)
        	$remainingRedirects = self::getMaxRedirects();
        $headers = array();
		$body = $params;
        $contentType = 'application/x-www-form-urlencoded';
		if ($this->_httpClient instanceof Zend_Gdata_HttpClient) {
        	$filterResult = $this->_httpClient->filterHttpRequest($method, $url, $headers, $body, $contentType);
            $method = $filterResult['method'];
            $url = $filterResult['url'];
            $body = $filterResult['body'];
            $headers = $filterResult['headers'];
            $contentType = $filterResult['contentType'];
            return $this->_httpClient->filterHttpResponse($this->performHttpRequest($method, $url, $headers, $body, $contentType, $remainingRedirects));
        } else {
        	return $this->performHttpRequest($method, $url, $headers, $body, $contentType, $remainingRedirects);
        }
	}
	
    public function performHttpRequest($method, $url, $headers = null,
        $body = null, $contentType = null, $remainingRedirects = null)
    {
        require_once 'Zend/Http/Client/Exception.php';
        if ($remainingRedirects === null) {
            $remainingRedirects = self::getMaxRedirects();
        }
        if ($headers === null) {
            $headers = array();
        }
        // Append a Gdata version header if protocol v2 or higher is in use.
        // (Protocol v1 does not use this header.)
        $major = $this->getMajorProtocolVersion();
        $minor = $this->getMinorProtocolVersion();
        if ($major >= 2) {
            $headers['GData-Version'] = $major +
                    (($minor === null) ? '.' + $minor : '');
        }

        // check the overridden method
        if (($method == 'POST' || $method == 'PUT') && $body === null &&
            $headers['x-http-method-override'] != 'DELETE') {
                require_once 'Zend/Gdata/App/InvalidArgumentException.php';
                throw new Zend_Gdata_App_InvalidArgumentException(
                        'You must specify the data to post as either a ' .
                        'string or a child of Zend_Gdata_App_Entry');
        }
        if ($url === null) {
            require_once 'Zend/Gdata/App/InvalidArgumentException.php';
            throw new Zend_Gdata_App_InvalidArgumentException(
                'You must specify an URI to which to post.');
        }
        $headers['Content-Type'] = $contentType;
        if (Zend_Gdata_App::getGzipEnabled()) {
            // some services require the word 'gzip' to be in the user-agent
            // header in addition to the accept-encoding header
            if (strpos($this->_httpClient->getHeader('User-Agent'),
                'gzip') === false) {
                $headers['User-Agent'] =
                    $this->_httpClient->getHeader('User-Agent') . ' (gzip)';
            }
            $headers['Accept-encoding'] = 'gzip, deflate';
        } else {
            $headers['Accept-encoding'] = 'identity';
        }

        // Make sure the HTTP client object is 'clean' before making a request
        // In addition to standard headers to reset via resetParameters(),
        // also reset the Slug and If-Match headers
        $this->_httpClient->resetParameters();
        $this->_httpClient->setHeaders(array('Slug', 'If-Match'));

        // Set the params for the new request to be performed
        $this->_httpClient->setHeaders($headers);
        require_once 'Zend/Uri/Http.php';
        $uri = Zend_Uri_Http::fromString($url);
        preg_match("/^(.*?)(\?.*)?$/", $url, $matches);
        $this->_httpClient->setUri($matches[1]);
        $queryArray = $uri->getQueryAsArray();
        foreach ($queryArray as $name => $value) {
            $this->_httpClient->setParameterGet($name, $value);
        }


        $this->_httpClient->setConfig(array('maxredirects' => 0));

        // Set the proper adapter if we are handling a streaming upload
        $usingMimeStream = false;
        $oldHttpAdapter = null;

        if ($body instanceof Zend_Gdata_MediaMimeStream) {
            $usingMimeStream = true;
            $this->_httpClient->setRawDataStream($body, $contentType);
            $oldHttpAdapter = $this->_httpClient->getAdapter();

            if ($oldHttpAdapter instanceof Zend_Http_Client_Adapter_Proxy) {
                require_once 'Zend/Gdata/HttpAdapterStreamingProxy.php';
                $newAdapter = new Zend_Gdata_HttpAdapterStreamingProxy();
            } else {
                require_once 'Zend/Gdata/HttpAdapterStreamingSocket.php';
                $newAdapter = new Zend_Gdata_HttpAdapterStreamingSocket();
            }
            $this->_httpClient->setAdapter($newAdapter);
        } elseif(is_array($body)) {
		    foreach ($body as $name => $value) {
		      $this->_httpClient->setParameterPost($name, $value);
		    }
        }else {
            $this->_httpClient->setRawData($body, $contentType);
        }

        try {
            $response = $this->_httpClient->request($method);
            // reset adapter
            if ($usingMimeStream) {
                $this->_httpClient->setAdapter($oldHttpAdapter);
            }
        } catch (Zend_Http_Client_Exception $e) {
            // reset adapter
            if ($usingMimeStream) {
                $this->_httpClient->setAdapter($oldHttpAdapter);
            }
            require_once 'Zend/Gdata/App/HttpException.php';
            throw new Zend_Gdata_App_HttpException($e->getMessage(), $e);
        }
        if ($response->isRedirect() && $response->getStatus() != '304') {
            if ($remainingRedirects > 0) {
                $newUrl = $response->getHeader('Location');
                $response = $this->performHttpRequest(
                    $method, $newUrl, $headers, $body,
                    $contentType, $remainingRedirects);
            } else {
                require_once 'Zend/Gdata/App/HttpException.php';
                throw new Zend_Gdata_App_HttpException(
                        'Number of redirects exceeds maximum', null, $response);
            }
        }
        if (!$response->isSuccessful()) {
            require_once 'Zend/Gdata/App/HttpException.php';
            $exceptionMessage = 'Expected response code 200, got ' .
                $response->getStatus();
            if (self::getVerboseExceptionMessages()) {
                $exceptionMessage .= "\n" . $response->getBody();
            }
            $exception = new Zend_Gdata_App_HttpException($exceptionMessage);
            $exception->setResponse($response);
            throw $exception;
        }
        return $response;
    }	
}

/**
 * Response to gdata query
 * @author jose
 *
 */
class Zend_Gdata_Fusion_Response {
	// Query thrown, stored for further reference
	public $query;
	public $args;
	// Reply data
	protected $response;
	protected $csv;
	protected $data;
	protected $header;
	protected $rows;

	/**
	 * Build from CSV reply
	 *
	 * @param $response Zend_Http_Response
	 */
	public function __construct($response) {
		$this->response = $response;
		$this->csv = $response->getBody();
	}

	/**
	 * Get raw CSV data
	 */
	public function get_csv() {
		return $this->csv;
	}

	/**
	 * Get raw array data
	 */
	public function get_array() {
		if (!isset($this->data)) {
			$this->data = !empty($this->csv) ? $this->csv2array($this->csv) : array();
			$this->header = $this->data ? current($this->data) : array();
		}
		return $this->data;
	}

	/**
	 * Get rows keyed by header.
	 */
	public function get_keyed_rows() {
		if (!isset($this->keyed_rows)) {
			$this->get_array();
			if (empty($this->header) || empty($this->data)) {
				$this->keyed_rows = array();
			}
			else {
				foreach ($this->data as $i => $row) {
					if ($i == 0) {
						continue;
					}
					foreach ($row as $k => $v) {
						$this->keyed_rows[$i][$this->header[$k]] = $v;
					}
				}
			}
		}
		return $this->keyed_rows;
	}

	/**
	 * Get header (first row of data array)
	 */
	public function get_header() {
		if (!isset($this->header)) {
			$this->get_array();
		}
		return $this->header;
	}

	/**
	 * Get single row of data as array (skipping headers)
	 */
	public function get_rows() {
		if (!isset($this->rows)) {
			$this->rows = $this->get_array();
			// Take out the header
			array_shift($this->rows);
		}
		else {
			reset($this->rows);
		}
		return $this->rows;
	}

	/**
	 * Get next data row
	 */
	public function get_row() {
		if (!isset($this->rows)) {
			$this->get_rows();
		}
		$value = current($this->rows);
		next($this->rows);
		return $value;
	}

	/**
	 * Get row as scalar value
	 */
	public function get_value() {
		$row = $this->get_row();
		if ($row) {
			return current($row);
		}
	}

	/**
	 * Get first column as array of values
	 *
	 * @param $index
	 *	 Field to return
	 */
	public function get_column($index = 0) {
		$values = array();
		foreach ($this->get_rows() as $row) {
			$values[] = $row[$index];
	 }
	 return $values;
	}

	/**
	 * Format as html table
	 */
//	public function format_table() {
//		$header = array_map('check_plain', $this->get_header());
//		$rows = array_map(array('Zend_Gdata_Fusion_Utils', 'check_array'), $this->get_rows());
//		return theme('table', $header , $rows);
//	}

	/**
	 * Format raw CSV as HTML output
	 */
	public function format_csv() {
		return '<pre>' . $this->get_csv() . '</pre>';
	}

	/**
	 * Convert csv multiline result into array of arrays
	 */
	public static function csv2array($text) {
		// Interesting, there's a function in PHP 5.3...
		// return str_getcsv($csv);
		// To work with older versions (PHP 5.2) we use this 'string-as-file trick'
		$result = array();
		$fh = fopen('php://memory', 'rw');
		fwrite($fh, $text);
		rewind($fh);
		while ($line = fgetcsv($fh)) {
			$result[] = $line;
		}
		fclose($fh);
		return $result;
	}
}



class Zend_Gdata_Fusion_Utils{
	/**
	 * Check values for insert statements
	 * 
	 * @todo Proper filtering and escaping
	 */
//	public static function _gdata_fusion_escape_value($value) {
	public static function escape_value($value) {
		if (is_numeric($value)) {
			return (string)floatval($value);
		}
		elseif (is_string($value)) {
			return self::escape_string($value);
		}
		else {
			// Last resort, convert to string and escape
			return self::escape_string((string)$value);
		}
	}

	/**
	 * Escape string value
	 */
//	function _gdata_fusion_escape_string($string, $wrapper = "'", $wrap = TRUE) {
	public static function escape_string($string, $wrapper = "'", $wrap = TRUE) {
		$string = str_replace($wrapper, "\\" . $wrapper, trim($string));
		return $wrap ? $wrapper . $string . $wrapper : $string;
	}

	/**
	 * Check output for a full array
	 */
///	function _gdata_fusion_check_array($array) {
	public static function check_array($array) {
		return array_map('check_plain', $array); 
	}
	
	/**
	 * Callback function to properly escape arguments in queries
	 * @see _db_query_callback()
	 */
//	function _gdata_fusion_query_callback($match, $init = FALSE) {
	public static function query_callback($match, $init = FALSE) {
		static $args = NULL;
		if ($init) {
			$args = $match;
			return;
		}
	
		switch ($match[1]) {
			case '%d': // We must use type casting to int to convert FALSE/NULL/(TRUE?)
				$value = array_shift($args);
				// Do we need special bigint handling?
				if ($value > PHP_INT_MAX) {
					$precision = ini_get('precision');
					@ini_set('precision', 16);
					$value = sprintf('%.0f', $value);
					@ini_set('precision', $precision);
				}
				else {
					$value = (int) $value;
				}
				// We don't need db_escape_string as numbers are db-safe.
				return $value;
			case '%s':
				// Escape string without aditional wrapping
				return self::escape_string(array_shift($args), "'", FALSE);
			case '%n':
				// Numeric values have arbitrary precision, so can't be treated as float.
				// is_numeric() allows hex values (0xFF), but they are not valid.
				$value = trim(array_shift($args));
				return is_numeric($value) && !preg_match('/x/i', $value) ? $value : '0';
			case '%%':
				return '%';
			case '%f':
				return (float) array_shift($args);
		}
	}
}