<?php
/**
 * This file is part of the Devtronic Layerless package.
 *
 * (c) Julian Finkler <julian@developer-heaven.de>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Devtronic\Tests\Layerless;

use Devtronic\Layerless\Neuron;
use Devtronic\Layerless\Synapse;
use PHPUnit\Framework\TestCase;

/**
 * Test for Synapse
 * @package Devtronic\Tests\Layerless
 */
class SynapseTest extends TestCase
{

    public function testConstructSimple()
    {
        $this->assertTrue(class_exists(Synapse::class));
        $synapse = new Synapse(1.33);
        $this->assertTrue($synapse instanceof Synapse);
        $this->assertSame(1.33, $synapse->getWeight());
        $this->assertNull($synapse->getNeuronA());
        $this->assertNull($synapse->getNeuronB());
    }

    public function testConstructWithNeurons()
    {
        $neuronA = $this->createMock(Neuron::class);
        $neuronA->method('addSynapseOut')->willReturnCallback(function (Synapse $synapse) {
            if (!isset($this->synapsesOut)) {
                $this->synapsesOut = [];
            }
            $this->synapsesOut[] = $synapse;
        });
        $neuronA->method('getSynapsesOut')->willReturnCallback(function () {
            if (!isset($this->synapsesOut)) {
                $this->synapsesOut = [];
            }
            return $this->synapsesOut;
        });
        $neuronB = $this->createMock(Neuron::class);
        $neuronB->method('addSynapseIn')->willReturnCallback(function (Synapse $synapse) {
            if (!isset($this->synapsesIn)) {
                $this->synapsesIn = [];
            }
            $this->synapsesIn[] = $synapse;
        });
        $neuronB->method('getSynapsesIn')->willReturnCallback(function () {
            if (!isset($this->synapsesIn)) {
                $this->synapsesIn = [];
            }
            return $this->synapsesIn;
        });

        $synapse = new Synapse(3.22, $neuronA, $neuronB);
        $this->assertTrue($synapse instanceof Synapse);

        $this->assertSame($neuronA, $synapse->getNeuronA());
        $this->assertSame($neuronB, $synapse->getNeuronB());

        $this->assertSame([$synapse], $neuronA->getSynapsesOut());
        $this->assertSame([$synapse], $neuronB->getSynapsesIn());
    }

    public function testGetSetWeight()
    {
        $synapse = new Synapse();

        $this->assertSame(0.00, $synapse->getWeight());
        $synapse->setWeight(2.44);
        $this->assertSame(2.44, $synapse->getWeight());
    }
}