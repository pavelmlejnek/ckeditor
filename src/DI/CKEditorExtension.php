<?php

namespace CKEditor\DI;

use Nette;
use CKEditor\CKEditor;
use CKEditor\Entities\PluginEntity;
use Nette\DI\CompilerExtension;
use Nette\Forms\Container;
use Nette\Utils\Validators;



class CKEditorExtension extends CompilerExtension
{
    private $defaults = [
        'enabled' => true,
        'ckeditor_path' => 'js/ckeditor',
        'autoload' => true,
        'default_configuration' => null,
        'plugins' => [],
        'configurations' => []
    ];

    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->validateConfig($this->defaults);

        if ($config['enabled'] !== false) {
            Validators::assertField($config, 'enabled', 'bool');
            Validators::assertField($config, 'autoload', 'bool');

            $configurationsManager = $builder->addDefinition($this->prefix('configurationsManager'))
                ->setClass('CKEditor\Model\ConfigurationsManager');

            if (is_array($config['configurations'])) {
                foreach ($config['configurations'] as $name => $configuration) {
                    $configurationsManager->addSetup('addConfiguration', [$name, $configuration]);
                }

                if ($config['default_configuration'] !== NULL) {
                    $configurationsManager->addSetup('setDefaultConfiguration', [$config['default_configuration']]);
                }
            }

            $builder->addDefinition($this->prefix('formRenderer'))
                ->setClass('CKEditor\Renderer\FormRenderer')
                ->addSetup('setCKEditorPath', [$this->config['ckeditor_path']]);

            $builder->addDefinition($this->prefix('ckeditor'))
                ->setClass('CKEditor\CKEditor')
                ->addSetup('setConfigurationsManager', ['@' . $this->prefix('configurationsManager')])
                ->addSetup('setFormRenderer', ['@' . $this->prefix('formRenderer')])
                ->addSetup('setAutoload', [$this->config['autoload']]);
        }
    }


    public function afterCompile(Nette\PhpGenerator\ClassType $class)
    {
        $initialize = $class->getMethods()['initialize'];
        $initialize->addBody(__CLASS__ . '::registerControl($this->getService(?));', [$this->prefix('ckeditor'),]);
    }


    public static function registerControl(CKEditor $ckeditor)
    {
        Container::extensionMethod(
            'addCKEditor',
            function (Container $container, $name, $label = NULL, $configuration = []) use ($ckeditor) {
                return $container[$name] = $ckeditor->createControl($label, $configuration);
            }
        );
    }
}