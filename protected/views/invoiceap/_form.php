<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php echo $form->hiddenField($model,'invoiceid'); ?>
     
	<table class="table-condensed" style="width:100%">
	<tr> 
			<td>
		<div class="row">
          <?php echo $form->labelEx($model,'invoicedate'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'invoicedate',
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
                  'size'=>'15',
              ),
          ));?>          <?php echo $form->error($model,'invoicedate'); ?>
        </div>
		</td>
		<td>
		<div class="row">
          <?php echo $form->labelEx($model,'poheaderid'); ?>
          <?php echo $form->hiddenField($model,'poheaderid'); ?>
    <input type="text" name="pono" id="pono" readonly>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'po_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Purchase Order'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						$poheader=new Poheader('searchwfstatus');
	  $poheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Poheader']))
		$poheader->attributes=$_GET['Poheader'];
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'po-grid',
        'dataProvider'=>$poheader->searchwfinvstatus(),
        'filter'=>$poheader,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#po_dialog\").dialog(\"close\"); $(\"#pono\").val(\"$data->pono\"); 
		  $(\"#Invoice_poheaderid\").val(\"$data->poheaderid\");
		  $(\"#Invoice_invoicedate\").val(\"$data->docdate\");
		  generatedata();
		  "))',
          ),
	array('name'=>'poheaderid', 'visible'=>false,
        'value'=>'$data->poheaderid','htmlOptions'=>array('width'=>'1%')),
          'pono',
          	array('name'=>'addressbookid','value'=>'($data->supplier!==null)?$data->supplier->fullname:""'),
          	array(
      'name'=>'docdate',
      'type'=>'raw',
         'value'=>'($data->docdate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->docdate)):""'
     ),

        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$.fn.yiiGridView.update("po-grid");$("#po_dialog").dialog("open"); return false;',
                       ))?>
          <?php echo $form->error($model,'poheaderid'); ?>
        </div>
		</td>				
				<td>
		<div class="row">
          <?php echo $form->labelEx($model,'invoiceno'); ?>
          <?php echo $form->textField($model,'invoiceno'); ?>
          <?php echo $form->error($model,'invoiceno'); ?>
        </div>
	</td>
		</tr>
		<tr>
		<td>
		<div class="row">
          <?php echo $form->labelEx($model,'amount'); ?>
          <?php echo $form->textField($model,'amount'); ?>
          <?php echo $form->error($model,'amount'); ?>
        </div>
		</td>
		<td>
		<?php echo $form->labelEx($model,'currencyid'); ?>
    <?php echo $form->hiddenField($model,'currencyid'); ?>
    <input type="text" name="currencyname" id="currencyname" readonly>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'currency_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Currency'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						$currency=new Currency('searchwfstatus');
	  $currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$currency->attributes=$_GET['Currency'];
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'currency-grid',
        'dataProvider'=>$currency->searchwstatus(),
        'filter'=>$currency,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#currency_dialog\").dialog(\"close\"); $(\"#currencyname\").val(\"$data->currencyname\"); 
		  $(\"#Invoice_currencyid\").val(\"$data->currencyid\");"))',
          ),
	array('name'=>'currencyid', 'visible'=>false,
        'value'=>'$data->currencyid','htmlOptions'=>array('width'=>'1%')),
          'currencyname',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$.fn.yiiGridView.update("currency-grid");$("#currency_dialog").dialog("open"); return false;',
                       ))?>
    <?php echo $form->error($model,'addressbookid'); ?>
		</td>
		<td>
		<div class="row">
          <?php echo $form->labelEx($model,'rate'); ?>
          <?php echo $form->textField($model,'rate'); ?>
          <?php echo $form->error($model,'rate'); ?>
        </div>
		</td>	
		<tr>	
