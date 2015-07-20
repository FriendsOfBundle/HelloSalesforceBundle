<?php

namespace Hgtan\Bundle\HelloSalesforceBundle\Formatter;

/**
 * Interface for formatters
 *
 */

interface FormatterInterface
{
    /**
     * Formats a salesforce record.
     *
     * @param  array $record A record to format
     * @return mixed The formatted record
     */
    public function format();
}