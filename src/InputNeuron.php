<?php
/**
 * This file is part of the Devtronic Layerless package.
 *
 * (c) Julian Finkler <julian@developer-heaven.de>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Devtronic\Layerless;

/**
 * Represents an input neuron
 * @package Devtronic\Layerless
 */
class InputNeuron extends Neuron
{
    /**
     * InputNeuron constructor.
     * @param float $output The Output of the neuron
     */
    public function __construct($output)
    {
        parent::__construct(null, $output);
    }

    /** @inheritdoc */
    public function activate()
    {
        // Only override, output is always constant
    }
}