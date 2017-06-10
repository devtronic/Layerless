<?php
/**
 * This file is part of the Devtronic Layerless package.
 *
 * (c) Julian Finkler <julian@developer-heaven.de>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Devtronic\Layerless\Activator;

/**
 * Interface for activator functions
 * @package Devtronic\Layerless\Activator
 */
interface ActivatorInterface
{
    /**
     * Neuron Activation Function
     *
     * @param float $raw Raw Neuron Output
     * @return float Activated Neuron Output
     */
    function activate($raw);

    /**
     * Derivative of activation Function
     *
     * @param float $raw Raw Neuron Output
     * @return float Activated Neuron Output
     */
    function activateDerivative($raw);
}