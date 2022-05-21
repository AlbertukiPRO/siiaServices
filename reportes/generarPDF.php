<?php

require('../fpdf/rounded_rect.php');
include ('../phpqrcode/qrlib.php');

if (isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    $id = "Temporal";
}


$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AddPage();
/*
 * @TODO: NOMBRE UATx
*/
$pdf->SetFont('helvetica','B',18);
$pdf->Image('imgs/uatx.jpg', 25, 18, 22);
$pdf->Cell(232, 30, utf8_decode('UNIVERSIDAD AUTÓNOMA DE TLAXCALA'), 0, 0, 'C');
//DRAW LINES
/*
 * @TODO: LINEAS IZQUIERDAS
*/
$pdf->setFillColor(84,4,31);
$pdf->Ln();
$pdf->SetXY(58,33);
$pdf->Cell(40,1.1,'',0,1,'C',1);
$pdf->setFillColor(100,73,9);
$pdf->Ln();
$pdf->SetXY(58,35);
$pdf->Cell(40,1.1,'',0,1,'C',1);
$pdf->Ln();

/*
 * @TODO: Comprobante CITA
*/
$pdf->SetXY(45,34.5);
$pdf->SetFont('helvetica','',17);
$pdf->Cell(0, 0, utf8_decode('Comprobante Cita'), 0, 0, 'C');
$pdf->Ln();

/*
 * @TODO: LINEAS DERECHAS
*/
$pdf->setFillColor(84,4,31);
$pdf->Ln();
$pdf->SetXY(153,33);
$pdf->Cell(40,1.1,'',0,1,'C',1);
$pdf->setFillColor(100,73,9);
$pdf->Ln();
$pdf->SetXY(153,35);
$pdf->Cell(40,1.1,'',0,1,'C',1);
$pdf->Ln();

/*
 * TODO: BOX CORNER ROUNDED
 * */
$pdf->SetLineWidth(0.1);
$pdf->SetFillColor(255,255,254);
$pdf->RoundedRect(25, 60, 168, 70, 3.5, 'DF');


/*
 * TODO: DATOS ALUMNO
 */

$pdf->Ln();
$pdf->SetXY(0,68);
$pdf->SetFont('helvetica','',12);
$pdf->Cell(81, 0, utf8_decode('Nombre:'), 0, 0, 'C');
$pdf->SetTextColor(84,4,31);
$pdf->Cell(10, 0, utf8_decode('Alberto Noche Rosas'), 0, 0, 'C');

$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(85,68);
$pdf->Cell(81, 0, utf8_decode('Matricula:'), 0, 0, 'C');
$pdf->SetTextColor(84,4,31);
$pdf->SetXY(100,68);
$pdf->Cell(0, 0, utf8_decode('20181837'), 0, 0, 'C');



$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(0,77);
$pdf->Cell(88, 0, utf8_decode('Fecha Cita:'), 0, 0, 'C');
$pdf->SetTextColor(84,4,31);
$pdf->SetXY(0,77);
$pdf->Cell(170, 0, utf8_decode('25/05/2022'), 0, 0, 'C');

$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(80,77);
$pdf->Cell(81, 0, utf8_decode('Hora:'), 0, 0, 'C');
$pdf->SetTextColor(84,4,31);
$pdf->SetXY(95,77);
$pdf->Cell(0, 0, utf8_decode('8:50 hrs'), 0, 0, 'C');


$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(0,87);
$pdf->Cell(79, 0, utf8_decode('Tramite:'), 0, 0, 'C');
$pdf->SetTextColor(84,4,31);
$pdf->SetXY(0,87);
$pdf->Cell(170, 0, utf8_decode('Baja Temporal '), 0, 0, 'C');

$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(0,97);
$pdf->Cell(90, 0, utf8_decode('Descripción:'), 0, 0, 'C');
$pdf->SetTextColor(84,4,31);
$pdf->SetXY(62,94);
$pdf->MultiCell(110, 5, utf8_decode('Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.'), 0, 1);


$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(30,115);
$pdf->MultiCell(32, 5, utf8_decode('Datos generales:'), 0, 1);
$pdf->SetTextColor(84,4,31);
$pdf->SetXY(28,119);
$pdf->MultiCell(150, 0, utf8_decode('Ingenieria en computación, 8 B, Campus Apizaquito'), 0, 0);

/**
 * TODO: QR CODE
 */

$current = file_get_contents(QRcode::png('mocos'));
file_put_contents($current);

/**
 * TODO: DASHED BOX
*/

$pdf->SetLineWidth(0.8);
$pdf->SetDash(4,2); //4mm on, 2mm off
$pdf->Rect(25,180,168,50);

$pdf->SetXY(29,185);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('helvetica','',12);
$pdf->MultiCell(160,4.9,utf8_decode("- Ser puntual en su cita, en caso contrario se perderá la cita y tendrá que agendar una nueva.
- Favor de llevar una identificación para recoger su documento(s), si no se presenta el interesado, se entrega
con carta PODER anexando copias de las credenciales de elector
- Seguir las recomendaciones sanitarias, usar mínimo cubre
bocas Traer lapicero para alguna anotación
Solo se permite el acceso a una persona para su tramite
"), 0, 1);
//TODO: GOOD
//$pdf->Output('D', 'ComprobanteCita.pdf');
$pdf->Output('I','ComprobanteCita.pdf');


