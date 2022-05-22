<?php

require('../fpdf/rounded_rect.php');
include ('../phpqrcode/qrlib.php');

if (isset($_GET['id'])){
    $id = str_replace(" ","%20",$_GET['id']);
    $url = "http://localhost/siiaServices/QRS/qrgenerator.php?id=".$id;
    file_get_contents($url);

    require ('../apis/Select.php');


    $matricula = explode(",",$_GET['id']);
    $obt = new Select;
    $res = $obt->showdata("SELECT al.matricula, al.nombre, al.facultad, al.programaEducativo, al.semestre, al.grupo, ar.nombreArea, tr.nombretramite, ci.descripcioncita, ci.horaReservada, ci.fechareservadacita FROM simscitas as ci INNER JOIN sicttramites as tr ON tr.idtramite = ci.idtramite INNER JOIN sictareas as ar ON ar.idareacampus = ci.idareacampus INNER JOIN simsalumnos as al ON al.idhistorialacademico = ci.idhistorialacademico WHERE ci.idhistorialacademico = $matricula[1] ORDER BY ci.idcita DESC LIMIT 1");


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
    $pdf->RoundedRect(25, 60, 168, 65, 3.5, 'DF');


    /*
     * TODO: DATOS ALUMNO
     */

    $pdf->Ln();
    $pdf->SetXY(0,68);
    $pdf->SetFont('helvetica','',12);
    $pdf->Cell(81, 0, utf8_decode('Nombre:'), 0, 0, 'C');
    $pdf->SetTextColor(84,4,31);
    $pdf->Cell(10, 0, utf8_decode($res[0]['nombre']), 0, 0, 'C');

    $pdf->Ln();
    $pdf->SetTextColor(0,0,0);
    $pdf->SetXY(85,68);
    $pdf->Cell(81, 0, utf8_decode('Matricula:'), 0, 0, 'C');
    $pdf->SetTextColor(84,4,31);
    $pdf->SetXY(100,68);
    $pdf->Cell(0, 0, utf8_decode($res[0]['matricula']), 0, 0, 'C');



    $pdf->Ln();
    $pdf->SetTextColor(0,0,0);
    $pdf->SetXY(0,77);
    $pdf->Cell(88, 0, utf8_decode('Fecha Cita:'), 0, 0, 'C');
    $pdf->SetTextColor(84,4,31);
    $pdf->SetXY(0,77);
    $pdf->Cell(170, 0, utf8_decode($res[0]['fechareservadacita']), 0, 0, 'C');

    $pdf->Ln();
    $pdf->SetTextColor(0,0,0);
    $pdf->SetXY(80,77);
    $pdf->Cell(81, 0, utf8_decode('Hora:'), 0, 0, 'C');
    $pdf->SetTextColor(84,4,31);
    $pdf->SetXY(95,77);
    $pdf->Cell(0, 0, utf8_decode($res[0]['horaReservada']), 0, 0, 'C');


    $pdf->Ln();
    $pdf->SetTextColor(0,0,0);
    $pdf->SetXY(0,87);
    $pdf->Cell(79, 0, utf8_decode('Tramite:'), 0, 0, 'C');
    $pdf->SetTextColor(84,4,31);
    $pdf->SetXY(0,87);
    $pdf->Cell(170, 0, utf8_decode($res[0]['nombretramite']), 0, 0, 'C');

    $pdf->Ln();
    $pdf->SetTextColor(0,0,0);
    $pdf->SetXY(0,97);
    $pdf->Cell(90, 0, utf8_decode('Descripción:'), 0, 0, 'C');
    $pdf->SetTextColor(84,4,31);
    $pdf->SetXY(65,94);
    $pdf->MultiCell(110, 5, utf8_decode($res[0]['descripcioncita']), 0, 1);


    $pdf->Ln();
    $pdf->SetTextColor(0,0,0);
    $pdf->SetXY(33,110);
    $pdf->MultiCell(32, 5, utf8_decode('Datos generales:'), 0, 1);
    $pdf->SetTextColor(84,4,31);
    $pdf->SetXY(58,112);
    $pdf->MultiCell(110, 4, utf8_decode($res[0]['programaEducativo']." ".$res[0]['facultad']), 0, 1);
    $pdf->Ln();

    /**
     * TODO: FIRMA
     */
    $pdf->SetDash();
    $pdf->Line(70,140,140,140);
    $pdf->Ln();
    $pdf->SetTextColor(0,0,0);
    $pdf->SetXY(20,144);
    $pdf->Cell(170,0,utf8_decode('Firma de recibido'),0,0,'C');

    /**
     * TODO: QR CODE
     */

//$current = file_get_contents(QRcode::png('mocos'));
//file_put_contents($current);

    /**
     * TODO: DASHED BOX
     */

    $pdf->SetLineWidth(0.8);
    $pdf->SetDash(4,4); //4mm on, 2mm off
    $pdf->Rect(25,160,168,87);

    $pdf->Ln();
    $pdf->SetXY(0,165);
    $pdf->SetFont('helvetica','B',11);
    $pdf->Cell(105,0,utf8_decode("Recomendación de cita"),0,0,'C');

    $pdf->SetXY(29,172);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',11);
    $pdf->MultiCell(170,4.9,utf8_decode("- Ser puntual en su cita, en caso contrario se perderá la cita y tendrá que agendar una nueva.
- Favor de llevar una identificación para recoger su documento(s), si no se presenta el interesado, se entrega con carta PODER anexando copias de las credenciales de elector.
- Seguir las recomendaciones sanitarias, usar mínimo cubre bocas.
- Traer lapicero para alguna anotación.
- Solo se permite el acceso a una persona para su tramite."), 0, 1);

    $pdf->Ln();
    $pdf->SetXY(0,208);
    $pdf->SetFont('helvetica','B',11);
    $pdf->Cell(80,0,utf8_decode("Requisitos"),0,0,'C');
    $pdf->Ln();
    $pdf->SetXY(25,213);
    $pdf->SetFont('helvetica','',11);
    $pdf->SetXY(30,213);
    $pdf->MultiCell(120,4,utf8_decode("Consultar la siguiente pagina: https://uatx.mx/secretaria/tecnica/cyre/tramites#collapseFive"),0,1,'C');
    $pdf->Ln();
    $pdf->Image('../QRS/qr.png',155,210,38,"",'png');

    $pdf->SetFont('helvetica','',10);
    $pdf->SetXY(25,255);
    $pdf->Cell(170,0.5,'Documento exclusivo para uso de la dependencia responsable o autoridad ',0,1,'C',1);

    $pdf->setFillColor(90,0,0);
    $pdf->Ln();
    $pdf->SetXY(25,258);
    $pdf->Cell(170,0.5,'',0,1,'C',1);



//$pdf->Output('D', 'ComprobanteCita.pdf');
    $pdf->Output('I','ComprobanteCita.pdf');

}

