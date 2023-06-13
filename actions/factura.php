<?php

session_start();
$id = htmlspecialchars($_POST['id']);
include_once "../utiles/funciones.php";
require('../utiles/fpdf.php');
define('EURO', chr(128));
try {
    $conexion = conexionBD();

    $resul  = $conexion->query("SELECT usu.usuario, CONCAT(usu.nombre,\" \", usu.apellidos) cliente, usu.direccion, "
                    . "usu.email, com.id_producto idproducto, pro.precio, com.cantidad, ped.fecha, "
                    . "pro.nombre producto FROM pedidos ped INNER JOIN usuarios usu ON ped.id_usuario=usu.ID INNER JOIN "
                    . "productos_comprados com ON ped.id_pedido=com.id_pedido INNER JOIN productos pro ON com.id_producto=pro.ID "
                    . "WHERE ped.id_pedido='" . $id . "'") or die(print($conexion->errorInfo()));
    $datos2 = [];

    while ($row = $resul->fetch(PDO::FETCH_OBJ)) {
        $date  = date_create($row->fecha);
        $fecha = date_format($date, "D j, F Y H:i:s");
        $datos = [
            "Usuario"     => urldecode($row->usuario),
            "Cliente"     => urldecode($row->cliente),
            "Producto Id" => urldecode($row->idproducto),
            "Precio"      => $row->precio,
            "Direccion"   => urldecode($row->direccion),
            "Email"       => urldecode($row->email),
            "Cantidad"    => $row->cantidad,
            "Fecha"       => $fecha,
            "Producto"    => urldecode($row->producto)
        ];

        $datos2[] = $datos;
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
} finally {
    cerrarBD($conexion);
}

class PDF extends FPDF {

// Cabecera de página
    function Header() {
        // Logo
        $this->Image('../assets/images/Logo.png', 140, -15, 150);
        //Salto
        $this->Ln(8);
    }

// Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Gracias por su compra', 0, 0, 'C');
    }

    function TablaSimple($datos) {

        foreach ($datos[0] as $key => $value1) {
            if ($key === 'Producto Id' || $key === 'Precio' || $key === 'Producto' || $key === 'Cantidad') {
                continue;
            }
            $this->SetFont('Times', 'B', 11);
            $this->Cell(40, 5, $key, 0);
            $this->SetFont('Times', '', 13);
            $this->Cell(40, 5, $value1, 0);
            $this->Ln();
        }
    }

    function TablaColores($datos) {
//Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
//Cabecera
        $codigos = array_keys($datos[0]);
        $this->SetX(30);
        $this->Cell(30, 7, $codigos[2], 1, 0, 'C', 1);
        $this->Cell(80, 7, $codigos[8], 1, 0, 'C', 1);
        $this->Cell(40, 7, $codigos[6], 1, 0, 'C', 1);
        $this->Cell(20, 7, $codigos[3], 1, 0, 'C', 1);
        $this->Cell(20, 7, "Total", 1, 0, 'C', 1);
        $this->Ln();
//Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
//Datos
        $total   = 0;
        for ($i = 0; $i < count($datos); $i++) {
            $fill = false;
            if ($i % 2 == 0) {
                $fill = true;
            }
            $this->SetX(30);
            $this->Cell(30, 6, $datos[$i]["Producto Id"], 'LR', 0, 'L', $fill);
            $this->Cell(80, 6, utf8_decode($datos[$i]["Producto"]), 'LR', 0, 'L', $fill);
            $this->Cell(40, 6, $datos[$i]["Cantidad"], 'LR', 0, 'R', $fill);
            $this->Cell(20, 6, $datos[$i]["Precio"] . EURO, 'LR', 0, 'R', $fill);
            $this->Cell(20, 6, $datos[$i]["Cantidad"] * $datos[$i]["Precio"] . EURO, 'LR', 0, 'R', $fill);
            $this->Ln();
            $total += $datos[$i]["Cantidad"] * $datos[$i]["Precio"];
        }
        $this->SetX(30);
        $this->Cell(190, 0, '', 'T');
        $this->Ln(15);
        //Mover posicion al final de página
        
        $this->SetX(200);
        //CAmbiar colores y fuente
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        //Mostrar texto        
        $this->Cell(40, 8, "Precio Total", 1, 2, 'C',1);
        //Restaurar colores y texto
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        //Mostrar línea
        $this->Cell(40, 8, $total . EURO, 1, 0, 'C', 1);

      
    }

}

// Creación del objeto de la clase heredada
$header = array('Columna 1', 'Columna 2', 'Columna 3', 'Columna 4', '');
$pdf    = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 18);
$pdf->Cell(75, 6, "Factura id " . $id, 0, 0, 'R');
$pdf->SetFont('Times', '', 13);
$pdf->Ln(10);
$pdf->TablaSimple($datos2);
$pdf->Ln(20);
$pdf->TablaColores($datos2);

$pdf->Output();
?>