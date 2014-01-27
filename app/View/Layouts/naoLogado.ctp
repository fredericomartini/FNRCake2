<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		Futebol Na Rede - Administração
	</title>
	<?php
		echo $this->Html->css('fnrcake');
                echo $this->Html->css('jquery-ui-1.10.3.custom');
                
                echo $this->Html->script(array('jquery.js', 'gerais.js', 'jquery-ui.js', 'jquery.maskedinput.min.js'));
                
		echo $this->fetch('meta');
		echo $this->fetch('css');
                echo $this->fetch('script');
	?>
</head>
<body>
    <div id="container">
        
        <div id="topo">
            <?php echo $this->Html->image("logo_fnr_2013.png", array("alt" => "Futebol Na Rede", "title" => "Futebol Na Rede")); ?>
        </div>
        <div class="clear"> </div>
        <div id="content">
               <?php echo $this->Session->flash(); ?>

                <?php echo $this->fetch('content'); ?>
        </div>
        <div id="footer">
                
        </div>
        
    </div>
    <div id="copyright">&copy; 2013 - Marcos Echevarria</div>
</body>
</html>
