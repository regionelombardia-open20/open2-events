<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\controllers
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
 
namespace open20\amos\events\controllers;
use open20\amos\events\models\base\EventConfigurations;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;


/**
 * Class EventConfigurationsController 
 * This is the class for controller "EventConfigurationsController".
 * @package open20\amos\events\controllers 
 */
class EventConfigurationsController extends \open20\amos\events\controllers\base\EventConfigurationsController
{

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'configure',
                        ],
                        'roles' => ['CONFIGURATOR_EVENTS']
                    ],


                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post', 'get']
                ]
            ]
        ]);
    }
    /**
     * @return mixed|\yii\web\Response
     */
    public function actionConfigure(){
        $config = EventConfigurations::findOne(1);
        if($config) {
            return $this->actionUpdate(1);
        }
        return $this->redirect('index');
    }


}
