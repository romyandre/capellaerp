<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'bsheader-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)};",
));  ?>
	
<?php echo $form->hiddenField($model,'bsheaderid'); ?>
	<table>
	  <tr>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'bsdate'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'bsdate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'1900:+0'
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'20',
              ),
          ));?>
		<?php echo $form->error($model,'bsdate'); ?>
	</div>
		</td>
			  <td>
		  <div class="row">
		<?php echo $form->labelEx($model,'headernote'); ?>
		<?php echo $form->textfield($model,'headernote'); ?>
		<?php echo $form->error($model,'headernote'); ?>
	</div>
		</td>
	  </tr>
	</table>
		<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('bsheader/write'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("datagrid");
			  $("#createdialog").dialog("close");
              document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
		<?php echo CHtml::ajaxSubmitButton('Cancel',
		array('bsheader/cancelwrite'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("datagrid");
			  $("#createdialog").dialog("close");
              document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
        </td>
      </tr>
    </table>

<?php $this->endWidget(); ?>
	<?php
	$this->widget('zii.widgets.jui.CJuiTabs', array(
	'tabs' => array(
		'Detail' => array('content' => $this->renderPartial('indexdetail',
			array('bsdetail'=>$bsdetail,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'currency'=>$currency,
					'ownership'=>$ownership,
					'materialstatus'=>$materialstatus,
				  'sloc'=>$sloc),true)),
	),
	// additional javascript options for the tabs plugin
	'options' => array(
		'collapsible' => true,
	),
));?>
</div><!-- form -->
