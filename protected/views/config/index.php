<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 3/18/16
 * Time: 12:43 AM
 */
?>
<div class="row-fluid">
    <div class="span8 offset2">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title'=>'<span class="icon-cog"></span> Settings',
        ));
        ?>


        <?php
        $this->widget('bootstrap.widgets.TbAlert', array(
            'block'=>true, // display a larger alert block?
            'fade'=>true, // use transitions?
            'closeText'=>'×', // close link text - if set to false, no close link is displayed
            'alerts'=>array( // configurations per alert type
                'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
            ),
        )); ?>
        <?php echo CHtml::beginForm(array('/subSipAccount/activateGroup'), 'post',['style'=>'padding: 30px;padding-bottom: 0px;']); ?>
        	<div class="span3 well" style="text-align: center;">
        		<a href="/config/autoTopUp">
        		<h3>Auto Top-up</h3>
        		<?php echo CHtml::image('//icons.iconarchive.com/icons/awicons/vista-artistic/72/coin-add-icon.png', 'Top up '); ?>
        		</a>
        	</div>
        	<div class="clearfix"></div>
        <?php echo CHtml::endForm(); ?>
        <?php
        $this->endWidget();
        ?>

    </div>
</div>
