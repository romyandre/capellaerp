<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'grheader-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>
	
<?php echo $form->hiddenField($model,'grheaderid'); ?>
	<table>
	  <tr>
	  <td>
		<div class="row">
          <?php echo $form->labelEx($model,'grdate'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'grdate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
             'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'-10:+10'
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>          <?php echo $form->error($model,'grdate'); ?>
        </div>
		</td>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'poheaderid'); ?>
    <?php echo $form->hiddenField($model,'poheaderid'); ?>
    <input type="text" name="pono" id="pono" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'poheader_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Purchase Order'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'absstatus-grid',
        'dataProvider'=>$poheader->searchwfqtystatus(),
        'filter'=>$poheader,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#poheader_dialog\").dialog(\"close\");
          $(\"#pono\").val(\"$data->pono\");
          $(\"#Grheader_poheaderid\").val(\"$data->poheaderid\");
          generatedata1();"))',
          ),
	array('name'=>'poheaderid', 'visible'=>false, 'value'=>'$data->poheaderid'),
          'pono',
	array('name'=>'addressbookid', 'value'=>'$data->supplier!==null?$data->supplier->fullname:""'),
			 array('name'=>'docdate', 
			 'header'=>'PO Date',
			 'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->docdate))'),
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$.fn.yiiGridView.update("absstatus-grid");$("#poheader_dialog").dialog("open"); return false;',
                       ))
    ?>
		<?php echo $form->error($model,'poheaderid'); ?>
	</div>
		</td>
        <td>
		  <div class="row">
		<?php echo $form->labelEx($model,'giheaderid'); ?>
    <?php echo $form->hiddenField($model,'giheaderid'); ?>
    <input type="text" name="pono" id="gino" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'giheader_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Goods Issue'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'giheader-grid',
        'dataProvider'=>$giheader->searchwfgstatus(),
        'filter'=>$giheader,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#giheader_dialog\").dialog(\"close\");
          $(\"#gino\").val(\"$data->gino\");
          $(\"#Grheader_giheaderid\").val(\"$data->giheaderid\");
          generatedata2();"))',
          ),
          'giheaderid',
          'gino',
            'gidate',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$.fn.yiiGridView.update("giheader-grid");$("#giheader_dialog").dialog("open"); return false;',
                       ))
    ?>
		<?php echo $form->error($model,'poheaderid'); ?>
	</div>
		</td>
	  </tr>
	</table>
		<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('grheader/write'),
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
		array('grheader/cancelwrite'),
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
			array('grdetail'=>$grdetail),true)),
	),
	// additional javascript options for the tabs plugin
	'options' => array(
		'collapsible' => true,
	),
));?>
</div><!-- form -->