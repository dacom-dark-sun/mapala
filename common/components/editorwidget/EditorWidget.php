<?php

namespace common\components\editorwidget;

use Yii;
use yii\helpers\Json;
use vova07\imperavi\Widget as ImperaviWidget;

class EditorWidget extends ImperaviWidget
{
    /**
     * Register widget asset.
     */
    protected function registerClientScripts()
    {
        $view = $this->getView();
        $selector = Json::encode($this->selector);
        $asset = Yii::$container->get(AssetEditor::className());
        $asset = $asset::register($view);

        if (isset($this->settings['lang'])) {
            $asset->language = $this->settings['lang'];
        }
        if (isset($this->settings['plugins'])) {
            $asset->plugins = $this->settings['plugins'];
        }
        if (!empty($this->plugins)) {
            /** @var \yii\web\AssetBundle $bundle Asset bundle */
            foreach ($this->plugins as $plugin => $bundle) {
                $this->settings['plugins'][] = $plugin;
                $bundle::register($view);
            }
        }

        $settings = !empty($this->settings) ? Json::encode($this->settings) : '';

        $view->registerJs("jQuery($selector).redactor($settings);", $view::POS_READY, self::INLINE_JS_KEY . $this->options['id']);
    }
}