<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'prmaterial-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php echo $form->hiddenField($model,'prmaterialid'); ?>
<?php echo $form->hiddenField($model,'prheaderid'); ?>
	<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'productid'); ?>
<?php echo $form->hiddenField($model,'productid'); ?></span>
       <span class="cell"><input type="text" name="product_name" id="productname" title="Account name" style="width: 200px" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'product_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Material Master'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'product-grid',
      'dataProvider'=>$product->Searchwstatus(),
      'filter'=>$product,
	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#product_dialog\").dialog(\"close\"); $(\"#productname\").val(\"$data->productname\"); $(\"#Prmaterial_productid\").val(\"$data->productid\");
		  "))',
          ),
	array('name'=>'productid', 'visible'=>false,'value'=>'$data->productid'),
        'productname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#product_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
          <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'qty'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'qty'); ?></span>
	</div>
          <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'unitofmeasureid'); ?>
<?php echo $form->hiddenField($model,'unitofmeasureid'); ?></span>
	  <span class="cell"><input type="text" name="product_name" id="uomcode" title="Account name" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'uom_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Unit of Measure'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'uom-grid',
      'dataProvider'=>$unitofmeasure->Searchwstatus(),
      'filter'=>$unitofmeasure,
	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#uom_dialog\").dialog(\"close\"); $(\"#uomcode\").val(\"$data->uomcode\"); $(\"#Prmaterial_unitofmeasureid\").val(\"$data->unitofmeasureid\");
		  "))',
          ),
	array('name'=>'unitofmeasureid', 'visible'=>false,'value'=>'$data->unitofmeasureid'),
        'uomcode',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#uom_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
          <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'requestedbyid'); ?>
<?php echo $form->hiddenField($model,'requestedbyid'); ?></span>
	  <span class="cell"><input type="text" name="reqbyname" id="reqbyname" title="Account name" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'req_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Requested By'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'req-grid',
      'dataProvider'=>$requestedby->Searchwstatus(),
      'filter'=>$requestedby,
	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#req_dialog\").dialog(\"close\"); $(\"#reqbyname\").val(\"$data->description\"); $(\"#Prmaterial_requestedbyid\").val(\"$data->requestedbyid\");
		  "))',
          ),
	array('name'=>'requestedbyid', 'visible'=>false,'value'=>'$data->requestedbyid'),
        'requestedbycode',
          'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#req_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
            <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'reqdate'); ?></span>
		<span class="cell"><?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'reqdate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
                  'changeMonth'=>true,
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'15',
              ),
          ));?></span>
	</div>
           <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'itemtext'); ?></span>
		<span class="cell"><?php echo $form->textArea($model,'itemtext',array('rows'=>6, 'cols'=>50)); ?></span>
	</div>
	<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('prheader/writedetail'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
				$.fn.yiiGridView.update("detaildatagrid");
				$("#createdialog1").dialog("close");
				toastr.info(x.div);
			}
			else
			{
				toastr.error(x.div);
			}
        }')); ?><?php echo CHtml::ajaxSubmitButton('Cancel',
		array('prheader/cancelwritedetail'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
				$.fn.yiiGridView.update("detaildatagrid");			  
				$("#createdialog1").dialog("close");
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