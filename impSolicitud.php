<?php
session_start();
require_once "../lib/mpdf/vendor/autoload.php";
include_once 'crud/consulta.php';
//error_reporting(E_ALL);
date_default_timezone_set('America/Mexico_City');
$login = $_SESSION["loginApps"];

if(isset($_GET['s'])){
    $idSolicitud = base64_decode($_GET['s']);
    $consulta = new consultas;
    $res = $consulta->productoSolicitud($idSolicitud);
    $sol = $consulta->consultaSolicitud($idSolicitud);
	$area = $consulta->verAreaUsuario($login['id_usuario']);
}

if($sol['estatus'] == 2){
    $html = "<br>";
	$html .= "<table style='width:100%;' border='0' autosize='0'>";
		$html .= "<tr>";
			$html .= "<td style='width:100%; text-align:center' colspan='4'><h2>RECEPCI&Oacute;N DE MATERIAL</h2></td>";
		$html .= "</tr>";

		$html .= "<tr>";
			$html .= "<td style='width:100%; text-align:center' colspan='4'><h4>(Coordinaci&oacute;n de Recursos Materiales)</h4></td>";
		$html .= "</tr>";

		$html .= "<tr>";
			$html .= "<td style='width:100%; text-align:center' colspan='4'><h4>&nbsp;</h4></td>";
		$html .= "</tr>";
		
		$html .= "<tr>";
			$html .= "<td style='text-align:left' colspan='4'><h4>Solicitud: ".$sol['id_solicitud']."</h4></td>";
		$html .= "</tr>";

		$html .= "<tr>";
			$html .= "<td style='width:100%; text-align:center' colspan='4'><h4>&nbsp;</h4></td>";
		$html .= "</tr>";

		$html .= "<tr>";
			$html .= "<td style='text-align:right' colspan='4'><h4>Fecha de Impresión: ".date('d/m/Y')."</h4></td>";
		$html .= "</tr>";

		$html .= "<tr>";
			$html .= "<td style='width:100%; text-align:center' colspan='4'><h4>&nbsp;</h4></td>";
		$html .= "</tr>";

        $html .= "<tr>";
			$html .= "<td style='text-align:center; background-color:gray;' colspan='3'><h4>MATERIAL</h4></td>";
            $html .= "<td style='text-align:center; background-color:gray;' ><h4>CANTIDAD</h4></td>";
		$html .= "</tr>";

        foreach($res as $item){
            if($item['estatus'] == 3){
                $html .= "<tr>";
                    $html .= "<td style='text-align:center; border:solid 1px;' colspan='3'><label>".$item['descripcion']."</label></td>";
                    $html .= "<td style='text-align:center; border:solid 1px;' ><label>".$item['cantidad_autorizada']."</label></td>";
                $html .= "</tr>";
            }
        }

		$html .= "<tr>";
			$html .= "<td style='width:100%; text-align:center' colspan='4'><h4>&nbsp;</h4></td>";
		$html .= "</tr>";

        $html .= "<tr>";
			$html .= "<td style='text-align:center;' colspan='4'><img src='codes/".date('Y')."/".base64_decode($_GET['s']).".png' width='200'></td>";
		$html .= "</tr>";

		$html .= "<tr>";
			$html .= "<td style='text-align:center;' ><label>&nbsp;</label></td>";
			$html .= "<td style='text-align:center; border:solid 1px; padding-top:110px' colspan='2'><label>".$area['area']." <p>SOLICITADO</p></label></td>";
			$html .= "<td style='text-align:center;' ><label>&nbsp;</label></td>";
		$html .= "</tr>";

		$html .= "<tr>";
			$html .= "<td style='text-align:center; border:solid 1px; padding-top:110px' colspan='2'><label>".$login['nombres']." ".$login['primer_apellido']." ".$login['segundo_apellido']." <p>RECIBIDO</p></label></td>";
			$html .= "<td style='text-align:center; border:solid 1px; padding-top:110px' colspan='2'><label>ENTREGADO POR</label></td>";
		$html .= "</tr>";
    $html .= "</table>";
	printf("<script>generarQr('".base64_decode($_GET['s'])."');</script>");

    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [210, 297], 'tempDir' => '/lib/tmp', 'default_font' => 'Montserrat']);

	$mpdf->setAutoTopMargin = 'stretch';
	$mpdf->shrink_tables_to_fit = 0;
	$mpdf->keep_table_proportions = false;
	$mpdf->SetHTMLHeader("<div style='text-align: left;'>
							<img src='https://carnet.insabi.gob.mx/imagenes/insabi.png' width='300'>
						</div>");
	$mpdf->SetHTMLFooter("<div style='text-align: left;'>
							<img src='https://carnet.insabi.gob.mx/imagenes/pie.png' width='700'>
						</div>");
	//$mpdf->SetHTMLFooter('Pag. {PAGENO} de {nb}');
	//$mpdf->SetDefaultBodyCSS('background', "url('http://".$_SERVER['HTTP_HOST']."/insabi/SIRPA/imagenes/Alas.png')");
	//$mpdf->SetDefaultBodyCSS('background-image-resize', 6);
	//$mpdf->SetDefaultBodyCSS('background-repeat', "no-repeat");

	$mpdf->WriteHTML($html);

	//$mpdf->AddPage();
	//$mpdf->WriteHTML(utf8_encode($html2));
	//$mpdf->AddPage();
	//$mpdf->WriteHTML(utf8_encode($html3));
	//$mpdf->Output("Reporte_".$_GET["c"].".pdf", 'D');

	$mpdf->Output();
}else{
    printf("<script>Window history.back();</script>");
}