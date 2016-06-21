<?php

namespace CKEditor\Tests;

use Nette;

class TestPresenter extends Nette\Application\UI\Presenter
{
    /**
     * @return Nette\Application\UI\Form
     */
    public function createComponentFormWithoutSpecificConfiguration() {
        $form = new Nette\Application\UI\Form;
        $form->addCKEditor('testField');

        return $form;
    }

    public function createComponentFormWithSpecificConfiguration() {
        $form = new Nette\Application\UI\Form;
        $form->addCKEditor('testField', 'TestField:', ['option' => 'fromPresenter']);

        return $form;
    }
    
    public function createComponentFormWithUseConfigurationOption() {
        $form = new Nette\Application\UI\Form;
        $form->addCKEditor('testField', 'TestField:', ['useConfiguration' => 'test-configuration']);

        return $form;
    }
}
