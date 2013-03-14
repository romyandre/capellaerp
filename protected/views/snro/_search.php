<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Description</span>
    <span class="cell"><input type="text" name="search_desc" id="search_desc"></span>
	<span class="cell">Format Doc</span>
    <span class="cell"><input type="text" name="search_formatdoc" id="search_formatdoc"></span>
</div>
<div class="rowdata">
	<span class="cell">Format No</span>
    <span class="cell"><input type="text" name="search_formatno" id="search_formatno"></span>
	<span class="cell">Repeat By</span>
    <span class="cell"><input type="text" name="search_repeatby" id="search_repeatby"></span>
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
						"formatdoc": $("#search_formatdoc").val(),
						"formatno": $("#search_formatno").val(),
						"repeatby": $("#search_repeatby").val(),
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