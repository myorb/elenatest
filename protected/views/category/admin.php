<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Category', 'url'=>array('index')),
	array('label'=>'Create Category', 'url'=>array('create')),
);
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
$('#category-grid a.ajaxupdatestatus').live('click', function() {
        var that = $(this);
        $.ajax({
            type: 'POST',
            url: $(this).attr('href'),
            success: function(data) {
            	that.html(data);
            	// $.fn.yiiGridView.update('category-grid');
            }
        });
        return false;
});
");
?>

<h1>Manage Categories</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('ext.QTreeGridView.CQTreeGridView', array(
	'id'=>'category-grid',
	'ajaxUpdate' => false,
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		// 'id',
		// 'root',
		'price',
		array(
	        'name'=>'status',
	        'type'=>'raw',
	        'filter'=>array('not active','active'),
	        'value'=>'CHtml::link($data->status==1?"active":"not active", array("ajaxupdatestatus", "id"=>$data->id), array("class"=>"ajaxupdatestatus"));',
		),
		array(
			'header'=>'Relateion',
			'name'=>'id',
			'type'=>'raw',
			'value'=>'$data->dictionary ?"yes":"no"',
			'filter'=>'',
			),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
