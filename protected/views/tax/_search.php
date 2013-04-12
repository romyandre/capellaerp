<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Tax Code</span>
    <span class="cell"><input type="text" name="search_taxcode" id="search_taxcode"></span>
</div>
<div class="rowdata">
	<span class="cell">Tax Value</span>
    <span class="cell"><input type="text" name="search_taxvalue" id="search_taxvalue"></span>
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
                        "taxcode": $("#search_taxcode").val(),
						"taxvalue": $("#search_taxvalue").val(),
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