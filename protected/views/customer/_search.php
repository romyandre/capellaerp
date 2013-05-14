<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Customer</span>
    <span class="cell"><input type="text" name="search_suppliername" id="search_suppliername"></span>
</div>
<div class="rowdata">
	<span class="cell">Contact Phone No</span>
    <span class="cell"><input type="text" name="search_contactphoneno" id="search_contactphoneno"></span>
</div>
<div class="rowdata">
	<span class="cell">Address Phone No</span>
    <span class="cell"><input type="text" name="search_addressphoneno" id="search_addressphoneno"></span>
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
                        "fullname": $("#search_suppliername").val(),
						"contactphoneno" : $("#search_contactphoneno").val(),
						"addressphoneno" : $("#search_addressphoneno").val(),
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