<?php

namespace Hgtan\Bundle\HelloSalesforceBundle\Formatter;

/**
 * Class ObjectFormatter
 * @package Hgtan\Bundle\HelloSalesforceBundle\Formatter
 */

class ObjectFormatter implements FormatterInterface
{
    const SIMPLE_DATE = "Y-m-d H:i:s";

    protected $self = array();

    /**
     * @param
     */
    public function __construct()
    {
        $args = func_get_args();
        for( $i=0, $n=count($args); $i<$n; $i++ )
            $this->add($args[$i]);
    }

    public function __get( $name = null ) {
        return $this->self[$name];
    }

    public function add( $name = null, $enum = null ) {
        //throw new \InvalidArgumentException('Undefined property '.$name);
        $this->self[$name] = $enum;
    }

    /**
     * {@inheritdoc}
     */
    public function format()
    {
        return (object)$this->self;
    }

}