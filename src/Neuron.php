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

use Devtronic\Layerless\Activator\ActivatorInterface;

/**
 * Represents a neuron
 * @package Devtronic\Layerless
 */
class Neuron
{
    /** @var Synapse[] */
    protected $synapsesIn = [];

    /** @var Synapse[] */
    protected $synapsesOut = [];

    /** @var ActivatorInterface */
    protected $activator = null;

    /** @var float */
    protected $output = 0.00;

    /** @var float */
    protected $delta = 0.00;

    /**
     * Neuron constructor.
     * @param float $output The Neuron Output
     * @param ActivatorInterface|null $activator The activator
     */
    public function __construct(ActivatorInterface $activator = null, $output = 0.0)
    {
        $this->activator = $activator;
        $this->output = $output;
    }

    /**
     * Activates the Neuron
     */
    public function activate()
    {
        $sum = 0.00;

        foreach ($this->synapsesIn as $synapse) {
            $sum += $synapse->getWeight() * $synapse->getNeuronA()->getOutput();
        }

        $this->output = $sum;
        if ($this->activator instanceof ActivatorInterface) {
            $this->output = $this->activator->activate($this->output);
        }
    }

    /**
     * Calculates the error delta
     * @param null|float $target The target value if the neuron is an output neuron
     */
    public function calculateDelta($target = null)
    {
        $deltaJ = $this->output;
        if ($this->activator instanceof ActivatorInterface) {
            $deltaJ = $this->activator->activateDerivative($deltaJ);
        }

        $error = 0.00;
        // Output Neuron
        if ($target !== null && count($this->synapsesOut) == 0) {
            $error = $target - $this->output;
        } // Hidden Neuron
        elseif ($target === null && count($this->synapsesOut) > 0) {
            $error = 0.0;
            foreach ($this->synapsesOut as $synapse) {
                $error += ($synapse->getNeuronB()->getDelta() * $synapse->getWeight());
            }
        }
        $deltaJ = $deltaJ * $error;
        $this->delta = $deltaJ;
    }

    /**
     * Change the synapse weights
     * @param float $learningRate The learning rate
     */
    public function updateWeights($learningRate = 1.00)
    {
        $deltaJ = $this->delta;
        foreach ($this->synapsesIn as $synapse) {
            $change = $learningRate * $deltaJ * $synapse->getNeuronA()->getOutput();
            $newWeight = $synapse->getWeight() + $change;
            $synapse->setWeight($newWeight);
        }
    }

    /**
     * @return Synapse[]
     */
    public function getSynapsesIn()
    {
        return $this->synapsesIn;
    }

    /**
     * Adds an incoming synapse
     * @param Synapse $synapse The Synapse
     * @return Neuron
     */
    public function addSynapseIn(Synapse $synapse)
    {
        $this->synapsesIn[] = $synapse;
        return $this;
    }

    /**
     * @return Synapse[]
     */
    public function getSynapsesOut()
    {
        return $this->synapsesOut;
    }

    /**
     * Adds an outgoing synapse
     * @param Synapse $synapse The Synapse
     * @return Neuron
     */
    public function addSynapseOut(Synapse $synapse)
    {
        $this->synapsesOut[] = $synapse;
        return $this;
    }

    /**
     * @return ActivatorInterface
     */
    public function getActivator()
    {
        return $this->activator;
    }

    /**
     * @param ActivatorInterface $activator
     * @return Neuron
     */
    public function setActivator($activator)
    {
        $this->activator = $activator;
        return $this;
    }

    /**
     * @return float
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param float $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * @return float
     */
    public function getDelta()
    {
        return $this->delta;
    }

    /**
     * @param float $delta
     * @return Neuron
     */
    public function setDelta($delta)
    {
        $this->delta = $delta;
        return $this;
    }
}