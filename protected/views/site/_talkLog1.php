<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tbl-post-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model1,iconv("gb2312","utf-8","������Ϣ")); ?>
		<?php echo $form->textArea($model1,'message_content',array('rows'=>3, 'cols'=>50)); ?>
		<?php echo $form->error($model1,'message_content'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model1,iconv("gb2312","utf-8","ѡ�����")); ?>
		<?php echo $form->dropDownList($model1,'message_reciever',User::getUserOnline()); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton(iconv("gb2312","utf-8","����")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->