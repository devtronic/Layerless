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
 * HTanActivator
 * @package Devtronic\Layerless\Activator
 */
class TanHActivator implements ActivatorInterface
{
    /** @inheritdoc */
    function activate($raw)
    {
        $exp = exp(2 * $raw);
        return ($exp - 1) / ($exp + 1);
    }

    /** @inheritdoc */
    function activateDerivative($raw)
    {
        return 1 - pow((exp(2 * $raw) - 1) / (exp(2 * $raw) + 1), 2);
    }
}