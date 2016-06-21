<?php

namespace CKEditor;


use CKEditor\Forms\Controls\CKEditorControl;
use CKEditor\Model\ConfigurationsManager;
use CKEditor\Renderer\FormRenderer;

class CKEditor
{
    /**
     * @var \CKEditor\Model\ConfigurationsManager
     */
    private $configurationsManager;

    /**
     * @var boolean
     */
    private $autoload;

    /**
     * @var FormRenderer
     */
    private $formRenderer;

    /**
     * @param ConfigurationsManager $configurationsManager
     */
    public function setConfigurationsManager(ConfigurationsManager $configurationsManager) {
        $this->configurationsManager = $configurationsManager;
    }

    /**
     * @param FormRenderer $formRenderer
     */
    public function setFormRenderer(FormRenderer $formRenderer) {
        $this->formRenderer = $formRenderer;
    }

    /**
     * @param $autoload
     */
    public function setAutoload($autoload) {
        $this->autoload = $autoload;
    }

    /**
     * @return mixed
     */
    public function getAutoload() {
        return $this->autoload;
    }

    /**
     * @param $label
     * @param array $specificConfiguration
     * @return CKEditorControl
     */
    public function createControl($label, array $specificConfiguration = []) {
        if (!empty($specificConfiguration && $this->configurationsManager->getDefaultConfiguration() !== NULL)) {
            $configuration = $this->configurationsManager->mergeConfiguration(
                $this->configurationsManager->getDefaultConfiguration(),
                $specificConfiguration
            );
        } elseif (isset($specificConfiguration['useConfiguration'])) {
            $configuration = $this->configurationsManager->mergeConfiguration(
                $specificConfiguration['useConfiguration'], 
                $specificConfiguration
            );
            unset($configuration['useConfiguration']);
        } elseif (empty($specificConfiguration) && $this->configurationsManager->getDefaultConfiguration() != NULL) {
            $configuration = $this->configurationsManager->getConfiguration($this->configurationsManager->getDefaultConfiguration());
        }  else {
            $configuration = $specificConfiguration;
        }

        $ckeditorControl = new CKEditorControl(
            $label,
            $this->formRenderer,
            $configuration
        );

        $ckeditorControl->setAutoload($this->getAutoload());

        return $ckeditorControl;
    }
}
