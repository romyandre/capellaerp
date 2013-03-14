<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Locked By</span>
    <span class="cell"><input type="text" name="search_lockedby" id="search_lockedby"></span>
	<span class="cell">Locked Date</span>
    <span class="cell"><input type="text" name="search_lockeddate" id="search_lockeddate"></span>
</div>
<div class="rowdata">
	<span class="cell">Menu Name</span>
    <span class="cell"><input type="text" name="search_menuname id="search_menuname"></span>
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
                        "lockedby": $("#search_lockedby").val(),
						"lockeddate": $("#search_lockeddate").val(),
						"menuname": $("#search_menuname").val(),
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