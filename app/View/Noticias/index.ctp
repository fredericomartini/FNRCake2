<?php 

    $this->Paginator->options(array(
        'update' => '#content',
        'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
        'complete' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false)),
    ));
?>
<h1>Noticias</h1>

<?echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('controller' => 'noticias', 'action' => 'add'), array('escape' => false) );?>
<table>
		
<?php
    $tableHeaders = $this->Html->tableHeaders(array(
        $this->Paginator->sort('id'),
        $this->Paginator->sort('titulo'),
        $this->Paginator->sort('datahora','Data/Hora'),
        'Ação'
    ));
	
	echo $tableHeaders;
	
	$rows = array();
	
	foreach ($noticias as $noticia):
		/**FORMATA DATA/HORA EM DD/MM/YYYY HH:MM:SS **/
		$datahora =  substr($noticia['Noticia']['datahora'],8,2);
							$datahora .= '/'.substr($noticia['Noticia']['datahora'],5,2);
							$datahora .= '/'.substr($noticia['Noticia']['datahora'],0,4);
							$datahora .= ' '.substr($noticia['Noticia']['datahora'],11,2);
							$datahora .= ':'.substr($noticia['Noticia']['datahora'],14,2);
							$datahora .= ':'.substr($noticia['Noticia']['datahora'],17,2);
		 $rows[] = array(
            $noticia['Noticia']['id'],
            $this->Html->link($noticia['Noticia']['titulo'], array('action' => 'futebol'. '/'. $noticia['Noticia']['slug'],
            													   'ext'	=> 'html' )),
            $datahora,	
            $this->Html->link('Editar Noticia', array('action' => 'edit'.'/'. $noticia['Noticia']['slug'],
            										  'ext'	   => 'html')),
            
            $this->Html->link('Editar Imagem', array('action' => 'edit_image'.'/'. $noticia['Noticia']['slug'],
            										 'ext'	  => 'html')),
            $this->Form->postLink('Apagar',array('action' => 'delete', $noticia['Noticia']['slug']),array('confirm' => 'Você realmete deseja apagar essa Notícia?')),
        );
    endforeach;
    
    echo $this->Html->tableCells($rows);
?>		
</table> 
	<div id = "social-panel-like-box" style="width: 200px; background-color: yellow; color: red;" >
		<!-- FACEBOOK LIKE BOX -->
		<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FFutebol-Na-Rede%2F392474120767741&amp;width=200&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:290px;" allowTransparency="true"></iframe>		
		<br />
		<br />
		<br />
		<!-- BUTONS -->
		<!-- TWITTER -->
		<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://localhost/FNRCake2/Noticias" data-text="Futebol na Rede" data-via="frederico_ma" data-lang="pt" data-size="large" data-related="futebolnarede" data-hashtags="futebolnarede">Tweetar</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		<br />
		<!-- FACEBOOK CURTIR -->
		<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Ffutebolnarede&amp;width=200&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=true&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:21px;" allowTransparency="true"></iframe>
		<br />
		<!-- GOOGLE+ -->
		<!-- Posicione esta tag onde você deseja que o botão +1 apareça. -->
		<div class="g-plusone" data-annotation="none"></div>
		<br />
		<!-- Posicione esta tag depois da última tag do botão +1. -->
		<script type="text/javascript">
		  window.___gcfg = {lang: 'pt-BR'};
		
		  (function() {
		    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		    po.src = 'https://apis.google.com/js/platform.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>
		<br />	  			
	</div>
	


    <?php unset($noticia); ?>
<?php
    if ($this->Paginator->counter('{:pages}') > 1) {
        echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
    }
?>


<?php echo $this->Js->writeBuffer(); ?>
 