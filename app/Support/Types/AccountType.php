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

class AccountType extends AbstractFor
{
    protected static $forstatus = [
        '0' => 'account_type',
        '1' => 'Current Account',
        '2' => 'Savings Account',
    ];
}