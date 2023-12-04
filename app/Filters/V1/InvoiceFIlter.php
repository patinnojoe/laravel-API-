<?php


namespace App\Filters\V1;

use App\Filters\ApiFilter;

class InvoiceFilter extends ApiFilter
{
    protected $safeParams = [
        'customerId' => ['eq'],
        'ammount' => ['eq'],
        'status' => ['eq', 'ne'],
        'billedDate' => ['eq', 'lte', 'gte', 'lt', 'gt'],
        'paidDate' => ['eq', 'lte', 'gte', 'lt', 'gt'],

    ];

    // map postal code to the postal code  column
    protected $columnMap = [
        'postalCode' => 'postal_code'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'gt' => '>',
        'gte' => '≥',
        'lte' => '≤',
        'ne' => '!='
    ];
}
