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
    <?php echo $this->element('Layout/head'); ?>
    <body class="order">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <img alt="<?php echo $this->Entity->get('Takeaway')->getName(); ?> logo" src="<?php echo $this->Entity->get('Takeaway')->getLogo(); ?>" class="img-responsive" />
                </div>            
            </div>
            <div class="row">
                <div class="col-md-9" >
                    <div id="menu">
                        <?= $this->fetch('content') ?>
                    </div>
                </div>
                
                <div class="col-md-3 hidden-xs" >
                    <div id="sidebar">
                        <?= $this->element('sidebar') ?>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
