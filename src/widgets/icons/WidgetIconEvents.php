<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\widgets\icons
 * @author    Aria S.p.A. <protocollo@pec.ariaspa.it>
 * @license   GNU General Public License v3.0 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @link      https://www.ariaspa.it/
 *
 * This file is part of OPEN 2.0.
 *
 * OPEN 2.0 is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OPEN 2.0 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OPEN 2.0. If not, see <https://www.gnu.org/licenses/>.
 */

namespace open20\amos\events\widgets\icons;

use open20\amos\core\widget\WidgetIcon;
use open20\amos\core\widget\WidgetAbstract;
use open20\amos\core\icons\AmosIcons;
use open20\amos\events\AmosEvents;
use open20\amos\utility\models\BulletCounters;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class WidgetIconEvents
 * @package open20\amos\events\widgets\icons
 */
class WidgetIconEvents extends WidgetIcon
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $paramsClassSpan = [
            'bk-backgroundIcon',
            'color-lightPrimary'
        ];

        $this->setLabel(AmosEvents::t('amosevents', '#widget_icon_events_label'));
        $this->setDescription(AmosEvents::t('amosevents', 'Allow the user to modify the Events entity'));

        if (!empty(Yii::$app->params['dashboardEngine']) && Yii::$app->params['dashboardEngine'] == WidgetAbstract::ENGINE_ROWS) {
            $this->setIconFramework(AmosIcons::IC);
            $this->setIcon('eventi');
            $paramsClassSpan = [];
        } else {
            $this->setIcon('calendar');
        }

        $this->setUrl(['/events']);
        $this->setCode('EVENTS');
        $this->setModuleName('events');
        $this->setNamespace(__CLASS__);

        $this->setClassSpan(
            ArrayHelper::merge(
                $this->getClassSpan(), $paramsClassSpan
            )
        );

        if ($this->disableBulletCounters == false) {
            $widgetAll = \Yii::createObject(['class' => WidgetIconAllEvents::className(), 'saveMicrotime' => false]);
            $this->setBulletCount(
                $widgetAll->getBulletCount()
            );
        }
    }
}