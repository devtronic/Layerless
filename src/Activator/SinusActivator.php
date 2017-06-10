<?php
/**
 * This file is part of the Devtronic Layerless package.
 *
 * (c) Julian Finkler <julian@developer-heaven.de>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Devtronic\Layerless\Activator;

/**
 * SinusActivator
 * @package Devtronic\Layerless\Activator
 */
class SinusActivator implements ActivatorInterface
{
    /** @inheritdoc */
    function activate($raw)
    {
        return round(sin($raw), 5);
    }

    /** @inheritdoc */
    function activateDerivative($raw)
    {
        return round(cos($raw), 5);
    }
}