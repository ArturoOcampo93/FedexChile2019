<?php
require_once("js/clases.php");

$semana = $_GET['semana'];

$ganadores = Guias::cuantosParticipacionesSemana($semana);

$num_rows = 0;
$num_rows =  count($ganadores);


	if($num_rows > 0 ){

		date_default_timezone_set('America/Mexico_City');

		if (PHP_SAPI == 'cli')
			die('Este archivo solo se puede ver desde un navegador web');

		/** Se agrega la libreria PHPExcel */
		//require_once 'lib/PHPExcel.php';
		require_once 'lib/Classes/PHPExcel.php';

		// Se crea el objeto PHPExcel
		$objPHPExcel = new PHPExcel();

		// Se asignan las propiedades del libro
		$objPHPExcel->getProperties()->setCreator("Codedrinks") //Autor
							 ->setLastModifiedBy("Codedrinks") //Ultimo usuario que lo modificó
							 ->setTitle("Reporte Excel con PHP y MySQL")
							 ->setSubject("Reporte Excel con PHP y MySQL")
							 ->setDescription("Reporte de Resultados")
							 ->setKeywords("reporte resultados")
							 ->setCategory("Reporte excel");

		$tituloReporte = "Resultados semana ".$semana;
		$titulosColumnas = array('Id', 'Email', 'Guia', 'Cuenta', 'Premio', 'estatus', 'estatus', 'Fecha', 'dom', 'shipper', 'overral', 'service');

		$objPHPExcel->setActiveSheetIndex(0)
        		    ->mergeCells('A1:L1');

		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1',$tituloReporte)
        		    ->setCellValue('A3',  $titulosColumnas[0])
		            ->setCellValue('B3',  $titulosColumnas[1])
        		    ->setCellValue('C3',  $titulosColumnas[2])
        		    ->setCellValue('D3',  $titulosColumnas[3])
        		    ->setCellValue('E3',  $titulosColumnas[4])
            		->setCellValue('F3',  $titulosColumnas[5])
            		->setCellValue('G3',  $titulosColumnas[6])
            		->setCellValue('H3',  $titulosColumnas[7])
            		->setCellValue('I3',  $titulosColumnas[8])
            		->setCellValue('J3',  $titulosColumnas[9])
            		->setCellValue('K3',  $titulosColumnas[10])
            		->setCellValue('L3',  $titulosColumnas[11]);


		//Se agregan los datos de los alumnos
		$i = 4;
		for($j=0; $j<count($ganadores); $j+=1){
			$id = $ganadores[$j][0];
			$mail = $ganadores[$j][1];
			$guia = $ganadores[$j][2];
			$cuenta = $ganadores[$j][3];
			$estatus = $ganadores[$j][6];
			$premio = $ganadores[$j][7];
			$idPrem = $ganadores[$j][8];
			$im = $ganadores[$j][13];
			$fecha = $ganadores[$j][5];
			$delivered = "";

			if($estatus == 'ok'){
				$estatus = "Válida";
				$delivered = "delivered";
			}
			if($premio == ''){
				$estatus = "Sin participación";
			}

			$guiaDat = array();
			//busca en tabla de guias demas datos
			if($cuenta == ""){
				$guiaDat = array('', '', '', '', '', '', '');
			}else{
				$guiaDat = Guias::datosGuia($guia);
			}


			$objPHPExcel->setActiveSheetIndex(0)
        		    ->setCellValue('A'.$i, $id)
		            ->setCellValue('B'.$i, $mail)
        		    ->setCellValue('C'.$i, $guia)
            		->setCellValue('D'.$i, $cuenta)
            		->setCellValue('E'.$i, $premio)
            		->setCellValue('F'.$i, $delivered)
            		->setCellValue('G'.$i, $estatus)
            		->setCellValue('H'.$i, $fecha)
            		->setCellValue('I'.$i, $guiaDat[2])
            		->setCellValue('J'.$i, $guiaDat[5])
            		->setCellValue('K'.$i, $guiaDat[6])
            		->setCellValue('L'.$i, $guiaDat[7]);

					$i++;
		}

		$estiloTituloReporte = array(
        	'font' => array(
	        	'name'      => 'Verdana',
    	        'bold'      => true,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>16,
	            	'color'     => array(
    	            	'rgb' => '000000'
        	       	)
            ),
	        'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('rgb' => '999999')
			),
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_NONE
               	)
            ),
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		)
        );

		$estiloTituloColumnas = array(
            'font' => array(
                'name'      => 'Arial',
                'bold'      => true,
                'color'     => array(
                    'rgb' => 'FFFFFF'
                )
            ),
            'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
				'rotation'   => 90,
        		'startcolor' => array(
            		'rgb' => '222222'
        		),
        		'endcolor'   => array(
            		'rgb' => '444444'
        		)
			),
            'borders' => array(
            	'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '143860'
                    )
                ),
                'bottom'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '143860'
                    )
                )
            ),
			'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'wrap'          => TRUE
    		));

		$estiloInformacion = new PHPExcel_Style();
		$estiloInformacion->applyFromArray(
			array(
           		'font' => array(
               	'name'      => 'Arial',
               	'color'     => array(
                   	'rgb' => '000000'
               	)
           	),
           	'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'		=> array('arg' => 'BBBBBB')
			),
           	'borders' => array(
               	'left'     => array(
                   	'style' => PHPExcel_Style_Border::BORDER_THIN ,
	                'color' => array(
    	            	'rgb' => '3a2a47'
                   	)
               	)
           	)
        ));

		$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A3:L3')->applyFromArray($estiloTituloColumnas);
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:L".($i-1));

		for($i = 'A'; $i <= 'J'; $i++){
			$objPHPExcel->setActiveSheetIndex(0)
				->getColumnDimension($i)->setAutoSize(TRUE);
		}

		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('Resultados');

		// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
		$objPHPExcel->setActiveSheetIndex(0);
		// Inmovilizar paneles
		//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
		$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

		// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="resultados_'.$semana.'.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;

	}
	else{
		print_r('No hay resultados para mostrar');
	}

?>
