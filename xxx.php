<?php
require_once( 'HTTP/Request.php' );

class xxx{
	
	var $_def = array(
		'url' => 'http://www.google.com/search?hl=en&q=%s+site:adultdvdempire.com',
		'regex' => array(
			'title' => '',
			'year' => '',
			'genre' => '',
			'url' => ''
		)
	);
	
	
	var $_debug = false;
	

	function getUrl( $url, $redir = false ){
		$req =& new HTTP_Request( );
		$req->setMethod(HTTP_REQUEST_METHOD_GET);
		$req->setURL( $url, array( 'timeout' => '30', 'readTimeout' => 30, 'allowRedirects' => $redir ) );
		$request = $req->sendRequest();
		if (PEAR::isError($request)) {
			unset( $req, $request );
			return false;
		} else {
			$body = $req->getResponseBody();
			if ( empty( $body ) )
				$body = $req->getResponseHeader( 'location');
			unset( $req, $request );
			return $body;
		}
	}
	
	
	function findFilm($query, $ignoreCache=false){
		global $api;
		
		$res = $api->db->select( '*', 'xxx_search', array('search' => $query ), __FILE__, __LINE__ );
		
		$nRows = $api->db->rows( $res );
		// check the cache
		if ( $nRows >= 1 )
        {
            $row = $api->db->fetch( $res );
            if ( $row->xxxID != '')
            {
                if ( $this->_debug ) printf( "using cache xxxID: %d\n", $row->xxxID );
                return $row->xxxID;
            }
            else if ( ( mt_rand(1, 100) <= (100 * 0.9) ) &&
			          ( $ignoreCache == false ) )
		    {
                if ( $this->_debug ) printf( "using cache: %d\n", $row->xxxID );
			    return $row->xxxID;
		    }
        }

		
	}
	
	
	
	
	
}

?>