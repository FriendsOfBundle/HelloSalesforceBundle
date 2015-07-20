<?php

namespace Hgtan\Bundle\HelloSalesforceBundle\Formatter;

/**
 * Class AccountFormatter
 * @package Hgtan\Bundle\HelloSalesforceBundle\Formatter
 */

class AccountFormatter extends ObjectFormatter
{
    /**
     * Translates
     */
    private $describeSObject = array(

        /*
         * Account Standard Fields
         */
        'Id' => '',
        'IsDeleted' => '',
        'MasterRecordId' => '',
        'Name' => '',
        'Type' => '',
        'ParentId' => '',
        'BillingStreet' => '',
        'BillingCity' => '',
        'BillingState' => '',
        'BillingPostalCode' => '',
        'BillingCountry' => '',
        'BillingLatitude' => '',
        'BillingLongitude' => '',
        'BillingAddress' => '',
        'ShippingStreet' => '',
        'ShippingCity' => '',
        'ShippingState' => '',
        'ShippingPostalCode' => '',
        'ShippingCountry' => '',
        'ShippingLatitude' => '',
        'ShippingLongitude' => '',
        'ShippingAddress' => '',
        'Phone' => '',
        'Fax' => '',
        'Website' => '',
        'PhotoUrl' => '',
        'Industry' => '',
        'AnnualRevenue' => '',
        'NumberOfEmployees' => '',
        'Description' => '',
        'OwnerId' => 'OwnerId',
        'CreatedDate' => '',
        'CreatedById' => '',
        'LastModifiedDate' => '',
        'LastModifiedById' => '',
        'SystemModstamp' => '',
        'LastActivityDate' => '',
        'LastViewedDate' => '',
        'LastReferencedDate' => '',
        'Jigsaw' => '',
        'JigsawCompanyId' => '',
        'AccountSource' => '',
        'SicDesc' => '',

        /*
         * Account Custom Fields & Relationships
         */
    );

    /**
     * @param array $items
     */
    public function __construct(array $items=array())
    {
        foreach( $items as $name => $enum )
            $this->add($name, $enum);
    }

}