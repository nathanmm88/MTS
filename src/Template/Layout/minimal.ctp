<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>

        <?= $this->Html->css('/dist/css/app.css') ?>
        <?= $this->Html->script('/dist/scripts/build.js') ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body class="minimal">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <img alt="<?php echo $this->Takeaway->getName(); ?> logo" src="<?php echo $this->Takeaway->getLogo(); ?>" class="img-responsive img-responsive-center" />
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 content">
                    <?= $this->fetch('content') ?>
                </div>
            </div>
            <div id="footer" class="row">
                <div class="col-sm-6 footer-text">
                    &copy; <?php echo $this->Takeaway->getName(); ?> <?php echo date('Y') ?>
                </div>
                <div class="col-sm-6 footer-text text-right">
                    Powered by: <a href="http://mytakeawaysite.com">MyTakeawaySite.com</a>
                </div>
            </div>
        </div>
    </body>
</html>
