<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Menu Name</span>
    <span class="cell"><input type="text" name="search_menuname" id="search_menuname"></span>
	<span class="cell">Menu Code</span>
    <span class="cell"><input type="text" name="search_menucode" id="search_menucode"></span>
</div>
<div class="rowdata">
	<span class="cell">Menu Url</span>
    <span class="cell"><input type="text" name="search_menuurl" id="search_menuurl"></span>
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
                        "menuname": $("#search_menuname").val(),
						"menucode": $("#search_menucode").val(),
						"menuurl": $("#search_menuurl").val(),
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