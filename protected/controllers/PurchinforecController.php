<?php

class PurchinforecController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'purchinforec';

public $supplier,$product,$purchasinggroup,$currency;

public function lookupdata()
{
$this->supplier=new Supplier('searchwstatus');
	  $this->supplier->unsetAttributes();  // clear any default values
	  if(isset($_GET['Supplier']))
		$this->supplier->attributes=$_GET['Supplier'];
		
		$this->product=new Product('searchwstatus');
	  $this->product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$this->product->attributes=$_GET['Product'];
		
		$this->purchasinggroup=new Purchasinggroup('searchwstatus');
	  $this->purchasinggroup->unsetAttributes();  // clear any default values
	  if(isset($_GET['Purchasinggroup']))
		$this->purchasinggroup->attributes=$_GET['Purchasinggroup'];
		
		$this->currency=new Currency('searchwstatus');
	  $this->currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$this->currency->attributes=$_GET['Currency'];
}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $this->lookupdata();
		$model=new Purchinforec;
		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				));
            Yii::app()->end();
        }
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
	  parent::actionUpdate();
	  $this->lookupdata();
	  $model=$this->loadModel($_POST['id']);
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $_POST['id']) == false)
        {
          $this->InsertLock($this->menuname, $_POST['id']);
            echo CJSON::encode(array(
                'status'=>'success',
				'purchinforecid'=>$model->purchinforecid,
				'addressbookid'=>$model->addressbookid,
				'suppliername'=>($model->addressbook!==null)?$model->addressbook->fullname:"",
				'productid'=>$model->productid,
				'productname'=>($model->product!==null)?$model->product->productname:"",
				'deliverytime'=>$model->deliverytime,
				'purchasinggroupid'=>$model->purchasinggroupid,
				'purchasinggroupcode'=>($model->purchasinggroup!==null)?$model->purchasinggroup->purchasinggroupcode:"",
				'currencyid'=>$model->currencyid,
				'currencyname'=>($model->currency!==null)?$model->currency->currencyname:"",
				'underdelvtol'=>$model->underdelvtol,
				'overdelvtol'=>$model->overdelvtol,
				'price'=>$model->price,
                'biddate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->biddate)),
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Purchinforec'], $_POST['Purchinforec']['purchinforecid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Purchinforec']))
	  {
         $messages = $this->ValidateData(
                array(array($_POST['Purchinforec']['addressbookid'],'emptyaddressbookid','emptystring'),
            array($_POST['Purchinforec']['productid'],'emptyproductid','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Purchinforec']['purchinforecid'] > 0)
		{
		  $model=$this->loadModel($_POST['Purchinforec']['purchinforecid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->addressbookid = $_POST['Purchinforec']['addressbookid'];
		  $model->productid = $_POST['Purchinforec']['productid'];
		  $model->deliverytime = $_POST['Purchinforec']['deliverytime'];
		  $model->purchasinggroupid = $_POST['Purchinforec']['purchasinggroupid'];
		  $model->underdelvtol = $_POST['Purchinforec']['underdelvtol'];
		  $model->overdelvtol = $_POST['Purchinforec']['overdelvtol'];
		  $model->price = $_POST['Purchinforec']['price'];
		  $model->currencyid = $_POST['Purchinforec']['currencyid'];
		  $model->biddate = $_POST['Purchinforec']['biddate'];
		}
		else
		{
		  $model = new Purchinforec();
		  $model->attributes=$_POST['Purchinforec'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Purchinforec']['purchinforecid']);
              $this->GetSMessage('insertsuccess');
            }
            else
            {
              $this->GetMessage($model->getErrors());
            }
          }
          catch (Exception $e)
          {
            $this->GetMessage($e->getMessage());
          }
      }
	  }
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
	  parent::actionDelete();
		 $model=$this->loadModel($_POST['id']);
		  $model->recordstatus=0;
		  $model->save();
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}
	
	protected function gridData($data,$row)
  {     
    $model = Purchinforec::model()->findByPk($data->purchinforecid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	  $this->lookupdata();

		$model=new Purchinforec('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Purchinforec']))
			$model->attributes=$_GET['Purchinforec'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
				  'supplier'=>$this->supplier,
				  'product'=>$this->product,
				  'purchasinggroup'=>$this->purchasinggroup,
            'currency'=>$this->currency
		));
	}

  public function actionDownload()
  {
    parent::actionDownload();
	$sql = "select distinct a.productid, e.productname
		from purchinforec a
		      left join product e on e.productid = a.productid
		";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.purchinforecid = ".$_GET['id'];
		}
		$sql = $sql . " order by a.productid ";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

	  $this->pdf->title='Purchasing Info Record List';
	  $this->pdf->AddPage('L');
	  // definisi font
    foreach($dataReader as $row)
    {
			  $this->pdf->setFont('Arial','B',8);
	$this->pdf->text(20,$this->pdf->gety()+10,'Product Name : '.$row['productname']);
		$sql1 = "select b.fullname, e.productname,a.deliverytime,c.purchasinggroupcode,
      a.underdelvtol,a.overdelvtol,a.price,d.symbol,a.biddate
      from purchinforec a
      left join addressbook b on b.addressbookid = a.addressbookid
      left join purchasinggroup c on c.purchasinggroupid = a.purchasinggroupid
      left join currency d on d.currencyid = a.currencyid
      left join product e on e.productid = a.productid 
		where a.productid = ".$row["productid"];
		$sql1 .= " order by biddate";
		$command1=$this->connection->createCommand($sql1);
		$dataReader1=$command1->queryAll();
		$this->pdf->sety($this->pdf->gety()+15);
			  $this->pdf->setFont('Arial','B',8);
    $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C');
    $this->pdf->setwidths(array(50,40,40,20,20,40,20));
	$this->pdf->colheader = array('Supplier','Delivery Time','Purchasing Group',
        'Under Tol','Over Tol','Price','Bid Date');
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array('L','L','L','R','R','R','L');

		foreach($dataReader1 as $row1)
    {
      $this->pdf->row(array($row1['fullname'],$row1['deliverytime'],
          $row1['purchasinggroupcode'],$row1['underdelvtol'],
          $row1['overdelvtol'],
		  Yii::app()->numberFormatter->formatCurrency($row1['price'],$row1['symbol']),
		  date(Yii::app()->params['dateviewfromdb'], strtotime($row1['biddate']))));
		  };
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
		$model=Purchinforec::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='purchinforec-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
