<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">User Name</span>
    <span class="cell"><input type="text" name="search_username" id="search_username"></span>
	<span class="cell">Created Date</span>
    <span class="cell"><input type="text" name="search_date" id="search_date"></span>
</div>
<div class="rowdata">
	<span class="cell">User Action</span>
    <span class="cell"><input type="text" name="search_useraction" id="search_useraction"></span>
	<span class="cell">New Data</span>
    <span class="cell"><input type="text" name="search_newdata" id="search_newdata"></span>
</div>
<div class="rowdata">
	<span class="cell">Old Data</span>
    <span class="cell"><input type="text" name="search_olddata" id="search_olddata"></span>
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
                        "username": $("#search_username").val(),
						"createddate": $("#search_date").val(),
						"useraction": $("#search_useraction").val(),
						"newdata": $("#search_newdata").val(),
						"olddata": $("#search_olddata").val(),
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