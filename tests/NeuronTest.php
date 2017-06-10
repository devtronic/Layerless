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

use Devtronic\Layerless\Activator\ActivatorInterface;
use Devtronic\Layerless\InputNeuron;
use Devtronic\Layerless\Neuron;
use Devtronic\Layerless\Synapse;
use PHPUnit\Framework\TestCase;

/**
 * Test for Neuron
 * @package Devtronic\Tests\Layerless
 */
class NeuronTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertTrue(class_exists(Neuron::class));

        $neuron = new Neuron();
        $this->assertTrue($neuron instanceof Neuron);
    }

    public function testGetAddSynapseIn()
    {
        $neuron = new Neuron();

        $this->assertCount(0, $neuron->getSynapsesIn());

        $synapse = $this->createMock(Synapse::class);
        $neuron->addSynapseIn($synapse);

        $synapses = $neuron->getSynapsesIn();
        $this->assertCount(1, $synapses);
        $this->assertSame($synapse, reset($synapses));
    }

    public function testGetAddSynapseOut()
    {
        $neuron = new Neuron();

        $this->assertCount(0, $neuron->getSynapsesOut());

        $synapse = $this->createMock(Synapse::class);
        $neuron->addSynapseOut($synapse);

        $synapses = $neuron->getSynapsesOut();
        $this->assertCount(1, $synapses);
        $this->assertSame($synapse, reset($synapses));
    }

    public function testGetSetActivator()
    {
        $neuron = new Neuron();
        $this->assertNull($neuron->getActivator());

        $activator = $this->createMock(ActivatorInterface::class);
        $activator->method('activate');
        $activator->method('activateDerivative');

        $neuron->setActivator($activator);
        $this->assertSame($activator, $neuron->getActivator());
    }

    public function testGetSetDelta()
    {
        $neuron = new Neuron();
        $this->assertSame(0.00, $neuron->getDelta());
        $neuron->setDelta(-0.331);
        $this->assertSame(-0.331, $neuron->getDelta());
    }

    public function testActivateSimple()
    {
        $neuron = new Neuron();
        $neuron->activate();

        $this->assertSame(0.00, $neuron->getOutput());

        $neuron->setOutput(1.00);
        $this->assertSame(1.00, $neuron->getOutput());
    }

    public function testActivateWithSynapses()
    {
        $neuronA = $this->createMock(InputNeuron::class);
        $neuronA->method('getOutput')->willReturn(1.00);

        $neuronB = $this->createMock(InputNeuron::class);
        $neuronB->method('getOutput')->willReturn(1.00);

        $neuronC = new Neuron();

        $synapse1 = $this->createMock(Synapse::class);
        $synapse1->method('getNeuronA')->willReturn($neuronA);
        $synapse1->method('getNeuronB')->willReturn($neuronC);
        $synapse1->method('getWeight')->willReturn(1.00);

        $synapse2 = $this->createMock(Synapse::class);
        $synapse2->method('getNeuronA')->willReturn($neuronB);
        $synapse2->method('getNeuronB')->willReturn($neuronC);
        $synapse2->method('getWeight')->willReturn(1.00);

        $neuronC->addSynapseIn($synapse1)->addSynapseIn($synapse2);

        $neuronA->activate();
        $neuronB->activate();
        $neuronC->activate();

        $this->assertEquals(2.00, $neuronC->getOutput());
    }

    public function testActivateWithActivatorAndSynapses()
    {
        $activator = $this->createMock(ActivatorInterface::class);
        $activator->method('activate')->willReturnCallback(function ($x) {
            return $x / 2;
        });

        $neuronIn = $this->createMock(InputNeuron::class);
        $neuronIn->method('getOutput')->willReturn(0.50);

        $neuronOut = new Neuron($activator);

        $synapse = $this->createMock(Synapse::class);
        $synapse->method('getNeuronA')->willReturn($neuronIn);
        $synapse->method('getNeuronB')->willReturn($neuronOut);
        $synapse->method('getWeight')->willReturn(1.00);

        $neuronOut->addSynapseIn($synapse);

        $neuronIn->activate();

        $this->assertSame(0.00, $neuronOut->getOutput());
        $neuronOut->activate();
        $this->assertSame(0.25, $neuronOut->getOutput());
    }

    public function testCalculateDeltaOnOutputNeuron()
    {
        $activator = $this->createMock(ActivatorInterface::class);
        $activator->method('activate')->willReturnCallback(function ($x) {
            return $x / 2;
        });
        $activator->method('activateDerivative')->willReturnCallback(function ($x) {
            return $x * 2;
        });

        $neuronIn = $this->createMock(InputNeuron::class);
        $neuronIn->method('getOutput')->willReturn(1);

        $neuronOut = new Neuron($activator);


        $synapse = $this->createMock(Synapse::class);
        $synapse->method('getNeuronA')->willReturn($neuronIn);
        $synapse->method('getNeuronB')->willReturn($neuronOut);
        $synapse->method('getWeight')->willReturn(1.00);
        $neuronOut->addSynapseIn($synapse);
        $neuronIn->activate();

        $neuronOut->activate();

        $this->assertSame(0.00, $neuronOut->getDelta());
        $neuronOut->calculateDelta(0);
        $this->assertSame(-0.50, $neuronOut->getDelta());
    }

    public function testCalculateDeltaHiddenNeuron()
    {
        $activator = $this->createMock(ActivatorInterface::class);
        $activator->method('activate')->willReturnCallback(function ($x) {
            return $x / 2;
        });
        $activator->method('activateDerivative')->willReturnCallback(function ($x) {
            return $x * 2;
        });

        $neuronIn = $this->createMock(InputNeuron::class);
        $neuronIn->method('getOutput')->willReturn(1);

        $neuronHidden = new Neuron($activator);
        $neuronOut = new Neuron($activator);

        $synapse1 = $this->createMock(Synapse::class);
        $synapse1->method('getNeuronA')->willReturn($neuronIn);
        $synapse1->method('getNeuronB')->willReturn($neuronHidden);
        $synapse1->method('getWeight')->willReturn(1.00);
        $neuronIn->addSynapseOut($synapse1);
        $neuronHidden->addSynapseIn($synapse1);

        $synapse2 = $this->createMock(Synapse::class);
        $synapse2->method('getNeuronA')->willReturn($neuronHidden);
        $synapse2->method('getNeuronB')->willReturn($neuronOut);
        $synapse2->method('getWeight')->willReturn(1.00);
        $neuronHidden->addSynapseOut($synapse2);
        $neuronOut->addSynapseIn($synapse2);

        $neuronIn->activate();
        $neuronHidden->activate();
        $neuronOut->activate();

        $neuronOut->calculateDelta(0);
        $this->assertSame(0.00, $neuronHidden->getDelta());
        $neuronHidden->calculateDelta();
        $this->assertSame(-0.125, $neuronHidden->getDelta());
    }

    public function testUpdateWeights()
    {
        $activator = $this->createMock(ActivatorInterface::class);
        $activator->method('activate')->willReturnCallback(function ($x) {
            return $x / 2;
        });
        $activator->method('activateDerivative')->willReturnCallback(function ($x) {
            return $x * 2;
        });

        $neuronIn = $this->createMock(InputNeuron::class);
        $neuronIn->method('getOutput')->willReturn(1);

        $neuronOut = new Neuron($activator);


        $synapse = $this->createMock(Synapse::class);
        $synapse->method('getNeuronA')->willReturn($neuronIn);
        $synapse->method('getNeuronB')->willReturn($neuronOut);
        $weight = 1.00;
        $synapse->method('getWeight')->willReturnCallback(function () use (&$weight) {
            return $weight;
        });
        $synapse->method('setWeight')->willReturnCallback(function ($newWeight) use (&$weight) {
            $weight = $newWeight;
        });
        $neuronIn->addSynapseout($synapse);
        $neuronOut->addSynapseIn($synapse);

        $neuronOut->activate();
        $neuronOut->calculateDelta(0);
        $neuronIn->calculateDelta();
        $oldWeight = $synapse->getWeight();
        $neuronOut->updateWeights(1);
        $this->assertLessThan($oldWeight, $synapse->getWeight());
        $this->assertSame(0.5, $synapse->getWeight());
    }
}