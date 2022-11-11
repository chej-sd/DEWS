<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$hoja_estilos = base_url()."./estilos/style.css";
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>BIBLIOTECA MAR ANGOSTO</title>
	<link rel="stylesheet" href="<?=$hoja_estilos?>">
</head>
<body>
	<div id="header">
		<h1>PRESTAMOS</h1>
		<div class="calendario">
			<p>
				<a href="<?=base_url()?>index.php/CHome/generarCalendario/">CALENDARIO</a>
			</p>
		</div>
	</div> 
	<div id="container">
        <div id="bar">
            <ul>
				<?php  foreach ($datos as $categoria){?>
					<?php $gen = $categoria['GENERO'];?>
						<li>
							<a href="<?=base_url()?>index.php/CHome/generarTablaLibrosPorGenero/<?=$gen?>"><?=$gen?></a>
						</li>
				<?php } ?>
				
			</ul>
        </div>
        <div id="main">
			<!--<p>abro div principal</p>-->
			<?php
				
			?>
