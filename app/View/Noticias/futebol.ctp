<h1>Noticias > Visualizar Noticia</h1>

 	<p>
 	
 		 Titulo:<i><?php  echo $noticia['Noticia']['titulo'];?></i>
 		<br />
 		Subtitulo: <i><?php echo $noticia['Noticia']['subtitulo']; ?></i>
 		<br />	
 		Corpo:<?php echo $noticia['Noticia']['corpo']; ?></p>


   <?php
    if (!empty($noticia['Noticia']['img_upload'])) {
        echo "<p>Imagem:</p> <br><br>";
        echo $this->Html->image("noticias/images/" . $noticia['Noticia']['img_upload'], array("alt" => "Imagem", "title" => "Imagem"));
        echo "<br><br>";
    } else if(!empty($noticia['Noticia']['img_url'])) {
        echo $this->Html->image($noticia['Noticia']['img_url'], array("alt" => "Imagem", "title" => "Imagem"));
        echo "<br><br>";
    }
    ?>
     <br />
	 <p>Rodapé:<?php echo $noticia['Noticia']['rodape']; ?></p>



<?/***************************************************
  * Botoes compartilhamento redes sociais
  ***************************************************/?>
<?//******************** TWITTER ********************************?>
			<a href="https://twitter.com/share" class="twitter-share-button" data-url= <? echo $noticia['url_shortened']; ?>
			 	data-via ="futebolnarede" data-text=<?echo str_replace(" ", "&nbsp;", $noticia['Noticia']['titulo']); //remove espaco em branco e add caractere de espaco em branco no titulo?> data-lang="pt" data-size="small" data-related="futebolnarede" >Tweetar
			</a>		
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
			</script>
<?//******************** TWITTER ********************************?>			


<?//******************** FACEBOOK CURTIR ********************************?>
			<div class="fb-like" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>				
<?//******************** FACEBOOK CURTIR ********************************?>


<?//******************** FACEBOOK COMPARTILHAR ********************************?>
			<div class="fb-share-button" data-type="button_count"></div>				
<?//******************** FACEBOOK COMPARTILHAR********************************?>
		
		
<?//******************** COMPARTILHAR GOOGLE PLUS********************************?>
			<div class="g-plusone"></div>
<?//******************** COMPARTILHAR GOOGLE PLUS********************************?>
	 
<?php 
	 echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('controller' => 'Noticias', 'action' => 'index'), array('escape' => false) );

?>