<?php

namespace CKEditor\Tests;

use CKEditor\CKEditor;
use CKEditor\Model\ConfigurationsManager;
use CKEditor\Renderer\FormRenderer;
use Tester\Assert;

require_once __DIR__ . '/TestCase.php';
require_once __DIR__ . '/../bootstrap.php';

class ExtensionTest extends TestCase {

    public function testDI() {
        $container = $this->createContainer();

        Assert::true($container->getByType('\CKEditor\CKEditor') instanceof CKEditor);
        Assert::true($container->getByType('\CKEditor\Model\ConfigurationsManager') instanceof ConfigurationsManager);
        Assert::true($container->getByType('\CKEditor\Renderer\FormRenderer') instanceof FormRenderer);
    }
    
    
}
\run(new ExtensionTest());
