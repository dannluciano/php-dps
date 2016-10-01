<?php

require_once 'libs/KLogger.php';

$logger = new KLogger(__DIR__.'/logs', KLogger::DEBUG);

$logger->logInfo('Iniciando Interpretação do Script');

$logger->logInfo('Info');
$logger->logNotice('Notice');
$logger->logWarn('Warning');
$logger->logError('Error');
$logger->logFatal('Fatal');
$logger->logAlert('Alert');
$logger->logDebug('Debug');
$logger->logCrit('Critico');
$logger->logEmerg('Emerge');

?>

<h1>Hello World</h1>

<?php

$logger->logInfo('Finalizando Interpretação do Script');

?>
