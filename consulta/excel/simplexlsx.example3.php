<?php
echo '<html><body><h1>XLSX to HTML</h1>';

if (isset($_FILES['file'])) {

	require_once 'simplexlsx.class.php';

	if ( $xlsx = SimpleXLSX::parse( $_FILES['file']['tmp_name'] ) ) {

		echo '<h2>Resultados</h2>';
		echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';

		list( $cols, ) = $xlsx->dimension();

		foreach ( $xlsx->rows() as $k => $r ) {
			//		if ($k == 0) continue; // skip first row
			echo '<tr><td>';
			echo $r[ 0 ]."<br>";
			echo $r[ 1 ]."<br>";
			echo $r[ 2 ]."<br>";
			echo $r[ 3 ]."<br>";
			echo $r[ 4 ]."<br>";
			echo $r[ 5 ]."<br>";
			echo $r[ 6 ]."<br>";
			/*echo '<tr>';
			for ( $i = 0; $i < $cols; $i ++ ) {
				echo '<td>' . ( ( isset( $r[ $i ] ) ) ? $r[ $i ] : '&nbsp;' ) . '</td>';
			}*/
			echo '</td></tr>';
		}
		echo '</table>';
		$numTotal = $xlsx->rows();
		echo count($numTotal)." Registros realizados.";
			//print_r( $xlsx->rows() );
	} else {
		echo SimpleXLSX::parse_error();
	}
}
echo '<h2>Upload form</h2>
<form method="post" enctype="multipart/form-data">
*.XLSX <input type="file" name="file"  />&nbsp;&nbsp;<input type="submit" value="Parse" />
</form>';
echo '</body></html>';
