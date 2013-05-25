<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Account Name</span>
    <span class="cell"><input type="text" name="search_accountname" id="search_accountname"></span>
</div>
<div class="rowdata">
	<span class="cell">Account Code</span>
    <span class="cell"><input type="text" name="search_accountcode" id="search_accountcode"></span>
</div>
<div class="rowdata">
	<span class="cell">Currency Name</span>
    <span class="cell"><input type="text" name="search_currencyname" id="search_currencyname"></span>
</div>
<div class="rowdata">
	<span class="cell">Account Type Name</span>
    <span class="cell"><input type="text" name="searchaccounttypename" id="search_accounttypename"></span>
</div>
<div class="rowdata">
	<span class="cell">Parent Account Name</span>
    <span class="cell"><input type="text" name="searchparentaccountname" id="searchparentaccountname"></span>
</div>
<div class="rowdata">
	<span class="cell">Parent Account Code</span>
    <span class="cell"><input type="text" name="searchparentaccountcode" id="searchparentaccountcode"></span>
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
                        "accountname": $("#search_accountname").val(),
						"accountcode": $("#search_accountcode").val(),
						"currencyname": $("#search_currencyname").val(),
						"accounttypename": $("#searchaccounttypename").val(),
						"parentaccountname": $("#searchparentaccountname").val(),
						"parentaccountcode": $("#searchparentaccountcode").val(),
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