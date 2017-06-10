[![GitHub tag](https://img.shields.io/packagist/v/devtronic/layerless.svg)](https://github.com/Devtronic/layerless)
[![Packagist](https://img.shields.io/packagist/l/Devtronic/layerless.svg)](https://github.com/Devtronic/layerless/blob/master/LICENSE)
[![Travis](https://img.shields.io/travis/Devtronic/Layerless.svg)](https://travis-ci.org/Devtronic/layerless/)
[![Packagist](https://img.shields.io/packagist/dt/Devtronic/layerless.svg)](https://github.com/Devtronic/layerless)

# Layerless

Layerless is the new foundation of the [legendary mind](https://github.com/Devtronic/legendary-mind) neural network project

## Installation
```bash
composer require devtronic/layerless
```

## Usage
```php
<?php

// Import the SinusActivator as Activator
use Devtronic\Layerless\Activator\SinusActivator as Activator;
use Devtronic\Layerless\BiasNeuron;
use Devtronic\Layerless\InputNeuron;
use Devtronic\Layerless\Neuron;
use Devtronic\Layerless\Synapse;

// Load Composer autoload
require_once __DIR__ . '/vendor/autoload.php';

// Create the activator
$activator = new Activator();

// Create 2 Input Neurons and 1 Bias Neuron
$inputA = new InputNeuron(1);
$inputB = new InputNeuron(0);
$bias = new BiasNeuron(1);

// Create 1 Output Neuron
$output = new Neuron($activator);

// Connect the neurons

new Synapse(0.90, $inputA, $output);
new Synapse(0.23, $inputB, $output);
new Synapse(0.50, $bias, $output);

// Activate the neurons
$inputA->activate();
$inputB->activate();
$output->activate();

echo $output->getOutput() . PHP_EOL; // 0.98545

// Back propagate
$target = 0;
$output->calculateDelta($target);
$inputA->calculateDelta();
$inputB->calculateDelta();

$learningRate = 0.2;
$output->updateWeights($learningRate);
$inputA->updateWeights($learningRate);
$inputB->updateWeights($learningRate);

// Re-Check
$inputA->activate();
$inputB->activate();
$output->activate();

echo $output->getOutput() . PHP_EOL; // 0.92545
```
