<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">Supplier</span>
    <span class="cell"><input type="text" name="search_fullname" id="search_fullname"></span>
</div>
<div class="rowdata">
	<span class="cell">Material Master / Service</span>
    <span class="cell"><input type="text" name="search_productname" id="search_productname"></span>
</div>
<div class="rowdata">
	<span class="cell">Purchasing Group Code</span>
    <span class="cell"><input type="text" name="search_purchasinggroupcode" id="search_purchasinggroupcode"></span>
</div>
<div class="rowdata">
	<span class="cell">Purchasing Group Description</span>
    <span class="cell"><input type="text" name="search_purchasinggroupdesc" id="search_purchasinggroupdesc"></span>
</div>
<div class="rowdata">
	<span class="cell">Price</span>
    <span class="cell"><input type="text" name="search_pricestart" id="search_pricestart">-
    <input type="text" name="search_priceend" id="search_priceend"></span>
</div>
<div class="rowdata">
	<span class="cell">Start Date</span>
    <span class="cell"><?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'name'=>'search_startdate',
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'1900:+0'
              ),
          ));?>-<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'name'=>'search_enddate',
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'1900:+0'
              ),
          ));?></span>
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
                        "fullname": $("#search_fullname").val(),
						"productname": $("#search_productname").val(),
						"purchasinggroupcode": $("#search_purchasinggroupcode").val(),
						"purchasinggroupdesc": $("#search_purchasinggroupdesc").val(),
						"pricestart": $("#search_pricestart").val(),
						"priceend": $("#search_priceend").val(),
						"startdate": $("#search_startdate").val(),
						"enddate": $("#search_enddate").val(),
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