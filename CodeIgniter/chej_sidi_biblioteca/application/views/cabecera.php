<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>BIBLIOTECA MAR ANGOSTO</title>
	<link rel="stylesheet" href="./estilos/style.css">
</head>
<body>
	<div id="header">
		<h1>PRESTAMOS</h1>
	</div>
	<div id="container">
        <div id="bar">
            <ul>
				<?php 
					foreach ($datos as $categoria){
						echo "<li><a href='#'>".$categoria['GENERO']."</a></li>";
					}
				?>
			</ul>
        </div>
        <div id="main">
