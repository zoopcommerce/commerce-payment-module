<?php

namespace Zoop\Payment\Test;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Doctrine\ODM\MongoDB\DocumentManager;
use Zoop\Store\DataModel\Store;

abstract class BaseTest extends AbstractHttpControllerTestCase
{
    protected static $documentManager;
    protected static $serviceLocator;
    protected static $dbName;
    protected static $store;

    public function setUp()
    {
        if (!isset(self::$serviceLocator)) {
            $this->setApplicationConfig(
                require __DIR__ . '/../../../test.application.config.php'
            );
            self::$serviceLocator = $this->getApplicationServiceLocator();
        }
        
        if (!isset(self::$documentManager)) {
            self::$documentManager = self::$serviceLocator->get('shard.commerce.modelmanager');
        }
        
        if (!isset(self::$dbName)) {
            self::$dbName = self::$serviceLocator->get('config')['doctrine']['odm']['connection']['commerce']['dbname'];
        }
    }

    public static function tearDownAfterClass()
    {
        self::clearDatabase();
    }

    /**
     * Clears all test data from the mongo database
     */
    public static function clearDatabase()
    {
        if (isset(self::$documentManager)) {
            $collections = self::getDocumentManager()
                ->getConnection()
                ->selectDatabase(self::getDbName())
                ->listCollections();

            foreach ($collections as $collection) {
                /* @var $collection \MongoCollection */
                $collection->drop();
            }
        }
    }

    /**
     * @return DocumentManager
     */
    public static function getDocumentManager()
    {
        return self::$documentManager;
    }

    /**
     * @param DocumentManager $documentManager
     */
    public static function setDocumentManager(DocumentManager $documentManager)
    {
        self::$documentManager = $documentManager;
    }

    /**
     * 
     * @return string
     */
    public static function getDbName()
    {
        return self::$dbName;
    }

    /**
     * 
     * @param string $dbName
     */
    public static function setDbName($dbName)
    {
        self::$dbName = $dbName;
    }

    /**
     * 
     * @return Store
     */
    public static function getStore()
    {
        if (!isset(self::$store)) {
            $dm = self::getDocumentManager();
            
            $store = self::$serviceLocator->get('zoop.commerce.store.active');

            $dm->persist($store);
            $dm->flush($store);
            $dm->clear($store);

            self::$store = $store;
        }

        return self::$store;
    }
}
