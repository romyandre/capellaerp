<?php
$yearfrom=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultYearFrom']);
$yearto=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultYearTo']);
?>
<script type="text/javascript">
function helpdata(value) {
$('#helpdialog').dialog('open');
return false;
}
</script>
<script type="text/javascript">
function showdetail() {
    $.fn.yiiGridView.update('datagrid', {
                    data: {
                        'Genledger[accountid]': $('#accountid').val()
                    }
                });
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'helpdialog',
    'options'=>array(
        'title'=>'Help',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divhelp"></div>
<?php $this->endWidget();?>
<h1><?php echo Catalogsys::model()->GetCatalog('genledger') ?></h1>
<form action="index.php?r=genledger/index" method="POST">
Date : <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'startperiod',
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'changeYear'=>true,
				  'changeMonth'=>true
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
- <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'endperiod',
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'changeYear'=>true,
				  'changeMonth'=>true
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?><br>
Account Code : <input type="hidden" name="accountid" id="accountid"  />
	  <input type="text" name="accountcode" id="accountcode" title="Enter Schedule name" readonly>
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'account_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Account'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$account=new Account('searchwstatus');
	 $account->unsetAttributes();  // clear any default values
	  if(isset($_GET['Account']))
		$account->attributes=$_GET['Account'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'account-grid',
      'dataProvider'=>$account->Searchwstatus(),
      'filter'=>$account,
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
          "onClick" => "$(\"#account_dialog\").dialog(\"close\"); $(\"#accountcode\").val(\"$data->accountcode\");$(\"#accountid\").val(\"$data->accountid\");
		  "))',
          ),
        'accountid',
        'accountcode',
          'accountname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#account_dialog").dialog("open"); return false;',
                       ))?>
<br/><button name="submit" type="submit">Submit</button>
</form>


