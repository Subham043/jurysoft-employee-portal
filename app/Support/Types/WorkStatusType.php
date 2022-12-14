<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Support\Types;

class WorkStatusType extends AbstractFor
{
    protected static $forstatus = [
        '0' => 'work_status_type',
        '1' => 'Working',
        '2' => 'Resigned',
    ];
}