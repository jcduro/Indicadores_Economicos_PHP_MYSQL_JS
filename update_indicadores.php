

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
  <title>Selector de Colores - Camiseta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Font Awesome para iconos (si no lo tienes ya en el layout) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
   <link rel="stylesheet" href="css/chart.css"/>


</head>
<body>


 <main>

<?php


// CONFIGURACIÓN - PEGA TU KEY AQUÍ
define('EXCHANGE_RATE_KEY', '###'); // ← ¡¡¡REGÍSTRATE Y PON TU KEY REAL!!!

function actualizarIndicador(PDO $pdo, string $codigo, float $valor, string $fecha = null) {
    if ($valor <= 0) {
        echo "⚠️ $codigo: Valor inválido ($valor)<br>";
        return false;
    }
    
    // Verificar que el código existe
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM indicadores WHERE codigo = ?");
    $stmt->execute([$codigo]);
    if ($stmt->fetchColumn() == 0) {
        echo "❌ $codigo: NO EXISTE en BD<br>";
        return false;
    }
    
    if ($fecha === null) $fecha = date('Y-m-d');
    
    try {
        $stmt = $pdo->prepare("UPDATE indicadores SET valor = ?, fecha = ? WHERE codigo = ?");
        $stmt->execute([$valor, $fecha, $codigo]);
        
        $filas = $stmt->rowCount();
        if ($filas > 0) {
            echo "✅ $codigo: ACTUALIZADO a " . number_format($valor, 2) . "<br>";
        } else {
            echo "⚠️ $codigo: Sin cambios (ya era $valor)<br>";
        }
        return true;
    } catch (Exception $e) {
        echo "❌ $codigo: ERROR BD - " . $e->getMessage() . "<br>";
        return false;
    }
}

echo "<h3>ACTUALIZANDO INDICADORES CON APIS GRATIS...</h3>";
echo "<pre>";

// === USD/COP (EXCHANGERATE-API - TU FUENTE PRINCIPAL) ===
echo "\n--- USD/COP (ExchangeRate-API) ---\n";
try {
    if (EXCHANGE_RATE_KEY === 'TU_KEY_AQUI') {
        throw new Exception("❌ NO HAS CONFIGURADO TU API KEY");
    }
    
    $json = @file_get_contents(
        "https://v6.exchangerate-api.com/v6/" . EXCHANGE_RATE_KEY . "/latest/USD",
        false,
        stream_context_create(['http' => ['timeout' => 15]])
    );
    
    if ($json === FALSE) {
        throw new Exception("API no responde");
    }
    
    $data = json_decode($json, true);
    
    // VERIFICAR QUE TENEMOS COP
    if (empty($data['conversion_rates']['COP'])) {
        throw new Exception("COP no está en las tasas: " . print_r($data['conversion_rates'], true));
    }
    
    $valor = (float)$data['conversion_rates']['COP'];
    actualizarIndicador($pdo, 'USD_COP', $valor, $data['time_last_update_utc'] ?? date('Y-m-d'));
    
} catch (Exception $e) {
    echo "❌ USD/COP: " . $e->getMessage() . "\n";
    echo "⚠️ Usando respaldo de 4000\n";
    actualizarIndicador($pdo, 'USD_COP', 4000, date('Y-m-d'));
}

// === EUR/COP (EXCHANGERATE-API - EUR a COP) ===
echo "\n--- EUR/COP ---\n";
try {
    $json = @file_get_contents(
        "https://v6.exchangerate-api.com/v6/" . EXCHANGE_RATE_KEY . "/latest/EUR",
        false,
        stream_context_create(['http' => ['timeout' => 15]])
    );
    
    if ($json) {
        $data = json_decode($json, true);
        if (!empty($data['conversion_rates']['COP'])) {
            actualizarIndicador($pdo, 'EUR_COP', (float)$data['conversion_rates']['COP'], $data['time_last_update_utc'] ?? date('Y-m-d'));
        }
    }
} catch (Exception $e) {
    echo "❌ EUR/COP: " . $e->getMessage() . "\n";
}

// === BTC_USD (COINGECKO) ===
echo "\n--- BTC_USD ---\n";
try {
    $context = stream_context_create(['http' => ['timeout' => 15, 'header' => 'User-Agent: MiApp/1.0']]);
    $json = @file_get_contents('https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=usd', false, $context);
    
    if ($json) {
        $data = json_decode($json, true);
        if (!empty($data['bitcoin']['usd'])) {
            actualizarIndicador($pdo, 'BTC_USD', (float)$data['bitcoin']['usd'], date('Y-m-d'));
        }
    }
} catch (Exception $e) {
    echo "❌ BTC_USD: " . $e->getMessage() . "\n";
    actualizarIndicador($pdo, 'BTC_USD', 45000, date('Y-m-d'));
}

// === ORO_USD Y BRENT_USD - Respaldos ===
echo "\n--- ORO_USD ---\n";
actualizarIndicador($pdo, 'ORO_USD', 2000, date('Y-m-d'));

echo "\n--- BRENT_USD ---\n";
actualizarIndicador($pdo, 'BRENT_USD', 85, date('Y-m-d'));

echo "</pre>";
echo "<h4>✅ PROCESO TERMINADO</h4>";

 ?>

                </main>




