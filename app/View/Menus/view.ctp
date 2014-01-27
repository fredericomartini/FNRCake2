<h1>Menus do sistema > Visualizar menu</h1>

<p>
   Nome: <i><?php echo $menu['Menu']['nome']; ?></i> <br>
   Controller: <i><?php echo $menu['Menu']['controller']; ?></i> <br>
   Menu: <i><?php echo $menu['Menu']['menu']; ?></i> <br>
   Ordem: <i><?php echo $menu['Menu']['ordem']; ?></i> <br>
   Mostra no menu: <i><?php if ($menu['Menu']['mostramenu'] == "1") { echo "SIM"; } else { echo "NAO"; }; ?></i> <br>
</p>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('controller' => 'menus', 'action' => 'index'), array('escape' => false) );
?>

