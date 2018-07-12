<?php
require_once __DIR__ . '/vendor/autoload.php';

use \FeeCalculator\Reader\CsvReader;
use \FeeCalculator\Rate\Manager\RateManager;
use \FeeCalculator\Transaction\Factory\StrategyFactory;
use \FeeCalculator\Currency\Manager\RoundManager;
use \FeeCalculator\Calculator\Manager\CalculatorManager;
use \FeeCalculator\Calculator\Manager\StrategyManager;

$reader = new CsvReader($argv[1]);

$rates = [
    'EUR' => [
        'USD' => 1.1497,
        'JPY' => 129.53,
    ],
    'JPY' => [
        'EUR' => 0.0077,
        'USD' => 0.0066,
    ],
    'USD' => [
        'EUR' => 0.8697,
        'JPY' => 112.6522,
    ],
];
$rateManager = new RateManager($rates);

$strategyFactory = new StrategyFactory();
$strategyManager = new StrategyManager($strategyFactory);

$roundManager = new RoundManager([
    'EUR' => 0.01,
    'JPY' => 1, //smallest bill of Japan yen is 1 yen, they don't have cents
    'USD' => 0.01,
]);

$calculatorManager = new CalculatorManager($rateManager, $strategyManager, $roundManager);

$result = $calculatorManager->calculate($reader);

foreach ($result as $sum) {
    echo $sum, PHP_EOL;
}
