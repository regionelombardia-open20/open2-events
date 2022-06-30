<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\events\views\email
 * @category   CategoryName
 */

use open20\amos\core\helpers\Html;

/**
 * @var string $nomeCognome
 * @var string $text
 * @var string $previousUrl
 * @var string $confirmUrl
 */

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
