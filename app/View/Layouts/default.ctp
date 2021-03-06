<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
    
        <?php
        
        //Pegando dados da sessão do usuário
        $dadosUser = $this->Session->read();
        
        ?>
    
	<title>
		<?php echo $title_for_layout; ?> - <?php echo $dadosUser['Auth']['User']['nome']; ?> - FNRCake
	</title>
	<?php
		//echo $this->Html->meta('icon');

		echo $this->Html->css('fnrcake');
        echo $this->Html->css('jquery-ui-1.10.3.custom');
               
        echo $this->Html->script(array('jquery.js', 'gerais.js', 'jquery-ui.js', 'jquery.maskedinput.min.js'));
                
		echo $this->fetch('meta');
		echo $this->fetch('css');
        echo $this->fetch('script');
                
	?>
    
<?//********************META tags facebook********************************?>
	<meta property="og:image" content="http://davidwalsh.name/wp-content/themes/klass/img/facebooklogo.png"/> <?// O tamanho máximo da imagem é 100 x 100 pixels, e o mínimo 50 x 50?>
 	<meta property="og:title" content=<?echo str_replace(" ", "&nbsp;", $title_for_layout); //titulo da noticia vem do controller?> />
	<meta property="og:url" content=<?echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; //url completa?> />  
	<meta property="og:type" content="website" />  <?//objeto tipo de conteudo facebook disponibiliza alguns: https://developers.facebook.com/docs/reference/opengraph/ ?>
	<meta property="fb:admins" content="100002554224559"/> <?//id do administrador do facebook possivel pegar atraves de: http://graph.facebook.com/NOME_DO_USUARIO_FACEBOOK ?>
	<meta property="fb:app_id" content="1415240475396900" /> <?//id do app criado possivel pegar atraves de: https://developers.facebook.com/apps/ ?>
<?//********************META tags facebook********************************?> 
  
    
</head>

<body>
<?//********************SDK facebook********************************?>

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=1415240475396900"; 
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

<?//********************SDK facebook********************************?>
	
<?//********************GOOGLE PLUS SCRIPT ********************************?>
		<script type="text/javascript">
	  window.___gcfg = {lang: 'pt-BR'};
	
	  (function() {
	    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	    po.src = 'https://apis.google.com/js/platform.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>
			
<?//********************GOOGLE PLUS SCRIPT ********************************?>    

    <div id="container">
        <div id="topo">
            <?php
            echo $this->Html->link($this->Html->image("logo_fnr_2013.png", array("alt" => "Futebol Na Rede", "title" => "Futebol Na Rede")), array('controller' => 'homes', 'action' => 'index'), array('escape' => false) );
            ?>
        </div>    
        <div id="BlocoUser">
            <p>Bem vindo, <span class="fontNomeUsuario"><b><?php echo $dadosUser['Auth']['User']['nome']; ?></b></span> (<?php echo $this->Html->link('Sair', array('controller' => 'users', 'action' => 'logout')); ?>)
            <br>
            <span class="fontUltimoAcesso">Último acesso: <?php echo date('d/m/Y H:i', strtotime($dadosUser['Auth']['User']['ultimoacesso'])); ?></span></p>
        </div>
        <div class="clear"> </div>
        <?php echo $this->element('menu'); ?>
        <div class="clear"> </div>
        <div id="content">
               <?php echo $this->Session->flash(); ?>

                <?php echo $this->fetch('content'); ?>
        </div>
        <div id="footer">
            <?php echo $this->Html->image("carregando.gif", array('class' => 'hide', 'id' => 'loader')); ?>
            
            <?php //echo $this->element('sql_dump'); ?>
        </div>
        
    </div>
    <div id="copyright">&copy; 2013 - <a href="http://www.bemobile.cc" target="_blank">BeMobile</a></div>
    <?php echo $this->Js->writeBuffer();?>
</body>
</html>
