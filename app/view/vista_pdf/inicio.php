<?php
require 'app/view/pdf/fpdf/fpdf.php';

$filas_detalle = count($datos_detalle_venta);

if($filas_detalle==1 || $filas_detalle==2){
	$pdf = new FPDF('P','mm',array(80,220));
}elseif($filas_detalle==3 || $filas_detalle==4){
	$pdf = new FPDF('P','mm',array(80,240));
}elseif($filas_detalle==5 || $filas_detalle==6){
	$pdf = new FPDF('P','mm',array(80,260));
}else{
	$pdf = new FPDF('P','mm',array(80,300));
}
$pdf->AddPage();
//CABECERA DEL ARCHIVO
//if (file_exists($datos_empresa->empresa_foto_ticket)) {
//	$pdf->Image("$datos_empresa->empresa_foto_ticket", 31, 5, 20,20);
//}
$pdf->Ln(15);
$pdf->SetFont('Helvetica','',7);
$pdf->Cell(60,4, "$datos_empresa->nombrecomercial",0,1,'C',0);
$pdf->Cell(60,4,"RUC $datos_empresa->empresa_ruc",0,1,'C');
$pdf->SetFont('Helvetica','',7);
$pdf->Cell(60,4,"$datos_empresa->empresa_domiciliofiscal",0,1,'C');
$pdf->Cell(60,4,"$datos_empresa->empresa_ubigeo - $datos_empresa->empresa_provincia - $datos_empresa->empresa_distrito",0,1,'C');
$pdf->SetFont('Helvetica','',10);
$pdf->Ln(4);
$pdf->Cell(60,4, utf8_decode($tipo_comprobante),0,1,'C',0);
$pdf->Cell(60,4, "$serie_correlativo",0,1,'C',false);
$pdf->SetFont('Helvetica','',8);
$pdf->Ln(1);
$fecha_hoy = date('Y-m-d H:i:s');
$pdf->Cell(60,4, "$fecha_hoy",0,1,'C',false);

$pdf->SetFont('Helvetica','',7);
$pdf->Ln(3);

$pdf->Cell(60,4,"DATOS DEL CLIENTE",1,1,'C');

$pdf->SetMargins(10,'');

$pdf->MultiCell(60,4,utf8_decode("CLIENTE:    ".$datos_venta->cliente_nombre),0,1,'');


$pdf->Cell(60,4,"$documento",0,1,'');
$pdf->MultiCell(60,4,utf8_decode("DIRECCION:          ").utf8_decode($datos_venta->cliente_direccion),0,1,'');
$pdf->Cell(60,4,"FECHA:                  ".date('d-m-Y H:i:s', strtotime($datos_venta->venta_fecha)),0,1,'');
$pdf->Cell(60,4,"TIPO DE PAGO:    ".$datos_venta->tipo_pago_nombre,0,1,'');
$pdf->SetMargins(10,'');
$pdf->Cell(60,4,"$dato_impresion",1,1,'C');
// COLUMNAS
$pdf->SetFont('Helvetica','B',7);
$pdf->Cell(30, 10, utf8_decode('Descripcion'), 0);
$pdf->Cell(5, 10, 'Cant',0,0,'R');
$pdf->Cell(10, 10, 'Precio',0,0,'R');
$pdf->Cell(15, 10, 'Total',0,0,'R');
$pdf->Ln(8);
$pdf->Cell(60,0,'','T');
$pdf->Ln(1);

foreach ($datos_detalle_venta as $f){
	$pdf->SetFont('Helvetica', '', 7);
	$pdf->MultiCell(30,4,"$f->venta_detalle_nombre_producto",0,'L');
	$pdf->Cell(35, -5, "$f->venta_detalle_cantidad",0,0,'R');
	$pdf->Cell(10, -5, number_format(round("$f->venta_detalle_precio_unitario",2), 2, '.', ' '),0,0,'R');
	$pdf->Cell(15, -5, number_format(round("$f->venta_detalle_valor_total",2), 2, '.', ' '),0,0,'R');
	$pdf->Ln(2);
}

// SUMATORIO DE LOS PRODUCTOS Y EL IVA
$pdf->Ln(3);
$pdf->Cell(60,3,'','T');
$pdf->Ln();
$pdf->Cell(60, 1.5, "Op.Grat: 'S/.' '00.00'", 0,'1','R');
$pdf->Ln();
$pdf->Cell(60, 1.5, "Op.Exon: 'S/.' '00.00'", 0,'1','R');
$pdf->Ln();
$pdf->Cell(60, 1.5, "Op.Inaf: 'S/.' '00.00'", 0,'1','R');
$pdf->Ln();
$pdf->Cell(60, 1.5, "Op.Grav: 'S/.' '00.00'", 0,'1','R');
$pdf->Ln();
$pdf->Cell(60, 1.5, "IGV: 'S/.' '00.00'", 0,'1','R');
$pdf->Ln();
$pdf->Cell(60, 1.5, "Pago con: 'S/.' '00.00'", 0,'1','R');
$pdf->Ln();
$pdf->Cell(60, 1.5, "Vuelto: 'S/.' '00.00'", 0,'1','R');
$pdf->Ln();

$pdf->SetFont('Helvetica', 'B', 7);
$pdf->Ln();
$pdf->Cell(60, 1.5, "TOTAL: 'S/.' $datos_venta->venta_total", 0,'1','R');
$pdf->Ln();
$pdf->Cell(60, 1.5, "$importe_letra", 0,'1','R');
// PIE DE PAGINA
$pdf->Ln(2);
//$pdf->Image("$ruta_qr", '8', $pdf->GetY() , '20', '20', '', '');

// PIE DE PAGINA
$pdf->Ln(3);
$pdf->SetFont('Helvetica', '', 6.5);
//$pdf->Cell(60,0,"$qrcode",0,1,'C');
$pdf->Ln(2);
$pdf->Cell(60,0,utf8_decode('TiendaVargas'),0,1,'R');
$pdf->Ln(3);
$pdf->Cell(60,0,utf8_decode('La mejor calidad al mejor precio '),0,1,'R');
$pdf->Ln(3);
$pdf->Cell(60,0,'TiendaVargas24@gmail.com',0,1,'R');
$pdf->Ln(3);

$pdf->Ln(3);
$pdf->Cell(60,0,'',0,1,'C');
////        $imagePath = public_path();
//if(isset($guardar_localmente) && isset($ruta_guardado)){
//	$ruta_guardado = 'comprobantes/'."$serie_correlativo-" .date('Y-m-d').'.pdf';
//	$pdf->Output("I",$ruta_guardado);
//} else {
//	$pdf->Output('',"$serie_correlativo-" .date('Y-m-d'));
//}
$ruta_guardado = 'comprobantes/'."$serie_correlativo-" .date('Y-m-d').'.pdf';
$pdf->Output("I",$ruta_guardado);
exit;
?>