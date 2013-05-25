<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'account-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'accountid'); ?>
	<div id="tabledialog">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'accounttypeid'); ?>
		<?php echo $form->hiddenField($model,'accounttypeid'); ?></span>
    <span class="cellform"><input type="text" name="stat_name" id="accounttypename" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'accounttype_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Account Type'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'accounttype-grid',
        'dataProvider'=>$accounttype->searchwstatus(),
        'filter'=>$accounttype,
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
          "onClick" => "$(\"#accounttype_dialog\").dialog(\"close\");
          $(\"#accounttypename\").val(\"$data->accounttypename\");
          $(\"#Account_accounttypeid\").val(\"$data->accounttypeid\");"))',
          ),
	array('name'=>'accounttypeid', 'visible'=>false,
        'value'=>'$data->accounttypeid','htmlOptions'=>array('width'=>'1%')),
          'accounttypename',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#accounttype_dialog").dialog("open"); return false;',
                       ))
    ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'accountname'); ?></span>
		<span class="cellform"><?php echo $form->textField($model,'accountname',array('size'=>50,'maxlength'=>50)); ?></span>
	</div>

		<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'accountcode'); ?></span>
		<span class="cellform"><?php echo $form->textField($model,'accountcode',array('size'=>20,'maxlength'=>20)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'parentaccountid'); ?>
		<?php echo $form->hiddenField($model,'parentaccountid'); ?></span>
    <span class="cellform"><input type="text" name="stat_name" id="parentaccountname" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'parentaccountcode_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Parent Account'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'parentaccountcode-grid',
        'dataProvider'=>$parentaccount->searchwstatus(),
        'filter'=>$parentaccount,
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
          "onClick" => "$(\"#parentaccountcode_dialog\").dialog(\"close\"); $(\"#parentaccountname\").val(\"$data->accountcode\"); $(\"#Account_parentaccountid\").val(\"$data->accountid\");"))',
          ),
	array('name'=>'accountid', 'visible'=>false,
        'value'=>'$data->accountid','htmlOptions'=>array('width'=>'1%')),
            'accountcode',
          'accountname',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#parentaccountcode_dialog").dialog("open"); return false;',
                       ))
    ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'currencyid'); ?>
		<?php echo $form->hiddenField($model,'currencyid'); ?></span>
    <span class="cellform"><input type="text" name="stat_name" id="currencyname" readonly >    
	<?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'currencyname_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Currency'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'currency-grid',
        'dataProvider'=>$currency->searchwstatus(),
        'filter'=>$currency,
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
          "onClick" => "$(\"#currencyname_dialog\").dialog(\"close\"); $(\"#currencyname\").val(\"$data->currencyname\"); $(\"#Account_currencyid\").val(\"$data->currencyid\");"))',
          ),
	array('name'=>'currencyid', 'visible'=>false,
        'value'=>'$data->currencyid','htmlOptions'=>array('width'=>'1%')),
          'currencyname',
		  'country.countryname',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#currencyname_dialog").dialog("open"); return false;',
                       ))
    ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
		<span class="cellform"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
	</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('account/write'),
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
		array('account/cancelwrite'),
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