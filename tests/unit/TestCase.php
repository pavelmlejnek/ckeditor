<?php

namespace CKEditor\Tests;

use Nette;
use Tester;

require_once __DIR__ . '/../../vendor/nette/tester/src/Framework/TestCase.php';

abstract class TestCase extends Tester\TestCase
{
    /**
     * @param array $configs
     * @return Nette\DI\Container
     */
    protected function createContainer(array $configs = []) {
        $configurator = new Nette\Configurator();
        $configurator->setTempDirectory(TEMP_DIR);
        $configurator->addParameters(['appDir' => __DIR__]);
        $configurator->createRobotLoader()
            ->addDirectory(__DIR__)
            ->register();

        $configurator->addConfig(__DIR__ . '/config/config.neon');

        // add custom config files
        if (!empty($configs)) {
            foreach ($configs as $config) {
                $configurator->addConfig(__DIR__ . '/config/' . $config);
            }
        }

        $container = $configurator->createContainer();
        
        return $container;
    }

    /**
     * @param Nette\DI\Container|null $container
     * @return mixed
     */
    protected function createPresenter(Nette\DI\Container $container = null) {
        if ($container === null) {
            $container = $this->createContainer();
        }

        $presenterFactory = $container->getByType('Nette\Application\IPresenterFactory');

        $presenter = $presenterFactory->createPresenter('Test');
        $presenter->autoCanonicalize = false;

        return $presenter;
    }

    /**
     * @param \Nette\Application\IPresenter $presenter
     * @param string $action
     * @param string $method
     * @return Nette\Application\Responses\TextResponse
     */
    protected function getResponse($presenter, $action, $method = 'GET') {
        $request = new Nette\Application\Request('Test', $method, ['action' => $action]);
        $response = $presenter->run($request);

        return $response;
    }
}
