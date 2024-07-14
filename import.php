<?php

include('conexion.php');
//require 'conexion.php'

//Para subir layout/////
$fileEmpleados = $_FILES['fileEmpleados']; 
$fileEmpleados = file_get_contents($fileEmpleados['tmp_name']); 

//rint_r($fileEmpleados);
//exit;

$fileEmpleados = explode("\n", $fileEmpleados);
$fileEmpleados = array_filter($fileEmpleados); 

//print_r($fileEmpleados);
//exit;

// preparar contactos (convertirlos en array)
foreach ($fileEmpleados as $empleado) 
{
	$empleadotList[] = explode(";", $empleado);
}


//print_r($empleadotList);
//exit;



//insertar contactos
foreach ($empleadotList as $empleadoData) 
{
	$con ->query("INSERT INTO principal
						(cve_ads,
						 nom_ads,
						 localidad,
						 desc_contratacion,
						 matricula,
						 ocupante,
						 cve_ctg,
						 desc_categoria,
						 plaza,
						 desc_plaza,
						 desc_marca_ocupacion,
						 fecha_ocupacion,
						 desc_horario,
						 ant_anos,
						 ant_qnas,
						 salario_mens_int,
						 rfc,
						 curp,
						 numafil,
						 micro
						 )
						 
						 VALUES

						  ('{$empleadoData[0]}',
						  '{$empleadoData[1]}', 
						  '{$empleadoData[2]}',
						  '{$empleadoData[3]}',
						   {$empleadoData[4]},
						  '{$empleadoData[5]}',
						   {$empleadoData[6]},
						  '{$empleadoData[7]}',
						   {$empleadoData[8]},
						  '{$empleadoData[9]}',
						  '{$empleadoData[10]}',
						  '{$empleadoData[11]}',
						  '{$empleadoData[12]}',
						   {$empleadoData[13]},
						   {$empleadoData[14]},
						   {$empleadoData[15]},
						  '{$empleadoData[16]}',
						  '{$empleadoData[17]}',
						   {$empleadoData[18]},
						  '{$empleadoData[19]}'
						  )

					");

} 

?>