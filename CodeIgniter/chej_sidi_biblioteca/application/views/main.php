<?defined('BASEPATH') OR exit('No direct script access allowed');?>
<table>
    <tr>
        <th>LIBRO</th>
        <th>AUTOR</th>
    </tr>
<?foreach ($tituloAutor as $tituloYAutor){?>
    <tr>
        <?$porciones = explode("/", $tituloYAutor);?>
        <td><?=$porciones[0]?></td>
        <td><?=$porciones[1]?></td>
    <tr>
<?}?>
</table>