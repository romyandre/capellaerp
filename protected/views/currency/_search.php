<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Country</span>
    <span class="cell"><input type="text" name="search_country" id="search_country"></span>
</div>
<div class="rowdata">
	<span class="cell">Currency</span>
    <span class="cell"><input type="text" name="search_currency" id="search_currency"></span>
</div>
<div class="rowdata">
	<span class="cell">Symbol</span>
    <span class="cell"><input type="text" name="search_symbol" id="search_symbol"></span>
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
                        "countryname": $("#search_country").val(),
						"currencyname": $("#search_currency").val(),
						"symbol": $("#search_symbol").val(),
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