<?php
/**
 * Switch from IMDb to IMDb API.
 */

require_once( 'HTTP/Request.php' );
 
class imdb {
	
	
	var $_def = array(
		'url' => array(
			'search' => 'http://www.imdbapi.com/?t=%s',
			'id' => 'http://www.imdbapi.com/?i=%s',
			'imdb' => 'http://www.imdb.com/title/%s/',
		),
		'regex' => array(
			'id' => array(
				'/http:\/\/(?:www\.|.*)?imdb.com(?:.*?)\/title\/tt(\d+)\//i',
				'/http:\/\/(?:www\.|.*)?imdb.com(?:.*?)\/Title\?(\d+)/i'

				),
			'film' => array(
				'title' => '/<meta property=\"og:title\" content=\"(.*?)(\(\d+\))\"\/>/i',
				'genre' => '/href="\/genre\/(.*?)"/iS',
				'country' => '/href="\/country\/(.*?)"/iS',
				'akaInt' => '/<td>(.*)<\/td>\s*<td>(.*)International/i',	//Priority goes to international title
				'akaUS' => '/<td>(.*)<\/td>\s*<td>(.*)USA/i',				//then us
				'akaUK' => '/<td>(.*)<\/td>\s*<td>(.*)UK/i',				//then uk
				'original' => '/<td>(.*)<\/td>\s*<td>(.*) \(original title\)<\/td>/i',
				'imdb_display' => '/<title>(.*) \(\d+\) - Release dates<\/title>/i'
			),
		),
	);
	
	var $debug = false;
	
	
	/**
	 * Get URL
	 *
	 * @param string $url - url to get
	 * @return contents of the page
     * @access public
	 */
	function getUrl( $url, $redir = false )
	{
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


	/**
	 * look for a film
	 *
	 * @param string $query - film search query
	 * @return string - imdb ID
	 * @access public
	 */
	function findFilm( $query, $ignoreCache = false )
	{
		global $api;
		
		$res = $api->db->select( '*', 'imdb_search', array('search' => $query ), __FILE__, __LINE__ );
		
		$nRows = $api->db->rows( $res );
		
		// check the cache
		if ( $nRows >= 1 )
        {
            $row = $api->db->fetch( $res );
            if ( $row->fimdbID != '')
            {
                if ( $this->_debug ) printf( "using cache fimdbID: %d\n", $row->fimdbID );
                return $row->fimdbID;
            }
            else if ( ( mt_rand(1, 100) <= (100 * 0.9) ) &&
			          ( $ignoreCache == false ) )
		    {
                if ( $this->_debug ) printf( "using cache: %d\n", $row->fimdbID );
			    return $row->imdbID;
		    }
        }
		
		// find film
		$url = sprintf( $this->_def['url']['search'], urlencode(strtolower($query)) );
        if ( $this->_debug ) printf( "url: %s \n", $url );
		if ( ( $page = $this->getUrl( $url ) ) !== false )
		{
			$film = json_decode($page);
			if ( $film->Response == true)
			{

				if ( $nRows >= 1 )
					$api->db->update( 'imdb_search', array( 'imdbID' => $film->ID ), array( 'search' => $query ), __FILE__, __LINE__ );
				else
					$api->db->insert( 'imdb_search', array( 'imdbID' => $film->ID, 'search' => $query ), __FILE__, __LINE__ );
                       
                if ( $this->_debug ) printf( 'found film id: %d', $film->ID );  
					return $film->ID;
				}
			
			return false;
		}
		else
		{
			return false;
		}
	}

	function getSFilm( $query, $ignoreCache = false )
	{
		if ( ( $imdbID = $this->findFilm( $query, $ignoreCache ) ) !== false )
		{												
			return $this->getFilm( $imdbID, $ignoreCache );
		}
		else
		{
			return false;
		}
	}


	/**
	 * Get Film
	 *
	 * @param string $tvin - tvrage showID
	 * @return array - Show information
	 * @access public
	 */
	function getFilm( $imdbID, $ignoreCache = false )
	{
		global $api;
	
		$res = $api->db->select( '*', 'imdb_film', array( 'imdbID' => $imdbID ), __FILE__, __LINE__ );
		
		$nRows = $api->db->rows( $res );
		
		if ( $nRows >= 1 )
			$row = $api->db->fetch( $res );
	
		// check cache
		if ( ( $nRows >= 1 ) &&
		     ( mt_rand(1, 100) <= (100 * 0.9) ) &&
			 ( $ignoreCache == false ) )
		{
            if ( $this->_debug ) printf( 'getFilm: usingCache' );  
			return $row;
		}
			
		$url = sprintf( $this->_def['url']['id'], urlencode( $imdbID ) );
        if ( $this->_debug ) printf( "url: %s \n", $url );  
		if ( ( $page = $this->getUrl( $url, true ) ) !== false )
		{
			$film = json_decode($page);
			$film = array(
				'imdbID' => $imdbID,
				'title' => $api->stringDecode( $film->Title ),
				'year' => $api->stringDecode( $film->Year),
				'genre' => $api->stringDecode( $film->Genre),
				'url' => sprintf( $this->_def['url']['imdb'], $imdbID ) );
			

			if ( empty( $film['title'] ) )
			{
				if ( $nRows >= 1 )
					return $row;
				return false;
			}

			$film['title'] = str_replace( '"','',$film['title'] );
			if ( $nRows >= 1 )
				$api->db->update( 'imdb_film', $film, array( 'filmID' => $row->filmID ), __FILE__, __LINE__ );
			else
				$api->db->insert( 'imdb_film', $film, __FILE__, __LINE__ );
						
			return (object)$film;
		}
		else
		{
			return false;
		}
	}
}
?>