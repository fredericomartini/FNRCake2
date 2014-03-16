<?php
/**
 * Google URL Shortener usando Google API e Stream Context
 *
 * @param  mixed|string $url
 *
 * @return string
 */
class GoogleUrlShortener 
{
	
	//O controller principal que recebe a url no caso de não existir um controller associado
	//Sem o Controller.php, ou seja para PagesController.php, apenas o Pages
	
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
