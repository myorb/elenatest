<?php
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Categories</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'id',
			'htmlOptions'=>array('width'=>'20px'),
			),
		array(
			'name'=>'title',
			),
		array(
			'header'=>'Root Categoy',
			'name'=>'root',
			'type'=>'raw',
			'value'=>'$data->isRoot()?"":$data->parent()->find()->title',
			'filter'=>CHtml::listData($model->roots()->findAll(), 'id', 'title'),
			),
		array(
			'name'=>'price',
			// 'htmlOptions'=>array('width'=>'70px'),
			),
		array(
	        'name'=>'status',
	        'type'=>'raw',
	        'filter'=>array('not active','active'),
	        'value'=>'$data->status==1?"active":"not active"',
		),
		array(
			'header'=>'Relateion to dictionary',
			'name'=>'dictionary',
			'type'=>'raw',
			'value'=>'$data->dictionary ? count($data->dictionary)." dictionary" :"no"',
			'filter'=>'',
			),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>