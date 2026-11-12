<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos-events
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

use open20\amos\events\AmosEvents;
use yii\helpers\Html;

$js = <<<JS
    $('.button-book-slot').click(function(e){
        e.preventDefault();
        var idslot = $(this).attr('data-key');
        var url = $(this).attr('href');
        $('#book-confirmed').attr('href',url);
        $('#modal-extra-info').modal('show');
    }); 

    $('#book-confirmed').click(function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        var affiliation = $('#affiliation').val();
        var cellphone = $('#cellphone').val();
        href += '&affiliation='+ encodeURI(affiliation)+'&cellphone='+encodeURI(cellphone);
        $(this).attr('href');
        document.location.href = href;
    });
JS;

$this->registerJs($js);
?>
<?php \yii\bootstrap\Modal::begin([
        'header' => AmosEvents::t("amosevents", "Book slot"),
        'id' => 'modal-extra-info',
    ]
); ?>
    <div class="col-xs-12 control-group">
    <p><?=  AmosEvents::t('amosevents', "Compila i dati aggiuntivi e prenota l'appuntamento") ?></p>
    <hr>
    <div class="control-label col-xs-12">
        <?php echo AmosEvents::t('amosevents', 'Cellphone') ?>
    </div>
    <div class="col-xs-12">
        <?php
        echo Html::textInput('cellphone', '', ['id'=> 'cellphone','class' => 'form-control']);
        ?>
    </div>
    <div class="control-label col-xs-12">
        <?php echo AmosEvents::t('amosevents', 'Affiliazione') ?>
    </div>
    <div class="col-xs-12">
        <?php
        echo Html::textInput('affiliation', '', ['id'=> 'affiliation', 'class' => 'form-control']);
        ?>
    </div>
    <?= Html::hiddenInput('url', '', ['id' => 'url-href'])?>
    <div class="control-label col-xs-12 m-t-10">
        <?php echo Html::a('Prenota', '', [ 'id' => 'book-confirmed', 'class' => 'btn btn-primary pull-right'])?>
        <?php echo Html::a('Annulla', '', ['data-dismiss' => 'modal', 'data-target' => '#modal-extra-info','class' => 'btn btn-secondary pull-left'])?>
    </div>
<?php \yii\bootstrap\Modal::end();