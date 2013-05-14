<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'province-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'provinceid'); ?>
	<div id="tabledata">
<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'countryid'); ?>
<?php echo $form->hiddenField($model,'countryid'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="countryname" title="Enter Schedule name" readonly ">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'country_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Country'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$country=new Country('searchwstatus');
	  $country->unsetAttributes();  // clear any default values
	  if(isset($_GET['Country']))
		$country->attributes=$_GET['Country'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'product-grid',
      'dataProvider'=>$country->Searchwstatus(),
      'filter'=>$country,
	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_product",
          "id" => "send_product",
          "onClick" => "$(\"#country_dialog\").dialog(\"close\"); $(\"#countryname\").val(\"$data->countryname\"); $(\"#Province_countryid\").val(\"$data->countryid\");
		  "))',
          ),
	array('name'=>'countryid', 'visible'=>false,'value'=>'$data->countryid','htmlOptions'=>array('width'=>'1%')),
        'countryname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#country_dialog").dialog("open"); return false;',
                       ))?>	</span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'provincename'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'provincename',array('size'=>60,'maxlength'=>100)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
		<span class="cell"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
	</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('province/write'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
				$.fn.yiiGridView.update("datagrid");
				$("#createdialog").dialog("close");
				toastr.info(x.div);
			}
			else
			{
				toastr.error(x.div);
			}
        }')); ?><?php echo CHtml::ajaxSubmitButton('Cancel',
		array('province/cancelwrite'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
				$.fn.yiiGridView.update("datagrid");			  
				$("#createdialog").dialog("close");
				toastr.info(x.div);
			}
			else
			{
				toastr.error(x.div);
			}
        }')); ?></span>
</div>
</div>   
<?php $this->endWidget(); ?>
</div><!-- form -->
