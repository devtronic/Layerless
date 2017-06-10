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
 * Represents a synapse
 * @package Devtronic\Layerless
 */
class Synapse
{
    /** @var Neuron */
    protected $neuronA = null;

    /** @var Neuron */
    protected $neuronB = null;

    /** @var float */
    protected $weight;

    /**
     * Synapse constructor.
     *
     * @param float $weight The Synapse weight
     * @param Neuron|null $neuronA From-Neuron
     * @param Neuron|null $neuronB To-Neuron
     */
    public function __construct($weight = 0.00, Neuron $neuronA = null, Neuron $neuronB = null)
    {
        $this->weight = $weight;
        if (null !== $neuronA) {
            $this->setNeuronA($neuronA);
        }
        if (null !== $neuronB) {
            $this->setNeuronB($neuronB);
        }
    }

    /**
     * @return Neuron
     */
    public function getNeuronA()
    {
        return $this->neuronA;
    }

    /**
     * @param Neuron $neuronA
     * @return Synapse
     */
    public function setNeuronA($neuronA)
    {
        $neuronA->addSynapseOut($this);
        $this->neuronA = $neuronA;
        return $this;
    }

    /**
     * @return Neuron
     */
    public function getNeuronB()
    {
        return $this->neuronB;
    }

    /**
     * @param Neuron $neuronB
     * @return Synapse
     */
    public function setNeuronB($neuronB)
    {
        $neuronB->addSynapseIn($this);
        $this->neuronB = $neuronB;
        return $this;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     * @return Synapse
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }
}