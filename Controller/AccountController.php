<?php

namespace Hgtan\Bundle\HelloSalesforceBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class AccountController extends CustomObjectsController
{
    public function getSfObjectClass()
    {
        return 'Account';
    }

    /**
     * @Route("/salesforce/account/pull")
     * @Template("/Default/index.html.twig")
     */
    public function pullAction()
    {
        try {
            $client = $this->soapClient;
            $strColumnAccount = $this->makeupSObjects2SelectFields();
            $sfObj = $this->getSfObjectClass();
            $resultAccountObj = $client->query("select $strColumnAccount from $sfObj");

            echo $resultAccountObj->count() . ' accounts returned<br>';
            $resultArr = $resultAccountObj->getQueryResult()->getRecords();
            foreach ($resultArr as $record) {
                echo 'Id: ' . $record->Id . "<br>";
                echo 'Name: ' . $record->Name . "<br>";
                echo 'Last modified: ' . $record->SystemModstamp->format('Y-m-d H:i:s') . "<br><br>";
            }

        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
        return array();
    }

    /**
     * @Route("/salesforce/account/insert")
     * @Template("/Default/index.html.twig")
     */
    public function insertAction()
    {
        try {
            $client = $this->soapClient;

            //Test to insert/update with a tested customer by API
            $records[0] = new \stdClass();
            $records[0]->Name = 'Company Inc.';
            $records[1] = new \stdClass();
            $records[1]->Name = 'Company 2 Inc.';

            $response = $client->create($records, $this->getSfObjectClass());

            $ids = array();
            foreach ($response as $i => $result) {
                echo ($result->isSuccess() == 1)
                    ? $records[$i]->Name . " "
                    . " created with id " . $result->getId() . "<br/>\n"
                    : "Error: " . $result->getErrors()->getMessage() . "<br/>\n";
                array_push($ids, $result->getId());
            }

            echo "<br/>Retrieve the newly created records:<br/>\n";
            $this->retrieveNewlySObjects($ids);

        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
        return array();
    }

    /**
     * @Route("/salesforce/account/update")
     * @Template("/Default/index.html.twig")
     */
    public function updateAction()
    {
        try {
            $client = $this->soapClient;

            $records[0] = new \stdClass();
            $records[0]->Id = '00128000004kQdiAAE';
            $records[0]->Name = 'Company Inc. [Update]';
            $records[1] = new \stdClass();
            $records[1]->Id = '00128000004kQdjAAE';
            $records[1]->Name = 'Company 2 Inc. [Update]';

            $ids = $error = array();

            $response = $client->update($records, 'Account');
            foreach ($response as $i => $result) {
                if ($result->isSuccess() == 1) {
                    array_push($ids, $result->getId());
                } else {
                    array_push($error, $result->getErrors());
                }
            }

            echo "Retrieve the updated records:<br/><br/>\n";
            $this->retrieveNewlySObjects($ids);

        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
        return array();
    }

    /**
     * @Route("/salesforce/account/delete")
     * @Template("/Default/index.html.twig")
     */
    public function deleteAction()
    {
        try {
            $client = $this->soapClient;

            $dt = date("Ymd_H-i");
            $logSuccess = new Logger('sfSuccess');
            $logError = new Logger('sfEerror');

            $ids = array(
                    "00128000004kQdiAAE",
                    "00128000004kQdjAAE",
                    );

            $success = $error = array();
            for ($i = 0; $i < count($ids); $i++) {
                $response = $client->delete(array($ids[$i]));
                foreach ($response as $j => $result) {
                    if ($result->isSuccess() == 1) {
                        array_push($success, $result->getId());
                    } else {
                        array_push($error, $result->getErrors());
                    }
                }
            }

            if (count($success) > 0) {
                $logSuccess->pushHandler(new StreamHandler('../app/logs/Sf_' . $this->getSfObjectClass() . '_' . $dt . '_SUCCESS.log', Logger::INFO));
                $logSuccess->info('Deleted with id ');
                $logSuccess->info(json_encode($ids));
            }

            if (count($error) > 0) {
                $logError->pushHandler(new StreamHandler('../app/logs/Sf_'.$this->getSfObjectClass().'_'.$dt.'_ERROR.log', Logger::WARNING));
                $logError->error(json_encode($error));
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
        return array();
    }

    /**
     * @Route("/salesforce/account/upsert")
     * @Template("/Default/index.html.twig")
     */
    public function upsertAction()
    {
        try {
            $client = $this->soapClient;

            $sObject = new \stdClass();
            $sObject->FirstName = 'George';
            $sObject->LastName  = 'Smith';
            $sObject->Phone     = '510-555-5555';
            $sObject->BirthDate = '1927-01-25';
            $sObject->Email     = 'test@test.com';

            echo "<pre>";
            $createResponse = $client->create(array($sObject), 'Contact');

            echo "Creating New Contact\r\n";
            print_r($createResponse);

            $sObject->FirstName = 'Bill';
            $sObject->LastName = 'Clinton';
            $upsertResponse = $client->upsert('Email', array ($sObject), 'Contact');

            echo "Upserting Contact (existing)\r\n";
            print_r($upsertResponse);

            $sObject->FirstName = 'John';
            $sObject->LastName = 'Smith';
            $sObject->Email = 'testnew@test.com';
            $upsertResponse = $client->upsert('Email', array ($sObject), 'Contact');

            echo "Upserting Contact (new)\n";
            print_r($upsertResponse);

        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
        return array();
    }

    /**
     * @Route("/salesforce/account/upsert2")
     * @Template("/Default/index.html.twig")
     */
    public function upsert2Action()
    {
        try {
            $client = $this->soapClient;

            $records[0] = new \stdClass();
            $records[0]->Name = 'UpsertOpportunity';
            $records[0]->StageName = 'Prospecting';
            $records[0]->CloseDate = new \DateTime();

            $response = $client->create($records, 'Opportunity');

            //$response = $client->upsert("External_Field__c", array($sObject), 'Contact');
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
        return array();
    }
}
