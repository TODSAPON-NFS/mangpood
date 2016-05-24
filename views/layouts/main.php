<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\web\View; //สำหรับ Register Favicon

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php View::registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web') . '/favicon.ico']); ?>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => Html::img("@web/images/mangpood_logo.svg", ['id' => 'brandLabel', 'style' => 'margin-top:7px;']),
                //'brandLabel' => 'My Company',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-default navbar-fixed-top',
                    'style' => 'background-color: #c2dfff;border-color: #ff6600; height:60px;',
                ],
            ]);

            if (Yii::$app->user->isGuest) {
                $menuItems_left = [];
            } else {
                $menuItems_left = [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'กลุ่มสินค้า', 'url' => ['/category/index']],
                    ['label' => 'สินค้า', 'url' => ['/product/index']],
                    ['label' => 'Contact', 'url' => ['/site/contact']],
                ];
            }

            $menuItems_right = [
                Yii::$app->user->isGuest ? (
                        ['label' => '<i class="fa fa-lock" aria-hidden="true" style="color:#ffffff;font-size:1em;vertical-align: baseline;"></i> Login', 'url' => ['/site/login']]
                        ) : (
                        ['label' => '<i class="fa fa-unlock" aria-hidden="true" style="color:#ff6600;font-size:1em;vertical-align: baseline;"></i> Logout (' . Yii::$app->user->identity->user_name . ')', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']]
                        )
            ];


            echo Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'encodeLabels' => false, //เพื่อให้แทรก html ได้
                'items' => $menuItems_left
            ]);

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'encodeLabels' => false, //เพื่อให้แทรก html ได้
                'items' => $menuItems_right
            ]);

            NavBar::end();
            ?>

            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; Mangpood Inc. <?= date('Y') ?></p>

                <p class="pull-right hidden-xs"><?= Yii::powered(); ?> <i class="fa fa-github-alt fa-lg" aria-hidden="true" style="color:#ff6600;vertical-align: middle;margin-left:5px;"></i> <i class="fa fa-font-awesome fa-lg" aria-hidden="true" style="color:#ff6600;vertical-align: middle;margin-left:5px;"></i> <i class="fa fa-html5 fa-lg" aria-hidden="true" style="color:#ff6600;vertical-align: middle;margin-left:5px;"></i> <i class="fa fa-css3 fa-lg" aria-hidden="true" style="color:#ff6600;vertical-align: middle;"></i></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
