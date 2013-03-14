<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Description</span>
    <span class="cell"><input type="text" name="search_desc" id="search_desc"></span>
	<span class="cell">Current Day</span>
    <span class="cell"><input type="text" name="search_curdd" id="search_curdd"></span>
</div>
<div class="rowdata">
	<span class="cell">Current Month</span>
    <span class="cell"><input type="text" name="search_curmm" id="search_curmm"></span>
	<span class="cell">Current Year</span>
    <span class="cell"><input type="text" name="search_curyy" id="search_curyy"></span>
</div>
<div class="rowdata">
<span class="cell">
<?php
$imgsearch=CHtml::image(Yii::app()->request->baseUrl.'/images/search.png');
echo CHtml::link($imgsearch,'#',array(
		   'style'=>'cursor: pointer; text-decoration: underline;',
		   'onclick'=>'{
				$.fn.yiiGridView.update("datagrid", {
                    data: {
                        "description": $("#search_desc").val(),
						"curdd": $("#search_curdd").val(),
						"curmm": $("#search_curmm").val(),
						"curyy": $("#search_curyy").val(),
                    }
					});
				$("#searchdialog").dialog("close");
		   }',
			'id'=>'search',
			'title'=>Catalogsys::model()->getcatalog('searchdata')
		));
		?></span>
</div>
</div>   
<?php $this->endWidget(); ?>
</div><!-- form -->