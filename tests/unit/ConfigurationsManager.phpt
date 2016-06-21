<?php

namespace CKEditor\Tests;

use CKEditor\Model\ConfigurationsManager;
use Tester\Assert;

require_once __DIR__ . '/TestCase.php';
require_once __DIR__ . '/../bootstrap.php';

class ConfigurationsTest extends TestCase {

    /**
     * @var ConfigurationsManager
     */
    private $configurationsManager;
    
    protected function setUp()
    {
        $this->configurationsManager = new ConfigurationsManager();
    }

    protected function tearDown()
    {
        unset($this->configurationsManager);
    }

    public function testDefaults() {
        Assert::null($this->configurationsManager->getDefaultConfiguration());
    }

    public function testAddConfigurationWithWrongName() {
        Assert::exception(
            function() { $this->configurationsManager->addConfiguration(''); },
            '\InvalidArgumentException',
            'You cannot add configuration with blank name.'
        );
    }

    public function testAddConfiguration() {
        $this->configurationsManager->addConfiguration('test', ['testSetting' => 'testValue']);

        Assert::same(
            ['testSetting' => 'testValue'],
            $this->configurationsManager->getConfiguration('test')
        );
    }

    public function testGetConfigurationWhichDoesNotExists() {
        Assert::exception(
            function() { $this->configurationsManager->getConfiguration('nonExistingConfiguration'); },
            '\InvalidArgumentException',
            'Configuration does not exists.'
        );
    }

    public function testHasConfiguration() {
        $this->configurationsManager->addConfiguration('testConfiguration', ['testKey' => 'testValue']);
        Assert::true($this->configurationsManager->hasConfiguration('testConfiguration'));
    }

    public function testHasConfigurationWhichDoesNotExists() {
        Assert::false($this->configurationsManager->hasConfiguration('configurationWhichDoesNotExists'));
    }

    public function testHasConfigurations() {
        $this->configurationsManager->addConfiguration('testConfiguration', ['testKey' => 'testValue']);
        Assert::true($this->configurationsManager->hasConfigurations());
    }

    public function testHasConfigurationsWithNoConfiguration() {
        Assert::false($this->configurationsManager->hasConfigurations());
    }

    public function testSetDefaultConfiguration() {
        $this->configurationsManager->addConfiguration('testConfiguration', ['testKey' => 'testValue']);
        $this->configurationsManager->setDefaultConfiguration('testConfiguration');

        Assert::same('testConfiguration', $this->configurationsManager->getDefaultConfiguration());
    }

    public function testSetDefaultConfigurationWhichDoesNotExists() {
        Assert::exception(
            function() { $this->configurationsManager->setDefaultConfiguration('nonExistingConfiguration'); },
            '\InvalidArgumentException',
            'Configuration does not exists.'
        );
    }

    public function testHasDefaultConfiguration() {
        $this->configurationsManager->addConfiguration('testConfiguration', ['testKey' => 'testValue']);
        $this->configurationsManager->setDefaultConfiguration('testConfiguration');

        Assert::true($this->configurationsManager->hasDefaultConfiguration());
    }

    public function testHasDefaultConfigurationWithNoDefaultConfigurationSet() {
        Assert::false($this->configurationsManager->hasDefaultConfiguration());
    }

    public function testMergeConfiguration() {
        $this->configurationsManager->addConfiguration('testConfiguration', ['testField' => 'testValue']);

        Assert::same(
            ['testField' => 'anotherTestValue'],
            $this->configurationsManager->mergeConfiguration('testConfiguration', ['testField' => 'anotherTestValue'])
        );
    }

    public function testMergeConfigurationWithConfigurationWhichDoesNotExists() {
        Assert::exception(
            function() { $this->configurationsManager->mergeConfiguration('nonExistingConfiguration', ['testField' => 'testValue']); },
            '\InvalidArgumentException',
            'Configuration does not exists.'
        );
    }
}
\run(new ConfigurationsTest());
