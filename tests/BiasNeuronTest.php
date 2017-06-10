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

use Devtronic\Layerless\BiasNeuron;
use Devtronic\Layerless\Neuron;
use PHPUnit\Framework\TestCase;

/**
 * Test for BiasNeuron
 * @package Devtronic\Tests\Layerless
 */
class BiasNeuronTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertTrue(class_exists(BiasNeuron::class));

        $neuron = new BiasNeuron(3.22);
        $this->assertTrue($neuron instanceof Neuron);
        $this->assertTrue($neuron instanceof BiasNeuron);
        $this->assertSame(3.22, $neuron->getOutput());
        $this->assertNull($neuron->getActivator());
    }

    public function testActivate()
    {
        $neuron = new BiasNeuron(3.22);
        $this->assertSame(3.22, $neuron->getOutput());
        $neuron->activate();
        $this->assertSame(3.22, $neuron->getOutput());
    }
}