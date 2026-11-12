<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   openinnovation\organizations\controllers
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

namespace open20\amos\events\models;

use open20\amos\events\AmosEvents;
use yii\base\Model;
use yii\web\UploadedFile;

class EventInvitationPartner extends Model
{

    public $name;
    public $surname;
    public $fiscal_code;
    public $email;

    public function rules()
    {
        return [
            // [['name', 'surname', 'fiscal_code', 'email'], 'required', 'when' => function($mod) {
            //     return $mod->name || $mod->surname || $mod->fiscal_code || $mod->email;
            // }],
            [['email'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['fiscal_code'], 'string', 'max' => 16],
            [['name', 'surname'], 'string', 'max' => 50],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'email' => AmosEvents::txt('#email'),
            'fiscal_code' => AmosEvents::txt('#fiscalcode'),
            'name' => AmosEvents::txt('#name'),
            'surname' => AmosEvents::txt('#surname'),
        ];
    }

}