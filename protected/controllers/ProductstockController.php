<?php

class ProductstockController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'productstock';

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	  		$productstockdet=new Productstockdet('search');
		$productstockdet->unsetAttributes();  // clear any default values
		if(isset($_GET['Productstockdet']))
			$productstockdet->attributes=$_GET['Productstockdet'];

		$model=new Productstock('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Productstock']))
			$model->attributes=$_GET['Productstock'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
			'productstockdet'=>$productstockdet
		));
	}

	public function actionDownload()
  {
    parent::actionDownload();
    $this->pdf->title='Material Stock Overview';
    $this->pdf->AddPage('P');
    $this->pdf->setFont('Arial','B',8);

    // menuliskan tabel
	$sql = "select distinct b.productid,b.productname,c.description,a.qty,d.uomcode,a.productstockid
		from productstock a
      inner join product b on b.productid = a.productid
      left join sloc c on c.slocid = a.slocid
      left join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid ";
	if ($_GET['id'] !== '0') {
				$sql = $sql . "where a.productstockid = ".$_GET['id'];
		}
	$command=$this->connection->createCommand($sql);
    $dataReader=$command->queryAll();
 foreach($dataReader as $row)
    {
	$this->pdf->Rect(10,60,190,25);
	      $this->pdf->text(15,$this->pdf->gety()+5,'Material ');$this->pdf->text(50,$this->pdf->gety()+5,': '.$row['productname']);
	      $this->pdf->text(15,$this->pdf->gety()+10,'Storage Location ');$this->pdf->text(50,$this->pdf->gety()+10,': '.$row['description']);
	      $this->pdf->text(15,$this->pdf->gety()+15,'Qty ');$this->pdf->text(50,$this->pdf->gety()+15,': '.Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row['qty']));
	      $this->pdf->text(15,$this->pdf->gety()+20,'Unit ');$this->pdf->text(50,$this->pdf->gety()+20,': '.$row['uomcode']);
    $sql1 = "
	select a.productstockid,b.productname,c.description,a.qty,d.uomcode,a.referenceno,
		(select grdate from grheader e where e.grno = a.referenceno limit 1) as grdate,
		(select gidate from giheader e where e.gino = a.referenceno limit 1) as gidate,
		(select pono from poheader zz left join grheader e on e.poheaderid = zz.poheaderid where e.grno = a.referenceno limit 1) as pono,
		(select fullname from poheader zx left join addressbook ab on ab.addressbookid = zx.addressbookid left join grheader e on e.poheaderid = zx.poheaderid where e.grno = a.referenceno limit 1) as supplier,
		(select dano from deliveryadvice zy left join giheader e on e.deliveryadviceid = zy.deliveryadviceid where e.gino = a.referenceno limit 1) as dano
      from productstockdet a
      inner join product b on b.productid = a.productid
      left join sloc c on c.slocid = a.slocid
      left join unitofmeasure d on d.unitofmeasureid = a.unitofmeasureid
	  where a.productstockid = ".$row["productstockid"];		

    $command1=$this->connection->createCommand($sql1);
    $dataReader1=$command1->queryAll();

	$this->pdf->sety($this->pdf->gety()+25);
      $this->pdf->setFont('Arial','B',7);
    $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C');
    $this->pdf->setwidths(array(30,20,30,40,30,20,20));
	$this->pdf->colheader = array('Reference No','Ref Date','PO','Supplier','FR','Qty','UOM');
    $this->pdf->RowHeader();
      $this->pdf->setFont('Arial','',7);
    $this->pdf->coldetailalign = array('L','L','L','L','L','R','C');
    foreach($dataReader1 as $row1)
    {
      $this->pdf->row(array($row1['referenceno'],
	  $row1['grdate']!==null?date(Yii::app()->params['dateviewfromdb'], strtotime($row1['grdate'])):date(Yii::app()->params['dateviewfromdb'], strtotime($row1['gidate'])),
          $row1['pono'],
          $row1['supplier'],
          $row1['dano'],
		  Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['qty']),
          $row1['uomcode']));
    }
      $this->pdf->setFont('Arial','',8);
      $this->pdf->text(10,$this->pdf->gety()+15,'Proposed By');$this->pdf->text(100,$this->pdf->gety()+15,'Approved');
      $this->pdf->text(10,$this->pdf->gety()+30,'----------------------');$this->pdf->text(95,$this->pdf->gety()+30,'----------------------');
	}
    // me-render ke browser
    $this->pdf->Output();
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Productstock::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='productstock-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
