<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\views\event
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

use open20\amos\core\helpers\Html;
use open20\amos\events\AmosEvents;

/**
 * @var string $nomeCognome
 * @var string $text
 * @var string $previousUrl
 * @var string $confirmUrl
 */

$this->title = AmosEvents::txt('#remove_signup_to_event_thankyou_title');

?>

<h3><?= $nomeCognome; ?></h3>
<h3><?= $text ?></h3>
<br/><br/>
<?= Html::tag(
    'div',
    Html::a(
        \Yii::t('amoscore', 'No'),
        $previousUrl,
        [
            'class' => 'btn btn-secondary'
        ]
    ) . ' ' . Html::a(
        \Yii::t('amoscore', 'Yes'),
        $confirmUrl,
        [
            'class' => 'btn btn-primary'
        ]
    ),
    [
        'class' => 'pull-right'
    ]
); ?>
