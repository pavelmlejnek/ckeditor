<?php

namespace CKEditor\Forms\Controls;

use Nette\Utils\Html;
use CKEditor\Model\ConfigurationsManager;
use CKEditor\Renderer\FormRenderer;

class CKEditorControl extends \Nette\Forms\Controls\TextArea
{

    private $configuration;

    /**
     * @var bool
     */
    private $autoload;

    /**
     * @var FormRenderer
     */
    private $formRenderer;

    /**
     * CKEditor constructor.
     * @param null $label
     * @param FormRenderer $formRenderer
     * @param 
     */
    public function __construct($label = NULL, FormRenderer $formRenderer, $configuration) {
        parent::__construct($label);

        $this->control->class = 'ckeditor';
        $this->formRenderer = $formRenderer;
        $this->configuration = $configuration;
    }


    /**
     * @return static
     */
    public function getControl() {
        $control = parent::getControl();

        $container = Html::el('div', ['id' => 'ckeditor-' . $control->id]);

        $container->addHtml($control);

        if ($this->autoload) {
            $container->addHtml($this->formRenderer->renderEditorSrc());
            $container->addHtml($this->formRenderer->renderEditorInit($control->id, $this->configuration));
        }

        return $container;
    }

    /**
     * @param boolean $autoload
     */
    public function setAutoload($autoload) {
        $this->autoload = $autoload;
    }
}
