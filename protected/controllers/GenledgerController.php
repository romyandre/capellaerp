<?php

class GenledgerController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
    protected $menuname = 'genledger';

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            parent::actionIndex();
			if (isset($_POST['startperiod']))
      {
        $this->pdf->title='General Ledger';
        $this->pdf->AddPage('P', 'A4');
		$connection=Yii::app()->db;
		$sql = "select accountid,accountcode,accountname from account c
			inner join accounttype e on e.accounttypeid = c.accounttypeid
			";
		if ($_POST['accountid'] !== '')
		{
			$sql = $sql . " where accountid = ".$_POST['accountid'];
		}
		$sql = $sql . " and e.accounttypename = 'Detail' ";
		$command=$connection->createCommand($sql);
        $dataReader=$command->queryAll();
		  $this->pdf->setFont('Arial','B',12);
		$this->pdf->Cell(0,5,'PERIODE : '. date(Yii::app()->params['dateviewfromdb'], strtotime($_POST['startperiod'])) . 
				' Up To '.date(Yii::app()->params['dateviewfromdb'], strtotime($_POST['endperiod'])),0,0,'C');
$this->pdf->sety($this->pdf->gety()+5);
		foreach($dataReader as $row)
          {
		  $this->pdf->setFont('Arial','B',8);
			$this->pdf->Text(10,$this->pdf->GetY()+10,'Account Code : '.$row['accountcode']);
			$this->pdf->Text(60,$this->pdf->GetY()+10,'Account Name : '.$row['accountname']);
        $sql1 = "select c.accountcode,c.accountname, a.debit,a.credit,a.postdate,d.symbol,b.referenceno,b.journalnote,b.journalno
from genledger a
inner join genjournal b on b.genjournalid = a.genjournalid
inner join account c on c.accountid = a.accountid
inner join currency d on d.currencyid = a.currencyid
inner join accounttype e on e.accounttypeid = c.accounttypeid
where e.accounttypename = 'Detail' and a.postdate between '".$_POST['startperiod']."' and '".$_POST['endperiod']."' and a.accountid = ".$row['accountid']." order by a.postdate";
          $command1=$connection->createCommand($sql1);
        $dataReader1=$command1->queryAll();
		$this->pdf->setY($this->pdf->GetY() + 15);
          $this->pdf->setFont('Arial','B',7);
          $this->pdf->setwidths(array(30,30,20,30,30,50));
      $this->pdf->colalign = array('C','C','C','C','C','C');
	  $this->pdf->colheader = array('Journal No','Reference No','Post Date','Debit','Credit','Description');
          $this->pdf->rowheader();
          $this->pdf->SetTableData();
		  $totaldebit = 0;
		  $totalcredit = 0;
		  $selisih = 0;$symbol = '';
          $this->pdf->setFont('Arial','',7);
      $this->pdf->coldetailalign = array('L','L','L','R','R','L');
          foreach($dataReader1 as $row1)
          {
            $this->pdf->row(array(
				$row1['journalno'],$row1['referenceno'],
				date(Yii::app()->params['dateviewfromdb'], strtotime($row1['postdate'])),
				Yii::app()->numberFormatter->formatCurrency($row1['debit'],$row1['symbol']),
				Yii::app()->numberFormatter->formatCurrency($row1['credit'],$row1['symbol']),
				$row1['journalnote']
			));
			$totaldebit = $row1['debit'] + $totaldebit;
			$totalcredit = $row1['credit'] + $totalcredit;
			$symbol = $row1['symbol'];
          }
		  $this->pdf->row(array('',
			'Total',
			'',
			Yii::app()->numberFormatter->formatCurrency($totaldebit,$symbol),
			Yii::app()->numberFormatter->formatCurrency($totalcredit,$symbol),
			''
		  ));
		  			$this->pdf->checknewpage(40);
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
