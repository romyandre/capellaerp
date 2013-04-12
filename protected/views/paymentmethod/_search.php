<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Pay Code</span>
    <span class="cell"><input type="text" name="search_paycode" id="search_paycode"></span>
</div>
<div class="rowdata">
	<span class="cell">Pay Days</span>
    <span class="cell"><input type="text" name="search_paydays" id="search_paydays"></span>
</div>
<div class="rowdata">
	<span class="cell">Payment Name</span>
    <span class="cell"><input type="text" name="search_paymentname" id="search_paymentname"></span>
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
                        "paycode": $("#search_paycode").val(),
						"paydays": $("#search_paydays").val(),
						"paymentname": $("#search_paymentname").val(),
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