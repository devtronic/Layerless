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
 * SigmoidActivator
 * @package Devtronic\Layerless\Activator
 */
class SigmoidActivator implements ActivatorInterface
{
    /** @inheritdoc */
    function activate($raw)
    {
        return 1 / (1 + exp(-$raw));
    }

    /** @inheritdoc */
    function activateDerivative($raw)
    {
        $exp = 1 / (1 + exp(-$raw));
        return $exp * (1 - $exp);
    }
}