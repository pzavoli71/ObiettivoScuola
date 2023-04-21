<?php
namespace common\components;

use yii\bootstrap5\Nav;
use yii\helpers\ArrayHelper;

use Yii;

class NewNav extends Nav {

    public $dropdownClass = NewDropdown::class;
    
        /**
     * Renders the given items as a dropdown.
     * This method is called to create sub-menus.
     * @param array $items the given items. Please refer to [[Dropdown::items]] for the array structure.
     * @param array $parentItem the parent item information. Please refer to [[items]] for the structure of this array.
     * @return string the rendering result.
     * @throws Throwable
     */
    protected function renderDropdown(array $items, array $parentItem): string
    {
        /** @var Widget $dropdownClass */
        $dropdownClass = $this->dropdownClass;

        return $dropdownClass::widget([
            'options' => ArrayHelper::getValue($parentItem, 'dropdownOptions', []),
            'items' => $items,
            'encodeLabels' => $this->encodeLabels,
            'clientOptions' => [],
            'view' => $this->getView(),
        ]);
    }

    /**
     * Renders a widget's item.
     * @param string|array $item the item to render.
     * @return string the rendering result.
     * @throws InvalidConfigException
     */
	public function renderItem($item) : string{
		if (is_string($item)) {
			return $item;
		}
		$linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
		$url = ArrayHelper::getValue($item, 'url','#');
		$label = ArrayHelper::getValue($item, 'label','#');
                if ( isset($url) && $url != '' && $url != '#') {
                    $linkOptions['onclick'] = "Tabs.addTab('" . $label . "','Pagina " . $label . "','/index.php?r=" . $url[0] . "'); return false;";
                }
		ArrayHelper::setValue($item,'linkOptions',$linkOptions);
		/*if ( empty($linkOptions['onclick'])) {
			if ( is_array($item)) {
				foreach ($item as $it) {
					ArrayHelper::setValue($it->linkOptions,'onclick','Tabs.addTab()'); 					
				}
			} else {
				ArrayHelper::setValue($item->linkOptions,'onclick','Tabs.addTab()'); 									
			}				
		}*/
		return Nav::renderItem($item);
	}

}