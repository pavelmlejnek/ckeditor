<?php

namespace CKEditor\Tests\Forms\Controls;

use CKEditor\Tests\TestCase;
use Tester\Assert;
use Tester\DomQuery;

require_once __DIR__ . '/../../TestCase.php';
require_once __DIR__ . '/../../../bootstrap.php';

class CKEditorTest extends TestCase {

    public function testBasicCreationWithoutParameters() {
        $presenter = $this->createPresenter();
        $response = $this->getResponse($presenter, 'default');

        $html = (string) $response->getSource();

        $this->editorInitializationTest($html, 'formWithoutSpecificConfiguration');


        Assert::true(strpos($html, 'CKEDITOR.replace("frm-formWithoutSpecificConfiguration-testField", [])') !== false);
    }

    public function testCreationWithConfiguration() {
        $container = $this->createContainer(['one-configuration-set-as-default.neon']);
        $presenter = $this->createPresenter($container);

        $response = $this->getResponse($presenter, 'default');

        $html = (string) $response->getSource();

        $this->editorInitializationTest($html, 'formWithoutSpecificConfiguration');

        Assert::true(
            strpos($html, 'CKEDITOR.replace("frm-formWithoutSpecificConfiguration-testField", {"option":"fromConfigNeon"})') !== false
        );
    }

    public function testWithSpecificConfigurationOnly() {
        $container = $this->createContainer();
        $presenter = $this->createPresenter($container);

        $response = $this->getResponse($presenter, 'formWithSpecificConfiguration');

        $html = (string) $response->getSource();

        $this->editorInitializationTest($html, 'formWithSpecificConfiguration');

        Assert::true(strpos($html, 'CKEDITOR.replace("frm-formWithSpecificConfiguration-testField", {"option":"fromPresenter"})') !== false);
    }

    public function testCreationWithBothConfigurationAndSpecificConfiguration() {
        $container = $this->createContainer(['one-configuration-set-as-default.neon']);
        $presenter = $this->createPresenter($container);

        $response = $this->getResponse($presenter, 'formWithSpecificConfiguration');

        $html = (string) $response->getSource();

        $this->editorInitializationTest($html, 'formWithSpecificConfiguration');

        Assert::true(strpos($html, 'CKEDITOR.replace("frm-formWithSpecificConfiguration-testField", {"option":"fromPresenter"})') !== false);
    }
    
    public function testCreationWithUseConfigurationOption() {
        $container = $this->createContainer(['one-configuration.neon']);
        $presenter = $this->createPresenter($container);

        $response = $this->getResponse($presenter, 'formWithUseConfigurationOption');

        $html = (string) $response->getSource();

        $this->editorInitializationTest($html, 'formWithUseConfigurationOption');
        echo($html);
        Assert::true(strpos($html, 'CKEDITOR.replace("frm-formWithUseConfigurationOption-testField", {"option":"fromConfigNeon"})') !== false);
    }

    private function editorInitializationTest($html, $formName) {
        $dom = DomQuery::fromHtml($html);

        Assert::true($dom->has('div#ckeditor-frm-' . $formName . '-testField')); // the wrapper div exists
        Assert::true($dom->has('textarea.ckeditor')); // the field itself exists
        Assert::true($dom->has('div#ckeditor-frm-' . $formName . '-testField script[src="js/ckeditor/ckeditor.js"]')); // ckeditor is loaded
        Assert::true($dom->has('div#ckeditor-frm-' . $formName . '-testField script[type="text/javascript"]')); // initialization is present
    }
}
\run(new CKEditorTest());
