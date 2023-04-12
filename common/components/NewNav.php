<?php
namespace common\components;

use yii\bootstrap5\Nav;
use yii\helpers\ArrayHelper;

use Yii;

class NewNav extends Nav {

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
		$linkOptions['onclick'] = "Tabs.addTab('" . $label . "','Pagina " . $label . "','/index.php?r=" . $url[0] . "'); return false;";
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