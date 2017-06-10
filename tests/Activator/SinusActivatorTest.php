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
use Devtronic\Layerless\Activator\SinusActivator;
use PHPUnit\Framework\TestCase;

/**
 * Test for SinusActivator
 * @package Devtronic\Tests\Layerless\Activator
 */
class SinusActivatorTest extends TestCase
{
    public function testConstruct()
    {
        $activator = new SinusActivator();
        $this->assertTrue($activator instanceof ActivatorInterface);
        $this->assertTrue($activator instanceof SinusActivator);
    }

    public function testActivate()
    {
        $activator = new SinusActivator();
        $this->assertSame(0.84147, round($activator->activate(1), 5));
        $this->assertSame(0.19867, round($activator->activate(0.2), 5));
    }

    public function testActivateDerivative()
    {
        $activator = new SinusActivator();

        $this->assertSame(0.97590, round($activator->activateDerivative(0.22), 5));
        $this->assertSame(0.33424, round($activator->activateDerivative(1.23), 5));
    }
}
