<?php
/**
 * Google URL Shortener usando Google API e Stream Context
 *
 *Classe responsável por encurtar uma url através da API do google
 */
class GoogleUrlShortener 
{

/**
 * @param  mixed|string $url
 * 
 * @uses  $shortenUrl('UrlParaSerEncurtada');
 * @return object(stdClass) c/ kind => 'urlshortener#url' id => 'http://goo.gl/YRsXlP' longUrl => 'http://localhost/FNRCake2/'
 * onde id => e a url encurtada e longUrl => e a url completa. 
 */	
function shortenUrl( $url ){

    $opts = array( 'http' => array( 'method'  => 'POST',
                                    'header'  => 'Content-Type: application/json',
                                    'content' => sprintf( '{"longUrl": "%s"}', trim( $url ) )
                                  )
                  );

    return json_decode( 
              file_get_contents( 'https://www.googleapis.com/urlshortener/v1/url',
                  FALSE, stream_context_create( $opts ) ) );
}
	

}
?>
