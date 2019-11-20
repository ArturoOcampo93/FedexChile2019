<?PHP
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=regs_caliente.xls");

require_once("js/clases.php");

echo "<table border=0>" ;
echo "<tr>
	<th>Folio</th>
	<th>Nombre</th>
	<th>Correo</th>
	<th>Telefono</th>
	<th>Usuario caliente</th>

	<th>Puntos</th>
	<th>Dia</th>

</tr>";

$todos= Reportes::repTodos();
set_time_limit(0);

for($i=0; $i<count($todos); $i+=1){
		echo '
			<tr>
				<td>'.$todos[$i][0].'</td>
				<td>'.utf8_decode($todos[$i][1]).'</td>
				<td>'.utf8_decode($todos[$i][2]).'</td>
				<td>&nbsp;'.$todos[$i][3].'</td>
				<td>'.$todos[$i][4].'</td>
				<td>'.$todos[$i][5].'</td>
				<td>'.$todos[$i][6].'</td>

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
