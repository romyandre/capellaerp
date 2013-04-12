<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Real Name</span>
    <span class="cell"><input type="text" name="search_realname" id="search_realname"></span>
</div>
<div class="rowdata">	
	<span class="cell">User Name</span>
    <span class="cell"><input type="text" name="search_username" id="search_username"></span>
</div>
<div class="rowdata">	
	<span class="cell">Theme</span>
    <span class="cell"><input type="text" name="search_theme" id="search_theme"></span>
</div>
<div class="rowdata">	
	<span class="cell">Background</span>
    <span class="cell"><input type="text" name="search_background" id="search_background"></span>
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
                        "realname": $("#search_realname").val(),
						"username": $("#search_username").val(),
						"theme": $("#search_theme").val(),
						"background": $("#search_background").val(),
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