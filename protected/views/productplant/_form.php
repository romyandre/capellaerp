<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'productplant-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'productplantid'); ?>
	<div id="tabledata">
<div class="rowdata">
<span class="cell">
		<?php echo $form->labelEx($model,'productid'); ?>
		<?php echo $form->hiddenField($model,'productid'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="productname" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'product_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Material Master / Service'),
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
          'value'=>'CHtml::Button("V",
          array("name" => "send_product",
          "id" => "send_product",
          "onClick" => "$(\"#product_dialog\").dialog(\"close\"); $(\"#productname\").val(\"$data->productname\"); $(\"#Productplant_productid\").val(\"$data->productid\");
		  "))',
          ),
          	array('name'=>'productid', 'visible'=>false,'value'=>'$data->productid','htmlOptions'=>array('width'=>'1%')),
        'productname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#product_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'slocid'); ?>
	  <?php echo $form->hiddenField($model,'slocid'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="sloccode" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'sloc_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Storage Location'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'absschedule-grid',
      'dataProvider'=>$sloc->Searchwstatus(),
      'filter'=>$sloc,
	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#sloc_dialog\").dialog(\"close\"); $(\"#sloccode\").val(\"$data->description\"); $(\"#Productplant_slocid\").val(\"$data->slocid\");
		  "))',
          ),
	array('name'=>'slocid', 'visible'=>false,'value'=>'$data->slocid','htmlOptions'=>array('width'=>'1%')),
		array('name'=>'plantid', 'value'=>'$data->plant->plantcode'),
        'sloccode',
        'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#sloc_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'unitofissue'); ?>
	  <?php echo $form->hiddenField($model,'unitofissue'); ?></span>
		<span class="cell"><input type="text" name="sched_name" id="unitofissueuomcode" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'orderunit_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Unit of Measure'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'fromuom-grid',
      'dataProvider'=>$unitofissue->Searchwstatus(),
      'filter'=>$unitofissue,
	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_fromuom",
          "id" => "send_fromuom",
          "onClick" => "$(\"#orderunit_dialog\").dialog(\"close\"); $(\"#unitofissueuomcode\").val(\"$data->uomcode\"); $(\"#Productplant_unitofissue\").val(\"$data->unitofmeasureid\");
		  "))',
          ),
	array('name'=>'unitofmeasureid', 'visible'=>false,'value'=>'$data->unitofmeasureid','htmlOptions'=>array('width'=>'1%')),
        'uomcode',
		'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#orderunit_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'isautolot'); ?></span>
		<span class="cell"><?php echo $form->checkBox($model,'isautolot'); ?></span>
	</div>
	
	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'snroid'); ?>
	  <?php echo $form->hiddenField($model,'snroid'); ?></span>
		<span class="cell"><input type="text" name="description" id="description" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'snro_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Specific Number Range Object'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'snro-grid',
      'dataProvider'=>$snro->Searchwstatus(),
      'filter'=>$snro,
	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_fromuom",
          "id" => "send_fromuom",
          "onClick" => "$(\"#snro_dialog\").dialog(\"close\"); $(\"#description\").val(\"$data->description\"); $(\"#Productplant_snroid\").val(\"$data->snroid\");
		  "))',
          ),
	array('name'=>'snroid', 'visible'=>false,'value'=>'$data->snroid','htmlOptions'=>array('width'=>'1%')),
        'formatdoc',
		'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#snro_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
	    
    	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
		<span class="cell"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
	</div>

	<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('productplant/write'),
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
		array('productplant/cancelwrite'),
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