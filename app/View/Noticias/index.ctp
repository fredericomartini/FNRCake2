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
	

<?//********************like-box facebook c/ opção de curtir********************************?>
	<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FFutebol-Na-Rede%2F392474120767741&amp;width=200&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:290px;" allowTransparency="true"></iframe>		
<?//********************like-box facebook c/ opção de curtir********************************?>




    <?php unset($noticia); ?>
<?php
    if ($this->Paginator->counter('{:pages}') > 1) {
        echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
    }
?>

<?php echo $this->Js->writeBuffer(); ?>
 