<?php

namespace CKEditor\Renderer;

use CKEditor\Entities\PluginEntity;
use Nette\Utils\Html;
use Nette\Utils\Json;

class FormRenderer
{
    /**
     * @var string
     */
    private $ckeditorPath;

    /**
     * @param string $ckeditorPath
     */
    public function setCKEditorPath($ckeditorPath) {
        $this->ckeditorPath = $ckeditorPath;
    }

    /**
     * @return static
     */
    public function renderEditorSrc() {
        return Html::el('script', ['type' => 'text/javascript', 'src' => $this->ckeditorPath . '/ckeditor.js']);
    }

    /**
     * @param string $htmlId
     * @param array $configuration
     * @return static
     */
    public function renderEditorInit($htmlId, array $configuration) {
        return Html::el('script', ['type' => 'text/javascript'])
            ->setHtml(sprintf('CKEDITOR.%s("%s", %s)',
                'replace',
                $htmlId,
               Json::encode($configuration))
            );
    }
}
