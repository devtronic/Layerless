<?php
/**
 * This file is part of the Devtronic Layerless package.
 *
 * (c) Julian Finkler <julian@developer-heaven.de>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Devtronic\Tests\Layerless\Activator;

use Devtronic\Layerless\Activator\ActivatorInterface;
use Devtronic\Layerless\Activator\SigmoidActivator;
use PHPUnit\Framework\TestCase;

/**
 * Test for SigmoidActivator
 * @package Devtronic\Tests\Layerless\Activator
 */
class SigmoidActivatorTest extends TestCase
{
    public function testConstruct()
    {
        $activator = new SigmoidActivator();
        $this->assertTrue($activator instanceof ActivatorInterface);
        $this->assertTrue($activator instanceof SigmoidActivator);
    }

    public function testActivate()
    {
        $activator = new SigmoidActivator();
        $this->assertSame(0.73106, round($activator->activate(1), 5));
        $this->assertSame(0.54983, round($activator->activate(0.2), 5));
    }

    public function testActivateDerivative()
    {
        $activator = new SigmoidActivator();
        $this->assertSame(0.24700, round($activator->activateDerivative(0.22), 5));
        $this->assertSame(0.17502, round($activator->activateDerivative(1.23), 5));
    }
}
