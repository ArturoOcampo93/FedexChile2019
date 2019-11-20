<?PHP
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=sabrosano_ganadores.xls");

$desde = $_GET['desde'];
$hasta = $_GET['hasta'];

require_once("js/clases.php");

echo "<table border=0>" ;
echo "<tr>
	<th>folio</th>
	<th>Nombre</th>
	<th>Paterno</th>
	<th>Materno</th>
	<th>TelCasa</th>

	<th>Correo</th>
	<th>Fecha nacimiento</th>

	<th>delMun</th>
	<th>Estado</th>

	<th>Código</th>
	<th>Premio</th>
	<th>Donde Compro</th>
	<th>Estatus</th>
	<th>Fecha</th>
	<th>Confirmado</th>
</tr>";

$todos= Reportes::repTodosCorte($desde, $hasta);

for($i=0; $i<count($todos); $i+=1){
		echo '
			<tr>
				<td>'.utf8_decode($todos[$i][0]).'</td>
				<td>'.utf8_decode($todos[$i][1]).'</td>
				<td>'.utf8_decode($todos[$i][2]).'</td>
				<td>'.utf8_decode($todos[$i][3]).'</td>
				<td>&nbsp;'.$todos[$i][4].'</td>
				<td>&nbsp;'.$todos[$i][6].'</td>

				<td>'.$todos[$i][7].'/'.$todos[$i][8].'/'.$todos[$i][9].'</td>
				<td>'.utf8_decode($todos[$i][12]).'</td>
				<td>'.$todos[$i][13].'</td>
				<td>'.utf8_decode($todos[$i][14]).'</td>
				<td>'.utf8_decode($todos[$i][15]).'</td>

				<td>&nbsp;'.$todos[$i][16].'</td>
				<td>&nbsp;'.$todos[$i][17].'</td>
				<td>&nbsp;'.$todos[$i][18].'</td>
				<td>&nbsp;'.$todos[$i][19].'</td>
			</tr>
		';
}
 /*GetMyConnection();
$sql2 = "SELECT `tbl_registro`.`nId`, `tbl_registro`.`cNombre`, `tbl_registro`.`cPaterno`, `tbl_registro`.`cMaterno`, `tbl_registro`.`cDia`, `tbl_registro`.`cMes`, `tbl_registro`.`cAyo`, `tbl_registro`.`cGenero`, `tbl_registro`.`cTelefono`, `tbl_registro`.`cMail`, `tbl_registro`.`cCalle`, `tbl_registro`.`cNumero`,  `tbl_registro`.`cColonia`, `tbl_registro`.`cEstado`, `tbl_registro`.`cDelmun`, `tbl_registro`.`cFecha`   FROM `tbl_registro` order by `tbl_registro`.`nId`";

$result2=mysql_query($sql2);
CleanUpDB();

while ($row3=mysql_fetch_assoc($result2))
{
    echo "<tr>
<td>".$row3['nId']."</td>
<td>".$row3['cNombre']."</td>
<td>".$row3['cPaterno']."</td>
<td>".$row3['cMaterno']."</td>
<td>".$row3['cDia']."</td>
<td>".$row3['cMes']."</td>
<td>".$row3['cAyo']."</td>
<td>".$row3['cGenero']."</td>
<td>&nbsp;".$row3['cTelefono']."</td>
<td>".$row3['cMail']."</td>
<td>".$row3['cCalle']."</td>
<td>&nbsp;".$row3['cNumero']."</td>
<td>".$row3['cColonia']."</td>
<td>".utf8_decode($row3['cEstado'])."</td>
<td>".$row3['cDelmun']."</td>
<td>".$row3['cFecha']."</td>
</tr>";
}*/
	echo "</table>";
?>
