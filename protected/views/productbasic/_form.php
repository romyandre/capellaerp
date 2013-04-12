<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'productbasic-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'productbasicid'); ?>
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
                                'title'=>Yii::t('app','Material Master'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'product-grid',
      'dataProvider'=>$product->searchwstatus(),
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
          "onClick" => "$(\"#product_dialog\").dialog(\"close\"); $(\"#productname\").val(\"$data->productname\"); $(\"#Productbasic_productid\").val(\"$data->productid\");
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
		<span class="cell"><?php echo $form->labelEx($model,'baseuom'); ?>
	  <?php echo $form->hiddenField($model,'baseuom'); ?></span>
	 <span class="cell"> <input type="text" name="sched_name" id="uomcode" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'baseuom_dialog',
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
      'dataProvider'=>$baseuom->Searchwstatus(),
      'filter'=>$baseuom,
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
          "onClick" => "$(\"#baseuom_dialog\").dialog(\"close\"); $(\"#uomcode\").val(\"$data->uomcode\"); $(\"#Productbasic_baseuom\").val(\"$data->unitofmeasureid\");
		  "))',
          ),
	array('name'=>'unitofmeasureid', 'visible'=>false,'value'=>'$data->unitofmeasureid','htmlOptions'=>array('width'=>'1%')),
        'uomcode',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#baseuom_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
        <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'materialgroupid'); ?>
 <?php echo $form->hiddenField($model,'materialgroupid'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="materialgroupcode" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'materialgroup_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Material Group'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'materialgroup-grid',
      'dataProvider'=>$materialgroup->Searchwstatus(),
      'filter'=>$materialgroup,
	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_materialgroup",
          "id" => "send_materialgroup",
          "onClick" => "$(\"#materialgroup_dialog\").dialog(\"close\"); $(\"#materialgroupcode\").val(\"$data->materialgroupcode\"); $(\"#Productbasic_materialgroupid\").val(\"$data->materialgroupid\");
		  "))',
          ),
	array('name'=>'materialgroupid', 'visible'=>false,'value'=>'$data->materialgroupid','htmlOptions'=>array('width'=>'1%')),
        'materialgroupcode',
        'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#materialgroup_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
            <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'oldmatno'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'oldmatno',array('size'=>30,'maxlength'=>30)); ?></span>
	</div>
          <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'grossweight'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'grossweight',array('size'=>10,'maxlength'=>10)); ?></span>
	</div>
          <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'weightunit'); ?>
<?php echo $form->hiddenField($model,'weightunit'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="weightuomcode" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'weightunit_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Weight Unit'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'weightunit-grid',
      'dataProvider'=>$weightunit->Searchwstatus(),
      'filter'=>$weightunit,
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
          "onClick" => "$(\"#weightunit_dialog\").dialog(\"close\"); $(\"#weightuomcode\").val(\"$data->uomcode\"); $(\"#Productbasic_weightunit\").val(\"$data->unitofmeasureid\");
		  "))',
          ),
	array('name'=>'unitofmeasureid', 'visible'=>false,'value'=>'$data->unitofmeasureid','htmlOptions'=>array('width'=>'1%')),
        'uomcode',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#weightunit_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
          <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'netweight'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'netweight',array('size'=>10,'maxlength'=>10)); ?></span>
	</div>
          <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'volume'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'volume',array('size'=>10,'maxlength'=>10)); ?></span>
	</div>
          <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'volumeunit'); ?>
 <?php echo $form->hiddenField($model,'volumeunit'); ?></span>
	 <span class="cell"> <input type="text" name="sched_name" id="volumeuomcode" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'volumeunit_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Volume Unit'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'volumeunit-grid',
      'dataProvider'=>$volumeunit->Searchwstatus(),
      'filter'=>$volumeunit,
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
          "onClick" => "$(\"#volumeunit_dialog\").dialog(\"close\"); $(\"#volumeuomcode\").val(\"$data->uomcode\"); $(\"#Productbasic_volumeunit\").val(\"$data->unitofmeasureid\");
		  "))',
          ),
	array('name'=>'unitofmeasureid', 'visible'=>false,'value'=>'$data->unitofmeasureid','htmlOptions'=>array('width'=>'1%')),
        'uomcode',
        'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#volumeunit_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
          <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'sizedimension'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'sizedimension',array('size'=>50,'maxlength'=>50)); ?></span>
	</div>
          <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'materialpackage'); ?>
 <?php echo $form->hiddenField($model,'materialpackage'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="materialname" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'materialpackage_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Material Package'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'matpack-grid',
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
          "onClick" => "$(\"#materialpackage_dialog\").dialog(\"close\"); $(\"#materialname\").val(\"$data->productname\"); $(\"#Productbasic_materialpackage\").val(\"$data->productid\");
		  "))',
          ),
	array('name'=>'productid', 'visible'=>false,'value'=>'$data->productid','htmlOptions'=>array('width'=>'1%')),
        'productname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#materialpackage_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
          <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
    <span class="cell"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
	</div>

	<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('productbasic/write'),
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
		array('productbasic/cancelwrite'),
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