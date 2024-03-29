<?php
/*
 * NZBirc v1
 * Copyright (c) 2006 Harry Bragg
 * tiberious.org
 * Module: imdb
 **************************************************
 *
 * Full GPL License: <http://www.gnu.org/licenses/gpl.txt>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA
 */

require_once( 'HTTP/Request.php' );

class imdb
{

	/**
	 * Lists the definitions for tvrage website
	 *
	 * @var array of regular expressions
	 * @access public
	 */
	var $_def = array(
		'url' => array(
			'search' => 'http://www.google.co.uk/search?hl=en&q=%s+site:imdb.com&btnI=I\'m+Feeling+Lucky',
			'id' => 'http://www.imdb.com/title/%s/',
			'nameid' => 'http://www.imdb.com/name/%s/',
			'aka' => 'http://www.imdb.com/title/%s/releaseinfo#akas'
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
		'command' => array(
			'id' => '/^\s*(tt\d+)\s*$/i'
		)
	);
    
    var $_debug = false;

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

			foreach( $this->_def['regex']['id'] as $regex )
			{
				if ( preg_match( $regex, $page, $filmID) )
				{
					$filmID[1] = 'tt'.$filmID[1];
					if ( $nRows >= 1 )
						$api->db->update( 'imdb_search', array( 'imdbID' => $filmID[1] ), array( 'search' => $query ), __FILE__, __LINE__ );
					else
						$api->db->insert( 'imdb_search', array( 'imdbID' => $filmID[1], 'search' => $query ), __FILE__, __LINE__ );
                        
                    if ( $this->_debug ) printf( 'found film id: %d', $filmID[1] );  
					return $filmID[1];
				}
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
			
			preg_match( $this->_def['regex']['film']['title'], $page, $title );
						
			preg_match_all( $this->_def['regex']['film']['country'], $page, $cList );
			
			preg_match_all( $this->_def['regex']['film']['genre'], $page, $gList );
            
            if ( $this->_debug ) var_dump( $cList );
            if ( $this->_debug ) var_dump( $title );
            if ( $this->_debug ) var_dump( $gList );                                                   
			
			for( $i=0; $i < count( $gList[0] ); $i++ )
			{
				$genre[] = $api->stringDecode( $gList[1][$i] );
			}
		
			if(!in_array("us",$cList[1])){
				if(!in_array("gb",$cList[1])){
					$titles = $this->GetAka($imdbID);
					if($titles['original']){
						$title[1] = $titles['original'];
					}
					$aka = $titles['aka'];
					
				}
			}
			$genStr = ( count( $genre ) > 0 )? implode( ', ', $genre ):'';
		
			
			$film = array(
				'imdbID' => $imdbID,
				'title' => substr($api->stringDecode( $title[1] ),0,-1),
				'year' => substr($api->stringDecode( $title[2]),1,4),
				'genre' => $genStr,
				'aka' => $api->stringDecode( $aka ),
				'url' => sprintf( $this->_def['url']['id'], $imdbID ) );
			

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
	
	function GetAka( $imdbID){
		global $api;
		$titles = array();
		$url = sprintf( $this->_def['url']['aka'], urlencode( $imdbID ) );
        if ( $this->_debug ) printf( "url: %s \n", $url );  
		if ( ( $page = $this->getUrl( $url, true ) ) !== false ){
			//I do the preg_match in three steps to respect the priority level.
			preg_match_all( $this->_def['regex']['film']['akaInt'], $page, $aka ); 
			if(!$aka[1]){
				preg_match_all( $this->_def['regex']['film']['akaUS'], $page, $aka );
				if(!$aka[1]){
					preg_match_all( $this->_def['regex']['film']['akaUK'], $page, $aka );
				}
			}
			if ( $this->_debug ) var_dump($aka);	
			preg_match( $this->_def['regex']['film']['original'], $page, $original );
			
			if ( $this->_debug ) var_dump($original);
			print_r($aka);
			$titles = array("original"=>$original[1],"aka"=>$aka[1][0]);
			return $titles;
		}
	
	}
}

?>
