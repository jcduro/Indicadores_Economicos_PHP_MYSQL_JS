<?php
require_once __DIR__ . "/conexion.php"; 

$stmt = $pdo->query("
  SELECT codigo, nombre, valor, unidad, fecha
  FROM indicadores
");
header('Content-Type: application/json');
echo json_encode($stmt->fetchAll());
