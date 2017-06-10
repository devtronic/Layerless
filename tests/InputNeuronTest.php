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

use Devtronic\Layerless\InputNeuron;
use Devtronic\Layerless\Neuron;
use PHPUnit\Framework\TestCase;

/**
 * Test for InputNeuron
 * @package Devtronic\Tests\Layerless
 */
class InputNeuronTest extends TestCase
{
    public function testConstruct()
    {
        $this->assertTrue(class_exists(InputNeuron::class));

        $neuron = new InputNeuron(2.32);
        $this->assertTrue($neuron instanceof Neuron);
        $this->assertTrue($neuron instanceof InputNeuron);
        $this->assertSame(2.32, $neuron->getOutput());
        $this->assertNull($neuron->getActivator());
    }

    public function testActivate()
    {
        $neuron = new InputNeuron(1.44);
        $this->assertSame(1.44, $neuron->getOutput());
        $neuron->activate();
        $this->assertSame(1.44, $neuron->getOutput());
    }
}
