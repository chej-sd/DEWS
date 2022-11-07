
<table>
    <tr>
        <th>LIBRO</th>
        <th>AUTOR</th>
    </tr>
<?foreach ($titulosYLibros as $fila){?>
    <tr>
        <td><?=$fila['titulo']?></td>
        <td><?=$fila['nombre']?></td>
    <tr>
<?}?>
</table>