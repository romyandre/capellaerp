<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'absrule-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'accounttypeid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'accounttypename'); ?>
		<?php echo $form->textField($model,'accounttypename'); ?>
		<?php echo $form->error($model,'accounttypename'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'parentaccounttypeid'); ?>
		<?php echo $form->hiddenField($model,'parentaccounttypeid'); ?>
    <input type="text" name="parentaccounttypename" id="parentaccounttypename" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'parentaccounttype_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Account Type'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'parentaccounttype-grid',
        'dataProvider'=>$parentaccounttype->searchwstatus(),
        'filter'=>$parentaccounttype,
			'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#parentaccounttype_dialog\").dialog(\"close\");
          $(\"#parentaccounttypename\").val(\"$data->accounttypename\");
          $(\"#Accounttype_parentaccounttypeid\").val(\"$data->accounttypeid\");"))',
          ),
	array('name'=>'accounttypeid', 'visible'=>false,
        'value'=>'$data->accounttypeid','htmlOptions'=>array('width'=>'1%')),
          'accounttypename',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#parentaccounttype_dialog").dialog("open"); return false;',
                       ))
    ?>
		<?php echo $form->error($model,'parentaccountid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
    <?php echo $form->checkBox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>

	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('accounttype/write'),
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
		array('accounttype/cancelwrite'),
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
</div><!-- form -->
