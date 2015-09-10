<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
$baseUrl = Yii::app()->theme->baseUrl; 
?>

<div class="row-fluid">
  <div class="span3 ">
    <div class="stat-block">
      <ul>
        <li class="stat-count">
            <span>
                Dashboard
            </span>
        </li>
      </ul>
    </div>
        <div class="summary">
          <ul>
            <li>
                <span class="summary-icon">
                    <img src="<?php echo $baseUrl ;?>/img/group.png" width="36" height="36" alt="Active Members">
                </span>
                <span class="summary-number"><?php echo number_format($voipAccountsCount) ?></span>
                <span class="summary-title"> 
                    VOIP Accounts
                    <?php echo CHtml::link('add new account', array('freeVoipAccounts/create') , array('class'=>'pull-right')); ?>
                </span>
            </li>
            <li>
                <span class="summary-icon">
                    <img src="<?php echo $baseUrl ;?>/img/folder_page.png" width="36" height="36" alt="Recent Conversions">
                </span>
                <span class="summary-number"><?php echo number_format($transactionCount) ?></span>
                <span class="summary-title"> 
                    Recent Transactions 
                    <?php echo CHtml::link('view all', array('transactionLog/index') , array('class'=>'pull-right')); ?>
                </span>
            </li>
        
          </ul>
        </div>
  </div>


	<div class="span9">
        <?php
        		$this->beginWidget('zii.widgets.CPortlet', array(
        			'title'=>'<span class="icon-picture"></span>Transfer Credits',
        			'titleCssClass'=>'',
                    // 'htmlOptions'=>array('style'=>'min-height:300px')
        		));
    	?>
        <div style='min-height: 300px;padding: 20px;'>
            <div class="form">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'transaction-log-form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),
                )); ?>
                <div class="row">
                    <?php echo CHtml::errorSummary($transactionLogMdl); ?>
                </div>
                    <div class="row">
                        <?php 
                            $this->widget('bootstrap.widgets.TbAlert', array(
                                'fade'=>true, // use transitions?
                                'closeText'=>'×', // close link text - if set to false, no close link is displayed
                                'alerts'=>array( // configurations per alert type
                                    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), 
                                    'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), 
                                ),
                            )); 
                        ?>
                    </div>
                    <div class="row">
                        <p class="note">Fields with <span class="required">*</span> are required.</p>
                    </div>
                    <div class="row">
                        <label>Transfer Amount  : </label><?php echo CHtml::activeTextField($transactionLogMdl, 'amount',array('placeholder'=>'Enter amount')); ?>
                        <?php echo CHtml::error($transactionLogMdl, 'amount'); ?>
                    </div>
                    <div class="row">
                        <label>To User : </label>
                        <?php echo $form->textField($transactionLogMdl,'to_username',array('placeholder'=>"Recipient of amount")); ?>
                        <?php echo $form->error($transactionLogMdl,'to_username'); ?>
                    </div>
                    <div class="row">
                        <label>Using account : </label>
                        <?php echo CHtml::activeDropDownList($transactionLogMdl, 'freevoip_account', FreeVoipListAccountsArray::getList(), array('prompt'=>"-- Please select an account -- ")); ?>
                        <?php echo CHtml::error($transactionLogMdl, 'freevoip_account'); ?>
                    </div>
                    <div class="row">
                        <label>PINCODE : </label>
                        <?php echo $form->textField($transactionLogMdl,'pincode',array('placeholder'=>"PINCODE")); ?>
                        <?php echo $form->error($transactionLogMdl,'pincode'); ?>
                        
                    </div>
                    <div class="row">
                        <hr>
                    </div>
                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Create',array('class'=>'btn btn-primary')); ?>
                    </div>
                <?php $this->endWidget(); ?>
            </div><!-- form -->
            
        </div>
        <?php $this->endWidget(); ?>
	</div>

</div>
