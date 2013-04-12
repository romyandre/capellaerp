<?php

class ProductpurchaseController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'productpurchase';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $product=new Product('searchwstatus');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$plant=new Plant('searchwstatus');
	  $plant->unsetAttributes();  // clear any default values
	  if(isset($_GET['Plant']))
		$plant->attributes=$_GET['Plant'];

		$orderunit=new Unitofmeasure('searchwstatus');
	  $orderunit->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$orderunit->attributes=$_GET['Unitofmeasure'];
		
		$model=new Productpurchase;

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
	  $product=new Product('searchwstatus');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$plant=new Plant('searchwstatus');
	  $plant->unsetAttributes();  // clear any default values
	  if(isset($_GET['Plant']))
		$plant->attributes=$_GET['Plant'];

		$orderunit=new Unitofmeasure('searchwstatus');
	  $orderunit->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$orderunit->attributes=$_GET['Unitofmeasure'];

	  $model=$this->loadModel($_POST['id']);
 if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $_POST['id']) == false)
        {
          $this->InsertLock($this->menuname, $_POST['id']);
            echo CJSON::encode(array(
                'status'=>'success',
				'productpurchaseid'=>$model->productpurchaseid,
				'productid'=>$model->productid,
				'productname'=>($model->product!==null)?$model->product->productname:"",
				'plantid'=>$model->plantid,
				'plantcode'=>$model->plant->plantcode,
				'orderunit'=>$model->orderunit,
				'orderuomcode'=>($model->orderunit0!==null)?$model->orderunit0->uomcode:"",
				'isautoPO'=>$model->isautoPO,
				'validfrom'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->validfrom)),
				'validto'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->validto)),
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Productpurchase'], $_POST['Productpurchase']['productpurchaseid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Productpurchase']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Productpurchase']['productid'],'emptyproductid','emptystring'),
                array($_POST['Productpurchase']['plantid'],'emptyplantid','emptystring'),
                array($_POST['Productpurchase']['orderunit'],'emptyorderunit','emptystring'),
                array($_POST['Productpurchase']['validfrom'],'emptyvalidfrom','emptystring'),
                array($_POST['Productpurchase']['validto'],'emptyvalidto','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Productpurchase'];
		if ((int)$_POST['Productpurchase']['productpurchaseid'] > 0)
		{
		  $model=$this->loadModel($_POST['Productpurchase']['productpurchaseid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->productid = $_POST['Productpurchase']['productid'];
		  $model->plantid = $_POST['Productpurchase']['plantid'];
		  $model->orderunit = $_POST['Productpurchase']['orderunit'];
		  $model->validfrom = $_POST['Productpurchase']['validfrom'];
		  $model->validto = $_POST['Productpurchase']['validto'];
		  $model->isautoPO = $_POST['Productpurchase']['isautoPO'];
		}
		else
		{
		  $model = new Productpurchase();
		  $model->attributes=$_POST['Productpurchase'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Productpurchase']['productpurchaseid']);
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
		  $model->delete();
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}
	
	protected function gridData($data,$row)
  {     
    $model = Productpurchase::model()->findByPk($data->productpurchaseid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	  $product=new Product('searchwstatus');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$plant=new Plant('searchwstatus');
	  $plant->unsetAttributes();  // clear any default values
	  if(isset($_GET['Plant']))
		$plant->attributes=$_GET['Plant'];

		$orderunit=new Unitofmeasure('searchwstatus');
	  $orderunit->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$orderunit->attributes=$_GET['Unitofmeasure'];

		$model=new Productpurchase('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Productpurchase']))
			$model->attributes=$_GET['Productpurchase'];
			if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }

		$this->render('index',array(
			'model'=>$model,
				  'product'=>$product,
				  'plant'=>$plant,
				  'orderunit'=>$orderunit
		));
	}

  public function actionDownload()
  {
    parent::actionDownload();
    $sql = "select c.productname,b.plantcode,d.uomcode as orderunit,e.purchasinggroupcode,
      a.validfrom,a.validto
      from productpurchase a
      left join plant b on b.plantid = a.plantid
      left join product c on c.productid = a.productid
      left join unitofmeasure d on d.unitofmeasureid = a.orderunit
      left join purchasinggroup e on e.purchasinggroupid = a.purchasinggroupid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.productpurchaseid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
	  $this->pdf->title='Product Purchase List';
	  $this->pdf->AddPage('P');

    $this->pdf->colalign = array('C','C','C','C','C','C');
    $this->pdf->setwidths(array(80,15,15,30,25,25));
	$this->pdf->colheader = array('Product','Plant','Order Unit','Purchasing Group','Valid From','Valid To');
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array('L','L','L','L','L','L');
    foreach($dataReader as $row1)
    {
      $this->pdf->row(array($row1['productname'],$row1['plantcode'],$row1['orderunit']
          ,$row1['purchasinggroupcode'],
		  date(Yii::app()->params["dateviewfromdb"], strtotime($row1['validfrom'])),
		  date(Yii::app()->params["dateviewfromdb"], strtotime($row1['validto']))));
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
		$model=Productpurchase::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='productpurchase-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
