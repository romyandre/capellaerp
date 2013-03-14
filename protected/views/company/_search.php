<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Company</span>
    <span class="cell"><input type="text" name="search_companyname" id="search_companyname"></span>
	<span class="cell">Address</span>
    <span class="cell"><input type="text" name="search_address" id="search_address"></span>
</div>
<div class="rowdata">
	<span class="cell">City</span>
    <span class="cell"><input type="text" name="search_city" id="search_city"></span>
	<span class="cell">Zip Code</span>
    <span class="cell"><input type="text" name="search_zip" id="search_zip"></span>
</div>
<div class="rowdata">
	<span class="cell">Fax No</span>
    <span class="cell"><input type="text" name="search_faxno" id="search_faxno"></span>
	<span class="cell">Phone No</span>
    <span class="cell"><input type="text" name="search_phoneno" id="search_phoneno"></span>
</div>
<div class="rowdata">
	<span class="cell">Web Address</span>
    <span class="cell"><input type="text" name="search_webaddress" id="search_webaddress"></span>
	<span class="cell">Email</span>
    <span class="cell"><input type="text" name="search_email" id="search_email"></span>
</div>
<div class="rowdata">
	<span class="cell">Tax No</span>
    <span class="cell"><input type="text" name="search_taxno" id="search_taxno"></span>
	<span class="cell">Base Currency</span>
    <span class="cell"><input type="text" name="search_currency" id="search_currency"></span>
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
                        "companyname": $("#search_companyname").val(),
						"address": $("#search_address").val(),
						"city": $("#search_city").val(),
						"zip": $("#search_zip").val(),
						"faxno": $("#search_faxno").val(),
						"phoneno": $("#search_phoneno").val(),
						"webaddress": $("#search_webaddress").val(),
						"email": $("#search_email").val(),
						"taxno": $("#search_taxno").val(),
						"currency": $("#search_currency").val(),
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