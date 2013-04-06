<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Subdistrict</span>
    <span class="cell"><input type="text" name="search_subdistrict" id="search_subdistrict"></span>
</div>
<div class="rowdata">
	<span class="cell">Sub Subdistrict</span>
    <span class="cell"><input type="text" name="search_kelurahan" id="search_kelurahan"></span>
</div>
<div class="rowdata">
	<span class="cell">Zip Code</span>
    <span class="cell"><input type="text" name="search_zip" id="search_zip"></span>
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
                        "subdistrictname": $("#search_subdistrict").val(),
						"kelurahanname": $("#search_kelurahan").val(),
						"zip": $("#search_zip").val(),
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