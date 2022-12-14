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

class GenderType extends AbstractFor
{
    protected static $forstatus = [
        '0' => 'gender_type',
        '1' => 'Male',
        '2' => 'Female',
        '3' => 'Other',
    ];
}