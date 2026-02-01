
 <!-- Welcome to
  
     |  ___|  __ \  |   |  _ \   _ \   
     | |      |   | |   | |   | |   |  
 \   | |      |   | |   | __ <  |   |  
\___/ \____| ____/ \___/ _| \_\\___/   
                                       
  ___|  _ \  __ \  ____|    _ )   _ _| __ \  ____|    \     ___|  
 |     |   | |   | __|     _ \ \   |  |   | __|     _ \  \___ \  
 |     |   | |   | |      ( `  <   |  |   | |      ___ \       | 
\____|\___/ ____/ _____| \___/\/ ___|____/ _____|_/    _\_____/  

  https://jcduro.bexartideas.com/index.php | 2026 | JC Duro Code & Ideas

------------------------------------------------------------------------------- -->



<?php
// Incluir tu conexión PDO
require_once __DIR__ . '/conexion.php'; // AJUSTA ESTA RUTA

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Indicadores - Economicos </title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Font Awesome para iconos (si no lo tienes ya en el layout) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
   <link rel="stylesheet" href="css/chart.css"/>


</head>
<body>


              <main>
    <?php            
$stmt = $pdo->query("
  SELECT codigo, nombre, valor, unidad, fecha 
  FROM indicadores 
  ORDER BY FIELD(
    codigo,
    'USD_COP','EUR_COP','ORO_USD','BRENT_USD',
    'BTC_USD','SP500_USD','NASDAQ_USD','FED_RATE'
  )
");
$indicadores = $stmt->fetchAll();
?>
<div class="row g-3">
  <?php foreach ($indicadores as $ind): 
    switch ($ind['codigo']) {
      case 'USD_COP':    $icon = 'fas fa-dollar-sign';  $bgAos = 'flip-left';  break;
      case 'EUR_COP':    $icon = 'fas fa-euro-sign';    $bgAos = 'flip-right'; break;
      case 'ORO_USD':    $icon = 'fas fa-coins';        $bgAos = 'flip-left';  break;
      case 'BRENT_USD':  $icon = 'fas fa-oil-can';      $bgAos = 'flip-right'; break;
      case 'BTC_USD':    $icon = 'fab fa-bitcoin';      $bgAos = 'flip-left';  break;
      case 'SP500_USD':  $icon = 'fas fa-chart-line';   $bgAos = 'flip-right'; break;
      case 'NASDAQ_USD': $icon = 'fas fa-chart-area';   $bgAos = 'flip-left';  break;
      case 'FED_RATE':   $icon = 'fas fa-percentage';   $bgAos = 'flip-right'; break;
      default:           $icon = 'fas fa-chart-line';   $bgAos = 'flip-left';
    }

    $valorFormateado = number_format($ind['valor'], 2, ',', '.');
    $fechaFmt = date('d/m/Y', strtotime($ind['fecha']));
  ?>
    <div class="col-sm-6 col-xl-3" data-aos="<?php echo $bgAos; ?>">
      <div class="neon-card" data-codigo="<?php echo htmlspecialchars($ind['codigo']); ?>">
        <i class="<?php echo $icon; ?> fa-3x neon-icon"></i>
        <div class="ms-3 text-end">
          <div class="neon-label">
            <?php echo htmlspecialchars($ind['nombre']); ?>
          </div>
          <div class="neon-value">
            <?php echo $valorFormateado . ' ' . htmlspecialchars($ind['unidad']); ?>
          </div>
          <div class="neon-date">
            al <?php echo $fechaFmt; ?>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>






                </main>


<script>
function refrescarIndicadores() {
  fetch('/get_indicadores.php')
    .then(r => r.json())
    .then(lista => {
      lista.forEach(ind => {
        const card = document.querySelector('.neon-card[data-codigo="'+ind.codigo+'"]');
        if (!card) return;
        card.querySelector('.neon-value').textContent =
          Number(ind.valor).toLocaleString('es-CO', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }) + ' ' + ind.unidad;
        card.querySelector('.neon-date').textContent =
          'al ' + new Date(ind.fecha).toLocaleDateString('es-CO');
      });
    })
    .catch(() => {});
}

refrescarIndicadores();
setInterval(refrescarIndicadores, 60000); // cada 60 segundos
</script>





<?php include __DIR__ . '/../templates/footer.php'; ?>
