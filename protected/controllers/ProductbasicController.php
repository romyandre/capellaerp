<?php

class ProductbasicController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
protected $menuname = 'productbasic';
 
  public $product,$baseuom,$materialgroup,$division,$weightunit,$volumeunit,
	  $materialpackage;

  public function lookupdata()
  {
	$this->product=new Product('searchwstatus');
	  $this->product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$this->product->attributes=$_GET['Product'];

		$this->baseuom=new Unitofmeasure('searchwstatus');
	  $this->baseuom->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$this->baseuom->attributes=$_GET['Unitofmeasure'];

		$this->materialgroup=new Materialgroup('searchwstatus');
	  $this->materialgroup->unsetAttributes();  // clear any default values
	  if(isset($_GET['Materialgroup']))
		$this->materialgroup->attributes=$_GET['Materialgroup'];

		$this->weightunit=new Unitofmeasure('searchwstatus');
	  $this->weightunit->unsetAttributes();  // clear any default values
	  if(isset($_GET['Weightunit']))
		$this->weightunit->attributes=$_GET['Weightunit'];

		$this->volumeunit=new Unitofmeasure('searchwstatus');
	  $this->volumeunit->unsetAttributes();  // clear any default values
	  if(isset($_GET['Volumeunit']))
		$this->volumeunit->attributes=$_GET['Volumeunit'];

		$this->materialpackage=new Product('searchwstatus');
	  $this->materialpackage->unsetAttributes();  // clear any default values
	  if(isset($_GET['Materialpackage']))
		$this->materialpackage->attributes=$_GET['Materialpackage'];
  }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $this->lookupdata();

		$model=new Productbasic;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

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
				'productbasicid'=>$model->productbasicid,
				'productid'=>$model->productid,
				'productname'=>($model->product!==null)?$model->product->productname:"",
				'baseuom'=>$model->baseuom,
				'uomcode'=>($model->baseuom0!==null)?$model->baseuom0->uomcode:"",
				'materialgroupid'=>$model->materialgroupid,
				'materialgroupcode'=>($model->materialgroup!==null)?$model->materialgroup->materialgroupcode:"",
				'oldmatno'=>$model->oldmatno,
				'grossweight'=>$model->grossweight,
				'weightunit'=>$model->weightunit,
				'weightuomcode'=>($model->baseuom1!==null)?$model->baseuom1->uomcode:"",
				'netweight'=>$model->netweight,
				'volume'=>$model->volume,
				'volumeunit'=>$model->volumeunit,
				'volumeuomcode'=>($model->baseuom2!==null)?$model->baseuom2->uomcode:"",
				'sizedimension'=>$model->sizedimension,
				'materialpackage'=>$model->materialpackage,
				'materialpackagename'=>($model->materialpackage0!==null)?$model->materialpackage0->productname:"",
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Productbasic'], $_POST['Productbasic']['productbasicid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Productbasic']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Productbasic']['productid'],'emptyproductid','emptystring'),
                array($_POST['Productbasic']['baseuom'],'emptybaseuom','emptystring'),
                array($_POST['Productbasic']['materialgroupid'],'emptymaterialgroupid','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Productbasic'];
		if ((int)$_POST['Productbasic']['productbasicid'] > 0)
		{
		  $model=$this->loadModel($_POST['Productbasic']['productbasicid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->productid = $_POST['Productbasic']['productid'];
		  $model->baseuom = $_POST['Productbasic']['baseuom'];
		  $model->materialgroupid = $_POST['Productbasic']['materialgroupid'];
		  $model->oldmatno = $_POST['Productbasic']['oldmatno'];
		  $model->divisionid = $_POST['Productbasic']['divisionid'];
		  $model->grossweight = $_POST['Productbasic']['grossweight'];
		  $model->weightunit = $_POST['Productbasic']['weightunit'];
		  $model->netweight = $_POST['Productbasic']['netweight'];
		  $model->volume = $_POST['Productbasic']['volume'];
		  $model->volumeunit = $_POST['Productbasic']['volumeunit'];
		  $model->sizedimension = $_POST['Productbasic']['sizedimension'];
		  $model->materialpackage = $_POST['Productbasic']['materialpackage'];
		  $model->recordstatus = $_POST['Productbasic']['recordstatus'];
		}
		else
		{
		  $model = new Productbasic();
		  $model->attributes=$_POST['Productbasic'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		 $this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Productbasic']['productbasicid']);
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	  $this->lookupdata();
		$model=new Productbasic('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Productbasic']))
			$model->attributes=$_GET['Productbasic'];
			if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }

		$this->render('index',array(
			'model'=>$model,
				  'product'=>$this->product,
				  'baseuom'=>$this->baseuom,
				  'materialgroup'=>$this->materialgroup,
				  'weightunit'=>$this->weightunit,
				  'volumeunit'=>$this->volumeunit,
				  'materialpackage'=>$this->materialpackage
		));
	}

	public function actionDownload()
  {
	parent::actionDownload();
    $sql = "select a.productbasicid,b.productname,c.uomcode as baseuom,d.description,
      a.oldmatno,d.materialgroupcode,a.oldmatno,e.divisioncode,a.grossweight,f.uomcode as weightunit,
      a.netweight,a.volume,g.uomcode as volumeunit
      from productbasic a
      left join product b on b.productid = a.productid
      left join unitofmeasure c on c.unitofmeasureid = a.baseuom
      left join materialgroup d on d.materialgroupid = a.materialgroupid
      left join division e on e.divisionid = a.divisionid
      left join unitofmeasure f on f.unitofmeasureid = a.weightunit
      left join unitofmeasure g on g.unitofmeasureid = a.volumeunit ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.productbasicid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
    $this->pdf->title='Product Basic List';
    $this->pdf->AddPage('L');

    $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C');
    $this->pdf->setwidths(array(80,20,20,20,20,20,20,20,20,20));
	$this->pdf->colheader = array('Material Name','Base UOM','Material Group','Old Material No',
	'Division','Gross Weight','Wei Unit','Net Weight','Volume','Vol Unit');
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array('L','L','L','L','L','R','L','R','R','L');
    foreach($dataReader as $row1)
    {
      $this->pdf->row(array($row1['productname'],$row1['baseuom'],$row1['materialgroupcode'],
          $row1['oldmatno'],$row1['divisioncode']
          ,$row1['grossweight'],$row1['weightunit'],$row1['netweight'],$row1['volume'],
          $row1['volumeunit']));
    }

    // me-render ke browser
    $this->pdf->Output();
  }
  
  protected function gridData($data,$row)
  {     
    $model = Productbasic::model()->findByPk($data->productbasicid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Productbasic::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='productbasic-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
