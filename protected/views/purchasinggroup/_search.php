<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Purchasing Organization (code)</span>
    <span class="cell"><input type="text" name="search_purchasingorgcode" id="search_purchasingorgcode"></span>
</div>
<div class="rowdata">
	<span class="cell">Purchasing Organization (description)</span>
    <span class="cell"><input type="text" name="search_purchdesc" id="search_purchdesc"></span>
</div>
<div class="rowdata">
	<span class="cell">Purchasing Group Code</span>
    <span class="cell"><input type="text" name="search_purchasinggroupcode" id="search_purchasinggroupcode"></span>
</div>
<div class="rowdata">
	<span class="cell">Purchasing Group Description</span>
    <span class="cell"><input type="text" name="search_purchasinggroupdesc" id="search_purchasinggroupdesc"></span>
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
                        "purchasingorgcode": $("#search_purchasingorgcode").val(),
						"purchasingorgdesc": $("#search_purchdesc").val(),
						"purchasingroupcode": $("#search_purchasinggroupcode").val(),
						"purchasinggroupdesc": $("#search_purchasinggroupdesc").val(),
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