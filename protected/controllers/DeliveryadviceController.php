<?php

class DeliveryadviceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        protected $menuname = 'deliveryadvice';

    public $sloc,$deliveryadvicedetail,$product,$unitofmeasure,$requestedby;

    public function lookupdata()
    {
	$this->sloc=new Sloc('search');
	  $this->sloc->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$this->sloc->attributes=$_GET['Sloc'];
		
		
      $this->deliveryadvicedetail=new Deliveryadvicedetail('search');
	  $this->deliveryadvicedetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Deliveryadvicedetail']))
		$this->deliveryadvicedetail->attributes=$_GET['Deliveryadvicedetail'];

      $this->lookupdetail();
    }

    public function lookupdetail()
    {
      $this->product=new Product('search');
	  $this->product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$this->product->attributes=$_GET['Product'];

		$this->unitofmeasure=new Unitofmeasure('search');
	  $this->unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$this->unitofmeasure->attributes=$_GET['Unitofmeasure'];

		$this->requestedby=new Requestedby('search');
	  $this->requestedby->unsetAttributes();  // clear any default values
	  if(isset($_GET['Requestedby']))
		$this->requestedby->attributes=$_GET['Requestedby'];
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
      parent::actionCreate();
	  $this->lookupdata();
      $model=new Deliveryadvice;
      $model->recordstatus = Wfgroup::model()->findstatusbyuser('insda');
      $model->useraccessid = Useraccess::model()->findbysql("select * from useraccess 
        where upper(username)=upper('".Yii::app()->user->name."')")->useraccessid;

      if (Yii::app()->request->isAjaxRequest)
      {
          if ($model->save()) {
            echo CJSON::encode(array(
                'status'=>'success',
                'deliveryadviceid'=>$model->deliveryadviceid,
                ));
            Yii::app()->end();
          }
      }
	}

	public function actionCreatedetail()
	{
	  $this->lookupdetail();
      $deliveryadvicedetail=new Deliveryadvicedetail;

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

		// Uncomment the following line if AJAX validation is needed
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $_POST['id']) == false)
        {
          $this->InsertLock($this->menuname, $_POST['id']);
            echo CJSON::encode(array(
                'status'=>'success',
				'deliveryadviceid'=>$model->deliveryadviceid,
				'dadate'=>$model->dadate,
				'headernote'=>$model->headernote,
                'slocid'=>$model->slocid,
                'sloccode'=>($model->sloc!==null)?$model->sloc->sloccode:"",
				'recordstatus'=>$model->recordstatus,
				));
            Yii::app()->end();
        }
        }
	}

	public function actionUpdatedetail()
	{
	  	 $this->lookupdetail();
	  $deliveryadvicedetail=$this->loadModeldetail($_POST['id']);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'deliveryadvicedetailid'=>$deliveryadvicedetail->deliveryadvicedetailid,
				'productid'=>$deliveryadvicedetail->productid,
				'productname'=>($deliveryadvicedetail->product!==null)?$deliveryadvicedetail->product->productname:"",
				'qty'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$deliveryadvicedetail->qty),
				'unitofmeasureid'=>$deliveryadvicedetail->unitofmeasureid,
				'uomcode'=>($deliveryadvicedetail->unitofmeasure!==null)?$deliveryadvicedetail->unitofmeasure->uomcode:"",
				'requestedbyid'=>$deliveryadvicedetail->requestedbyid,
				'requestedbycode'=>($deliveryadvicedetail->requestedby!==null)?$deliveryadvicedetail->requestedby->requestedbycode:"",
                'itemtext'=>$deliveryadvicedetail->itemtext,
                'reqdate'=>$deliveryadvicedetail->reqdate,
				));
            Yii::app()->end();
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Deliveryadvice'], 
              $_POST['Deliveryadvice']['deliveryadviceid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Deliveryadvice']))
	  {
        $messages = $this->ValidateData(
                array(
				array($_POST['Deliveryadvice']['slocid'],'emptysloc','emptystring'),
				array($_POST['Deliveryadvice']['dadate'],'emptydate','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Deliveryadvice'];
		if ((int)$_POST['Deliveryadvice']['deliveryadviceid'] > 0)
		{
		  $model=$this->loadModel($_POST['Deliveryadvice']['deliveryadviceid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->headernote = $_POST['Deliveryadvice']['headernote'];
		  $model->slocid = $_POST['Deliveryadvice']['slocid']; 
		  $model->dadate = $_POST['Deliveryadvice']['dadate']; 
		}
		else
		{
		  $model = new Deliveryadvice();
		  $model->attributes=$_POST['Deliveryadvice'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
              $this->DeleteLock($this->menuname, $_POST['Deliveryadvice']['deliveryadviceid']);
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

	public function actionWritedetail()
	{
	  if(isset($_POST['Deliveryadvicedetail']))
	  {
        $messages = $this->ValidateData(
                array(
					array($_POST['Deliveryadvicedetail']['productid'],'emptyproductid','emptystring'),
                    array($_POST['Deliveryadvicedetail']['qty'],'emptyqty','emptystring'),
                    array($_POST['Deliveryadvicedetail']['unitofmeasureid'],'emptyunitofmeasureid','emptystring'),
                    array($_POST['Deliveryadvicedetail']['reqdate'],'emptyreqdate','emptystring'),
                    array($_POST['Deliveryadvicedetail']['requestedbyid'],'emptyrequestedbyid','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Deliveryadvicedetail'];
		if ((int)$_POST['Deliveryadvicedetail']['deliveryadvicedetailid'] > 0)
		{
		  $model=Deliveryadvicedetail::model()->findbyPK($_POST['Deliveryadvicedetail']['deliveryadvicedetailid']);
		  $this->olddata = $model->attributes;
			$this->useraction='update';
		  $model->deliveryadviceid = $_POST['Deliveryadvicedetail']['deliveryadviceid'];
		  $model->productid = $_POST['Deliveryadvicedetail']['productid'];
		  $model->unitofmeasureid = $_POST['Deliveryadvicedetail']['unitofmeasureid'];
		  $model->qty = $_POST['Deliveryadvicedetail']['qty'];
		  $model->requestedbyid = $_POST['Deliveryadvicedetail']['requestedbyid'];
		  $model->reqdate = $_POST['Deliveryadvicedetail']['reqdate'];
		  $model->itemtext = $_POST['Deliveryadvicedetail']['itemtext'];
		}
		else
		{
		  $model = new Deliveryadvicedetail();
		  $model->attributes=$_POST['Deliveryadvicedetail'];
		  $this->olddata = $model->attributes;
			$this->useraction='new';
		}
		$this->newdata = $model->attributes;
		try
          {
            if($model->save())
            {
			$this->InsertTranslog();
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

        public function actionApprove()
	{
            parent::actionApprove();
          //$model=$this->loadModel($ids);
          $a = Yii::app()->user->name;
          $connection=Yii::app()->db;
          $transaction=$connection->beginTransaction();
          try
          {
            $sql = 'call ApproveDA(:vid, :vlastupdateby)';
            $command=$connection->createCommand($sql);
            $command->bindValue(':vid',$_POST['id'],PDO::PARAM_INT);
            $command->bindValue(':vlastupdateby', $a,PDO::PARAM_STR);
            $command->execute();
            $transaction->commit();
            $this->GetSMessage('insertsuccess');
          }
          catch(Exception $e) // an exception is raised if a query fails
          {
              $transaction->rollBack();
              $this->GetMessage($e->getMessage());
          }
        Yii::app()->end();
	}
	
	protected function gridData($data,$row)
  {     
    $model = Deliveryadvice::model()->findByPk($data->deliveryadviceid); 
    return $this->renderPartial('_view',array('model'=>$model),true); 
  }
  
  protected function gridDetail($data,$row)
  {     
    $model = Deliveryadvicedetail::model()->findByPk($data->deliveryadvicedetailid); 
    return $this->renderPartial('_viewdetail',array('model'=>$model),true); 
  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            parent::actionIndex();
	  $this->lookupdata();

		$model=new Deliveryadvice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Deliveryadvice']))
			$model->attributes=$_GET['Deliveryadvice'];
if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}
		$this->render('index',array(
			'model'=>$model,
					'deliveryadvicedetail'=>$this->deliveryadvicedetail,
					'product'=>$this->product,
					'unitofmeasure'=>$this->unitofmeasure,
					'requestedby'=>$this->requestedby,
					'sloc'=>$this->sloc
		));
	}

	public function actionIndexdetail()
	{
	  $this->lookupdetail();

		$deliveryadvicedetail=new Deliveryadvicedetail('search');
	  $deliveryadvicedetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Deliveryadvicedetail']))
		$deliveryadvicedetail->attributes=$_GET['Deliveryadvicedetail'];

	  $this->renderPartial('indexdetail',
		array('deliveryadvicedetail'=>$deliveryadvicedetail,'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'requestedby'=>$requestedby));
	  Yii::app()->end();
	}
    
    public function actionDownload()
	{
	  parent::actionDownload();
	  $sql = "select a.dano,a.dadate,a.headernote,a.deliveryadviceid,b.description
      from deliveryadvice a
left join sloc b on b.slocid = a.slocid	  ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.deliveryadviceid = ".$_GET['id'];
		}
		    $command=$this->connection->createCommand($sql);
    $dataReader=$command->queryAll();
	  $this->pdf->title='Form Request (Goods/Service/Delivery)';
	  $this->pdf->AddPage('P');
	  // definisi font
	  $this->pdf->setFont('Arial','B',8);

    foreach($dataReader as $row)
    {
        $this->pdf->Rect(10,60,190,25);
      $this->pdf->text(15,$this->pdf->gety()+5,'No ');$this->pdf->text(50,$this->pdf->gety()+5,': '.$row['dano']);
      $this->pdf->text(15,$this->pdf->gety()+10,'Date ');$this->pdf->text(50,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['dadate'])));
      $this->pdf->text(15,$this->pdf->gety()+15,'Sloc ');$this->pdf->text(50,$this->pdf->gety()+15,': '.$row['description']);
      $this->pdf->text(15,$this->pdf->gety()+20,'Note ');$this->pdf->text(50,$this->pdf->gety()+20,': '.$row['headernote']);

      $sql1 = "select b.productname, a.qty, c.uomcode, a.itemtext
        from deliveryadvicedetail a
        left join product b on b.productid = a.productid
        left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
        where deliveryadviceid = ".$row['deliveryadviceid'];
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

	  $this->pdf->sety($this->pdf->gety()+25);
      $this->pdf->colalign = array('C','C','C','C','C');
      $this->pdf->setwidths(array(10,80,20,15,65));
	  $this->pdf->colheader = array('No','Items','Qty','Unit','Remark');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','R','C','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['qty']),
            $row1['uomcode'],
            $row1['itemtext']));
      }
      
      $this->pdf->setFont('Arial','',10);
      $this->pdf->text(10,$this->pdf->gety()+20,'Approved By');$this->pdf->text(150,$this->pdf->gety()+20,'Proposed By');
      $this->pdf->text(10,$this->pdf->gety()+40,'---------------- ');$this->pdf->text(150,$this->pdf->gety()+40,'----------------');
      }
	  $this->pdf->Output();
	}

	public function actionDelete()
	{
            parent::actionDelete();
		//$model=$this->loadModel($ids);
          $a = Yii::app()->user->name;
          $connection=Yii::app()->db;
          $transaction=$connection->beginTransaction();
          try
          {
            $sql = 'call RejectDA(:vid, :vlastupdateby)';
            $command=$connection->createCommand($sql);
            $command->bindValue(':vid',$_POST['id'],PDO::PARAM_INT);
            $command->bindValue(':vlastupdateby', $a,PDO::PARAM_STR);
            $command->execute();
            $transaction->commit();
            $this->GetSMessage('insertsuccess');
          }
          catch(Exception $e) // an exception is raised if a query fails
          {
              $transaction->rollBack();
              $this->GetMessage($e->getMessage());
          }
        Yii::app()->end();
	}

	public function actionDeletedetail()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Deliveryadvicedetail::model()->findbyPK($ids);
		  $model->delete();
		}
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Deliveryadvice::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Deliveryadvicedetail::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='deliveryadvice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
