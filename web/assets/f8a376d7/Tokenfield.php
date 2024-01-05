<?php

namespace mgcms\tokenfield;
use yii\helpers\Html;
use yii\widgets\InputWidget;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

/**
 * Implements Tokenfield for Bootstrap in Yii2.
 */
class Tokenfield extends InputWidget {
	/**
     * @var array widget plugin options
     */
    public $pluginOptions = [];

	/**
	 * @var boolean if true and value set, it will overwrite model's value
	 */
	public $overwriteValue = false;

	/**
	 * @var string selector used by jQuery
	 */
	protected $_selector = '';

	/**
     * @inheritdoc
     */
    public function init() {
		parent::init();
		$this->registerAssets();
	}

	/**
     * @inheritdoc
     */
    public function run() {

        // Generate an selector which will be used by jQuery
        $this->generateJquerySelector();

		// Input
        $this->echoInput();

		// Register the bootstrap-tokenfield script
		$this->registerClientScript();

    }

    public function generateJquerySelector() {

        if (isset($this->options['id'])) {
            $this->_selector = '#' . $this->options['id'];
        } elseif (!isset($this->options['data-tokenfield-id'])) {
            $id = uniqid('tokenfield_');
            $this->options['data-tokenfield-id'] = $id;
            $this->_selector = "[data-tokenfield-id={$id}]";
        }

    }

    public function getValue() {

        return (is_array($this->value) ? implode(', ', $this->value) : $this->value);

    }

    public function echoInput() {

        if ($this->hasModel()) {

            // If overwriting the model value
            if ($this->overwriteValue && $this->value) {
                $name = Html::getInputName($this->model, $this->attribute);
                $val = $this->getValue();
                echo Html::textInput($name, $val, $this->options);

            // If normal model
            } else {
                echo Html::activeTextInput($this->model, $this->attribute, $this->options);
            }

        // Not active record
        } else {
            $val = $this->getValue();
            echo Html::textInput($this->name, $val, $this->options);
        }

    }

	/**
     * Registers the needed client script and options.
     */
    public function registerClientScript() {
		$selector = $this->_selector;
		$options = Json::htmlEncode($this->pluginOptions);
		$clientScript = new JsExpression("$('{$selector}').tokenfield($options);");
		$this->view->registerJs(Json::htmlEncode($clientScript), View::POS_LOAD);
	}

	/**
     * Registers the asset bundle
     */
    private function registerAssets() {
        $view = $this->getView();
        TokenfieldAsset::register($view);
        JqueryUiAsset::register($view);
	}
}