<td>
		<?php echo $form->labelEx($model,'taxid'); ?>
    <?php echo $form->hiddenField($model,'taxid'); ?>
    <input type="text" name="taxcode" id="taxcode" readonly>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'tax_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Tax'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						$tax=new Tax('searchwfstatus');
	  $tax->unsetAttributes();  // clear any default values
	  if(isset($_GET['Tax']))
		$tax->attributes=$_GET['Tax'];
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'tax-grid',
        'dataProvider'=>$tax->searchwstatus(),
        'filter'=>$tax,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#tax_dialog\").dialog(\"close\"); $(\"#taxcode\").val(\"$data->taxcode\"); 
		  $(\"#Invoice_taxid\").val(\"$data->taxid\");"))',
          ),
	array('name'=>'taxid', 'visible'=>false,
        'value'=>'$data->taxid','htmlOptions'=>array('width'=>'1%')),
          'taxcode',
		  'taxvalue'
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$.fn.yiiGridView.update("tax-grid");$("#tax_dialog").dialog("open"); return false;',
                       ))?>
    <?php echo $form->error($model,'taxid'); ?>
		</td>

<td>
		<?php echo $form->labelEx($model,'paymentmethodid'); ?>
    <?php echo $form->hiddenField($model,'paymentmethodid'); ?>
    <input type="text" name="paycode" id="paycode" readonly>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'pay_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Payment Method'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						$paymentmethod=new Paymentmethod('searchwfstatus');
	  $paymentmethod->unsetAttributes();  // clear any default values
	  if(isset($_GET['Paymentmethod']))
		$paymentmethod->attributes=$_GET['Paymentmethod'];
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'pay-grid',
        'dataProvider'=>$paymentmethod->searchwstatus(),
        'filter'=>$paymentmethod,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#pay_dialog\").dialog(\"close\"); $(\"#paycode\").val(\"$data->paycode\"); 
		  $(\"#Invoice_paymentmethodid\").val(\"$data->paymentmethodid\");"))',
          ),
	array('name'=>'paymentmethodid', 'visible'=>false,
        'value'=>'$data->paymentmethodid','htmlOptions'=>array('width'=>'1%')),
          'paycode',
		  'paydays'
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$.fn.yiiGridView.update("pay-grid");$("#pay_dialog").dialog("open"); return false;',
                       ))?>
    <?php echo $form->error($model,'paymentmethodid'); ?>
		</td>
	<td>
		<div class="row">
          <?php echo $form->labelEx($model,'headernote'); ?>
          <?php echo $form->textArea($model,'headernote'); ?>
          <?php echo $form->error($model,'headernote'); ?>
        </div>
		</td>		
		</tr>
		<tr>
<td>
		<div class="row">
          <?php echo $form->labelEx($model,'fpno'); ?>
          <?php echo $form->textField($model,'fpno'); ?>
          <?php echo $form->error($model,'fpno'); ?>
        </div>
		</td>			
		<td>
		<div class="row">
          <?php echo $form->labelEx($model,'fpdate'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'fpdate',
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
                  'size'=>'15',
              ),
          ));?>          <?php echo $form->error($model,'fpdate'); ?>
        </div>
		</td>			</tr>
	</tr>
	</table>
	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('invoiceap/write'),
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
		array('invoiceap/cancelwrite'),
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
         'Detail' => array('content' => $this->renderPartial('indexinvoicedet',
			 array('invoicedet'=>$invoicedet),true)),
         'Journal' => array('content' => $this->renderPartial('indexinvoiceacc',
			 array('invoiceacc'=>$invoiceacc),true)),
/*         'Informal' => array('content' => $this->renderPartial('indexinformal',
			 array('employeeinformal'=>$employeeinformal),true)),
         'Working Experience' => array('content' => $this->renderPartial('indexwo',
			 array('employeewo'=>$employeewo),true)),
         'Family' => array('content' => $this->renderPartial('indexfamily',
			 array('employeefamily'=>$employeefamily),true)),*/
	),
	// additional javascript options for the tabs plugin
	'options' => array(
		'collapsible' => true,
	),
));?>
</div><!-- form -->
