<?php

namespace Hgtan\Bundle\HelloSalesforceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class CustomObjectsController extends Controller implements ContainerAwareInterface
{
    public $soapClient;
    protected $container;

    abstract public function getSfObjectClass();

    /*function __construct() {
        echo 'Base __construct<br/>';
    }*/

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->soapClient = $this->container->get('phpforce.soap_client');
    }

    /**
     *
     * @return mixed
     */
    public function describeSObjects2Array() {
        $obj = $this->soapClient->describeSObjects(array($this->getSfObjectClass()));
        $arr = $obj[0]->getFields()->toArray();
        return $arr;
    }

    /**
     * @return string
     */
    public function makeupSObjects2SelectFields() {
        $str = '';
        $arr = $this->describeSObjects2Array();
        foreach ($arr as $key => $value) {
            $str .= ($value == end($arr)) ? $value->getName() : $value->getName() . ', ';
        }
        return $str;
    }

    /**
     * Retrieve the newly created records
     * @param $ids
     */
    public function retrieveNewlySObjects($ids) {
        $response = $this->soapClient->retrieve(array('Id', 'Name', 'SystemModstamp'), $ids, $this->getSfObjectClass());
        foreach ($response as $record) {
            echo $record->Id . ": " . $record->Name . " " . $record->SystemModstamp->format('Y-m-d H:i:s')
                . "<br/>\n";
        }
    }

}
