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

class RelationshipType extends AbstractFor
{
    protected static $forstatus = [
        '0' => 'relationship_type',
        '1' => 'Father',
        '2' => 'Mother',
        '3' => 'Brother',
        '4' => 'Sister',
        '5' => 'Uncle',
        '6' => 'Aunt',
        '7' => 'Grand Father',
        '8' => 'Grand Mother',
        '9' => 'Room Mate',
        '10' => 'Friend',
        '11' => 'Other',
    ];
}