<?php

class RepposummaryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
    protected $menuname = 'repposummary';

        public function actionHelp()
	{
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $this->txt = '_help'; break;
				case 2 : $this->txt = '_helpmodif'; break;
			}
		}
	  parent::actionHelp();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            parent::actionIndex();
			if (isset($_POST['startperiod']) && isset($_POST['endperiod']) && isset($_POST['headernote']) && isset($_POST['itemtext']))
      {
        $this->pdf->title='Purchase Order Summary';
	  $this->pdf->AddPage('L');
		$this->pdf->iscustomborder = false;
		$this->pdf->isneedpage = true;
		$connection=Yii::app()->db;
		$sql = "select a.pono,a.docdate,c.productname,b.netprice,b.poqty,(d.taxvalue*netprice*b.poQty / 100) as taxvalue,e.uomcode,
(select wfstatusname from wfstatus z where z.workflowid = 1 and z.wfstat = a.recordstatus) as wfstatus,
a.headernote,b.itemtext,f.fullname,(d.taxvalue*netprice*b.poQty / 100) + (netprice*b.poqty) as total,symbol,i.prno
from poheader a
left join podetail b on b.poheaderid = a.poheaderid
left join product c on c.productid = b.productid
left join tax d on d.taxid = b.taxid
left join unitofmeasure e on e.unitofmeasureid = b.unitofmeasureid 
left join addressbook f on f.addressbookid = a.addressbookid
left join currency g on g.currencyid = b.currencyid
left join prmaterial h on h.prmaterialid = b.prdetailid
left join prheader i on i.prheaderid = h.prheaderid
where a.docdate between '". $_POST['startperiod']. "' and '". $_POST['endperiod']."'
and a.headernote like '%".$_POST['headernote']."%' and b.itemtext like '%".$_POST['itemtext']."%'

";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		$this->pdf->Cell(0,10,'PERIODE : '. date(Yii::app()->params['dateviewfromdb'], strtotime($_POST['startperiod'])) . 
				' Up To '.date(Yii::app()->params['dateviewfromdb'], strtotime($_POST['endperiod'])),0,0,'C');
		
      $this->pdf->SetY($this->pdf->gety()+15);
		$this->pdf->setFont('Arial','B',8);
      $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,30,20,30,30,15,15,25,25,30,25,25));
	  $this->pdf->colheader = array(
		'No',
		'PO No',
		'PO Date',
		'Supplier',
		'Material / Service',
		'Qty',
		'UOM',
		'Unit Price',
		'Tax',
		'Total',
		'Header/ Item Note',
		'PR'
		);
      $this->pdf->RowHeader();
		$this->pdf->setFont('Arial','',8);
      $this->pdf->coldetailalign = array('L','L','L','L','L','R','C','R','R','R','L','L');
	  $totalamount = 0;$i=0;$totaltax=0;
		foreach($dataReader as $row)
          {
		  $i+=1;
$this->pdf->Row(array(
		$i,
		$row['pono'],
		date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])),
		$row['fullname'],
		$row['productname'],
		Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row['poqty']),
		$row['uomcode'],
		Yii::app()->numberFormatter->formatCurrency($row['netprice'],$row['symbol']),
		Yii::app()->numberFormatter->formatCurrency($row['taxvalue'],$row['symbol']),	
		Yii::app()->numberFormatter->formatCurrency($row['total'],$row['symbol']),	
		$row['headernote'] . " " . $row['itemtext'],
		$row['prno']
		));
		$this->pdf->CheckPageBreak(0);
		  		  }
				  
          $this->pdf->Output();
	  }
	  else
	  {
		$this->render('index');
	  }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Genledger::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='genledger-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
