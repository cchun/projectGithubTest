<?php
/* @var $this TblPostController */
/* @var $model TblPost */
/* @var */

$this->breadcrumbs=array(
	'Tbl Posts'=>array('index'),
);

/*$this->menu=array(
	array('label'=>'List TblPost', 'url'=>array('index')),
);*/
array_push($this->menu, array('label'=>'test1'));
array_push($this->menu, array('label'=>'demo'));
array_push($this->menu, array('label'=>'demo1'));
?>

<h3>Hello <?php echo Yii::app()->user->name; ?>, welcome to the talkroom!<br><br></h3>

<div id="list">
	
</div>

<div id="log">
	<?php echo $this->renderPartial('_TalkLog', array('model'=>$model)); ?>
</div>

<div id="send">
	<?php echo $this->renderPartial('_TalkLog1', array('model1'=>$model1)); ?>
</div>

<?php echo CHtml::ajaxLink(
          iconv("gb2312","utf-8","更新用户列表"),
          // array('UpdateAjax'),
           CController::createUrl('site/UpdateUseronline'),
           array('update' => '#sidebar',
          ));
?>

<?php Yii::app()->clientScript->registerCoreScript("jquery")?>
<script type="text/javascript">
	jQuery(function($) {
		//var newsList = $('#log');
		var i = 0;
		function updateNews() {
				//newsList.html("loading...");
		        $.ajax({
		            'url': "<?php echo CController::createUrl('site/UpdateAjax')?>",
		            'cache':false,
		            'success':function(data){
		                jQuery("#log").html(data);
		                
		            }
		        });
		}
		setInterval(updateNews, 2000);
	});
</script>



