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
	
  		 <!-- PLUGN P/ COMENTARIOS C/ O LOGIN DO FACEBOOK, DEVE SER INCLUIDO O FACEBOOK SDK NA TAG BODY -->
		  <div class="fb-comments" data-href="https://www.facebook.com/futebolnarede" data-width="400" data-numposts="5" data-colorscheme="light"></div>	 
<?php 
	 echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('controller' => 'Noticias', 'action' => 'index'), array('escape' => false) );
?>