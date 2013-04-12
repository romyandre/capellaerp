<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Plant Code</span>
    <span class="cell"><input type="text" name="search_plantcode" id="search_plantcode"></span>
</div>
<div class="rowdata">
	<span class="cell">Plant Description</span>
    <span class="cell"><input type="text" name="search_plantdescription" id="search_plantdescription"></span>
</div>
<div class="rowdata">
	<span class="cell">Sloc Code</span>
    <span class="cell"><input type="text" name="search_sloccode" id="search_sloccode"></span>
</div>
<div class="rowdata">
	<span class="cell">Description</span>
    <span class="cell"><input type="text" name="search_description" id="search_description"></span>
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
                        "plantcode": $("#search_plantcode").val(),
						"plantdescription": $("#search_plantdescription").val(),
						"sloccode": $("#search_sloccode").val(),
						"description": $("#search_description").val(),
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