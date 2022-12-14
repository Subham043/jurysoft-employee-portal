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

class BloodType extends AbstractFor
{
    protected static $forstatus = [
        '0' => 'blood_type',
        '1' => 'A+',
        '2' => 'A-',
        '3' => 'B+',
        '4' => 'B-',
        '5' => 'AB+',
        '6' => 'AB-',
        '7' => 'O+',
        '8' => 'O-',
    ];
}