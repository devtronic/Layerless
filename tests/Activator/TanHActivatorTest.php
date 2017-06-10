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
use Devtronic\Layerless\Activator\TanHActivator;
use PHPUnit\Framework\TestCase;

/**
 * Test for SinusActivator
 * @package Devtronic\Tests\Layerless\Activator
 */
class TanHActivatorTest extends TestCase
{
    public function testConstruct()
    {
        $activator = new TanHActivator();
        $this->assertTrue($activator instanceof ActivatorInterface);
        $this->assertTrue($activator instanceof TanHActivator);
    }

    public function testActivate()
    {
        $activator = new TanHActivator();
        $this->assertSame(0.76159, round($activator->activate(1), 5));
        $this->assertSame(0.19738, round($activator->activate(0.2), 5));
    }

    public function testActivateDerivative()
    {
        $activator = new TanHActivator();
        $this->assertSame(0.95312, round($activator->activateDerivative(0.22), 5));
        $this->assertSame(0.29006, round($activator->activateDerivative(1.23), 5));
    }
}
