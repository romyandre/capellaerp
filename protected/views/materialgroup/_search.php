<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Material Group Code</span>
    <span class="cell"><input type="text" name="search_matgroupcode" id="search_matgroupcode"></span>
	<span class="cell">Description</span>
    <span class="cell"><input type="text" name="search_matgroupdesc" id="search_matgroupdesc"></span>
</div>
<div class="rowdata">
	<span class="cell">Material Type Code</span>
    <span class="cell"><input type="text" name="search_mattypecode" id="search_mattypecode"></span>
	<span class="cell">Material Type Description</span>
    <span class="cell"><input type="text" name="search_mattypedesc" id="search_mattypedesc"></span>
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
                        "materialgroupcode": $("#search_matgroupcode").val(),
						"description": $("#search_matgroupdesc").val(),
						"materialtypecode": $("#search_mattypecode").val(),
						"materialtypedesc": $("#search_mattypedesc").val(),
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