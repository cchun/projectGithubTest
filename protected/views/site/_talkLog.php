<?php
/* @var $this SiteController */
/* @var $model TblUserChatonline */
/* @var $form CActiveForm */
?>

<div class="form">


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tbl-post-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,iconv("gb2312","utf-8","ÁÄÌì¼ÇÂ¼")); ?>
		<?php echo $form->textArea($model,'message_content',array('rows'=>15, 'cols'=>50)); ?>
		<?php echo $form->error($model,'message_content'); ?>
	</div>
	
    <br />


<?php $this->endWidget(); ?>

</div><!-- form -->






