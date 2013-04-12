<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Account Type</span>
    <span class="cell"><input type="text" name="search_accounttypename" id="search_accounttypename"></span>
</div>
<div class="rowdata">
	<span class="cell">Parent Account Type</span>
    <span class="cell"><input type="text" name="search_parentaccounttypename" id="search_parentaccounttypename"></span>
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
                        "accounttypename": $("#search_accounttypename").val(),
						"parentaccounttypename": $("#search_parentaccounttypename").val(),
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