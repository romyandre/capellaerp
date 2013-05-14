<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'subdistrict-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'subdistrictid'); ?>
	<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'cityid'); ?>
<?php echo $form->hiddenField($model,'cityid'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="cityname" title="Enter Schedule name" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'country_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','City'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$city=new City('searchwstatus');
	  $city->unsetAttributes();  // clear any default values
	  if(isset($_GET['City']))
		$city->attributes=$_GET['City'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'product-grid',
      'dataProvider'=>$city->Searchwstatus(),
      'filter'=>$city,
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
          "onClick" => "$(\"#country_dialog\").dialog(\"close\"); $(\"#cityname\").val(\"$data->cityname\"); $(\"#Subdistrict_cityid\").val(\"$data->cityid\");
		  "))',
          ),
	array('name'=>'cityid', 'visible'=>false,'value'=>'$data->cityid','htmlOptions'=>array('width'=>'1%')),
        'cityname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#country_dialog").dialog("open"); return false;',
                       ))?></span>	
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'subdistrictname'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'subdistrictname',array('size'=>50,'maxlength'=>50)); ?></span>
	</div>

		<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'zipcode'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'zipcode',array('size'=>10,'maxlength'=>10)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
		<span class="cell"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
	</div>

	<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('subdistrict/write'),
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
		array('subdistrict/cancelwrite'),
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