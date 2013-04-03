<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
    protected $iswrite = 'iswrite';
    protected $isread = 'isread';
    protected $ispost = 'ispost';
    protected $isreject = 'isreject';
    protected $isupload = 'isupload';
    protected $isdownload = 'isdownload';
    protected $txt = '_help';
    protected $lockedby = "";
    protected $lockeddate = "";
    protected $messages = '';
	protected $connection;
	protected $pdf;
	protected $wfprint = '';
	protected $menuname = '';
	protected $useraction = '';
	protected $newdata = '';
	protected $olddata = '';
	
    public function ValidateData($datavalidate)
    {
      $messages = '';
      for ($row = 0; $row <  count($datavalidate); $row++)
      {
        if ($datavalidate[$row][2] == 'emptystring') {
          if ($datavalidate[$row][0] == '')
          {
            $message = Catalogsys::model()->findbysql("select a.*
			from catalogsys a
			inner join messages b on b.messagesid = a.messagesid 
			inner join language c on c.languageid = a.languageid 
			inner join useraccess d on d.languageid = c.languageid 
			where lower(b.messagename) = lower('". $datavalidate[$row][1]."') and d.username = '". Yii::app()->user->id . "'");
            if ($message != null) {
              $messages = $message->catalogval;
            } else {
              $messages = $datavalidate[$row][1];
            }
          }
        }
        if ($messages !== '') {
          echo CJSON::encode(array(
                'status'=>'failure',
                'div'=>$messages
                ));
            Yii::app()->end();
        }
      }
      return $messages;
    }

    public function GetMessage($catalogname,$othertext='')
    {
      $messages='';
      if (is_array($catalogname) == false)
      {
        $openbracpos = strpos((string)$catalogname,"<");
        if ($openbracpos == true)
        {
          $closebracpos = strpos((string)$catalogname,">");
          $catalogname = substr((string)$catalogname,$openbracpos,$closebracpos-$openbracpos);
        }
        $message=Catalogsys::model()->findbysql("select a.*
			from catalogsys a
			inner join messages b on b.messagesid = a.messagesid 
			inner join language c on c.languageid = a.languageid 
			inner join useraccess d on d.languageid = c.languageid 
			where lower(b.messagename) = lower('". $catalogname."') and d.username = '". Yii::app()->user->id . "'");
        if ($message != null)
        {
          $messages = $message->catalogval;
        } else
        {
          if (strpos($catalogname,'Duplicate entry') == true) {
            $catalogname = 'Duplicate entry';
          }
          $message=Catalogsys::model()->findbysql("select a.*
			from catalogsys a
			inner join messages b on b.messagesid = a.messagesid 
			inner join language c on c.languageid = a.languageid 
			inner join useraccess d on d.languageid = c.languageid 
			where lower(b.messagename) = lower('". $catalogname."') and d.username = '". Yii::app()->user->id . "'");
          if ($message != null)
          {
            $messages = $message->catalogval;
          } else
            $messages = $catalogname;
        }
       echo CJSON::encode(array(
                  'status'=>'failure',
                  'div'=> $messages.' '.$othertext
                  ));
        Yii::app()->end();
      } 
      else if (is_array($catalogname) == true)
      {
        echo CJSON::encode(array(
                'status'=>'failure',
                'div'=> (string)$catalogname.' '.$othertext
                ));
            Yii::app()->end();
      }
    }

    public function GetSMessage($catalogname)
    {
      $messages='';  
	  $catalogname = str_replace('<','',(string)$catalogname);
      $catalogname = trim(str_replace('>','',(string)$catalogname));
      $message=Catalogsys::model()->findbysql("select a.*
			from catalogsys a
			inner join messages b on b.messagesid = a.messagesid 
			inner join language c on c.languageid = a.languageid 
			inner join useraccess d on d.languageid = c.languageid 
			where lower(b.messagename) = lower('". $catalogname."') and d.username = '". Yii::app()->user->id . "'");
      if ($message !== null) {
        $messages = $message->catalogval;
      } else {
        $messages = $catalogname;
      }
      echo CJSON::encode(array(
                'status'=>'success',
                'div'=> $messages
                ));
            Yii::app()->end();
    }

	protected function CheckAccess($menuname,$menuaction)
	{
	  $baccess=false;
if((Yii::app()->user->id == null) || (Yii::app()->user->id == 'Guest')) {
  $this->redirect(array('/site/login'));
} else {
	  $connection=Yii::app()->db;
	  $sql = "select ".$menuaction.
		" from useraccess a ".
		" inner join usergroup b on b.useraccessid = a.useraccessid ".
		" inner join groupmenu c on c.groupaccessid = b.groupaccessid ".
		" inner join menuaccess d on d.menuaccessid = c.menuaccessid ".
		" where lower(username) = '".Yii::app()->user->id."' and lower(menuname) = '".$menuname."' limit 1";
	  $command=$connection->createCommand($sql);
	  $dataReader=$command->queryAll();
	  $access=0;
	  foreach($dataReader as $row) {
		if ($access < (int) $row[$menuaction]) {
		  $access = (int)$row[$menuaction];
		}
	  }
	  if ($access == 0) {
		$baccess = false;
        $this->GetMessage('youarenotauthorized');
	  } else {
		$baccess = true;
	  }
	  return $baccess;
	}
	}
	
	protected function InsertTransLog()
	{
	  $connection=Yii::app()->db;
	  $sql = "insert into translog (username,useraction,olddata,newdata,menuname) ".
		"values ('".Yii::app()->user->id."', '".$this->useraction."', '".implode(' ',$this->olddata)."','".
		implode(' ',$this->newdata)."','".$this->menuname."');"; 
	  $command=$connection->createCommand($sql);
	  $command->execute();	  
	}
	
	protected function CheckPrint($menuname,$workflow,$status)
	{
	  $baccess=false;
if((Yii::app()->user->id == null) || (Yii::app()->user->id == 'Guest')) {
  $this->redirect(array('/site/login'));
} else {
	  $connection=Yii::app()->db;
	  $sql = "select e.wfbefstat ".
		" from useraccess a ".
		" inner join usergroup b on b.useraccessid = a.useraccessid ".
		" inner join groupmenu c on c.groupaccessid = b.groupaccessid ".
		" inner join menuaccess d on d.menuaccessid = c.menuaccessid ".
		" inner join wfgroup e on e.groupaccessid = b.groupaccessid ".
		" inner join workflow f on f.workflowid = e.workflowid ".
		" where lower(username) = '".Yii::app()->user->id."' and lower(menuname) = '".$menuname.
		"'  and lower(wfname) like '%".$workflow."%' limit 1";
	  $command=$connection->createCommand($sql);
	  $dataReader=$command->queryAll();
	  foreach($dataReader as $row) {
		if ($status != $row['wfbefstat']) {
			$baccess=false;
			$this->GetMessage('youarenotauthorizedprint');
		}
	   else {
		$baccess = true;
	  }
	  }
	  return $baccess;
	}
	}

    protected function CheckWFStat($wfname,$recordstatus)
    {
      if((Yii::app()->user->id == null) || (Yii::app()->user->id == 'Guest'))
      {
        $this->redirect(array('/site/login'));
      } else
      {
        $connection=Yii::app()->db;
        $sql = "select b.wfrecstat
              from workflow a
              inner join wfgroup b on b.workflowid = a.workflowid
              inner join groupaccess c on c.groupaccessid = b.groupaccessid
              inner join usergroup d on d.groupaccessid = c.groupaccessid
              inner join useraccess e on e.useraccessid = d.useraccessid
              where upper(a.wfname) = upper('".$wfname."') and upper(e.username)=upper('".Yii::app()->user->name."'";
        $command=$connection->createCommand($sql);
        $dataReader=$command->queryAll();
        $access=0;
        foreach($dataReader as $row) {
          if ($access < (int) $row['wfrecstat']) {
            $access = (int)$row['wfrecstat'];
          }
        }
        if ($recordstatus > $access) {
          $baccess = false;
          $this->GetMessage('datacannotedit');
        } else {
          $baccess = true;
        }
        return $baccess;
      }
    }
    
    protected function CheckDataLock($menuname,$idvalue)
    {
      if((Yii::app()->user->id == null) || (Yii::app()->user->id == 'Guest'))
      {
        $this->redirect(array('/site/login'));
      } else
      {
        $connection=Yii::app()->db;
        $baccess = false;
        $sql = "select lockedby,lockeddate ".
          "from translock ".
          "where upper(menuname) = upper('".$menuname."') and tableid = ".$idvalue." and upper(lockedby) <> upper('".Yii::app()->user->name."')";
        $command=$connection->createCommand($sql);
        $dataReader=$command->queryAll();
        foreach($dataReader as $row)
        {
          $this->lockedby = $row['lockedby'];
          if (($this->lockedby != null) || ($lockedby != ""))
          {
            $baccess = true;
            $this->lockeddate = $row['lockeddate'];
          }
        }
        if ($baccess == true)
        {
          $this->GetMessage('datalock',$this->lockedby);
        } else
        {
          $baccess = false;
        }
        return $baccess;
      }
    }

    protected function InsertLock($menuname,$idvalue)
    {
      $connection=Yii::app()->db;
      $sql = "insert into translock (menuname,tableid,lockedby) ".
          "values ('".$menuname."',".$idvalue.",'".Yii::app()->user->name."')";
      $command=$connection->createCommand($sql);
      $command->execute();
    }

    protected function DeleteLock($menuname,$idvalue)
    {
      if ((int)$idvalue > 0)
      {
        $connection=Yii::app()->db;
        $sql = "delete from translock where upper(menuname) = '".$menuname.
          "' and tableid = ".$idvalue;
        $command=$connection->createCommand($sql);
        $command->execute();
      }
    }

    protected function DeleteLockCloseForm($menuname,$postvalue,$idvalue)
    {
      if(isset($postvalue))
      {
        if ((int)$idvalue > 0)
        {
          $this->DeleteLock($menuname, $idvalue);
        }
      }
      echo CJSON::encode(array(
          'status'=>'success',
          ));
      Yii::app()->end();
    }

	public function actionIndex()
	{
	  if ($this->CheckAccess($this->menuname, $this->isread) == false) {
		Yii::app()->end();
	  }
	  else
	  {
		$user = Useraccess::model()->findbyattributes(array('username'=>Yii::app()->user->id));
		  if ($user !== null)
		  {
			Yii::app()->theme = $user->theme;
		  }
		require_once("pdf.php");
		$this->connection=Yii::app()->db;    
		$this->pdf = new PDF();
	  }
	}

	public function actionCreate()
	{
	  if ($this->CheckAccess($this->menuname, $this->iswrite) == false) {
		Yii::app()->end();
	  }
	}

	public function actionUpdate()
	{
	  if ($this->CheckAccess($this->menuname, $this->iswrite) == false) {
		Yii::app()->end();
	  }

	}

	public function actionWrite()
	{
	  if ($this->CheckAccess($this->menuname, $this->iswrite) == false) {
		Yii::app()->end();
	  }
	}

	public function actionDelete()
	{
	  if ($this->CheckAccess($this->menuname, $this->isreject) == false) {
		Yii::app()->end();
	  }
	}

	public function actionApprove()
	{
	  if ($this->CheckAccess($this->menuname, $this->ispost) == false) {
		Yii::app()->end();
	  }
	}

	public function actionUpload()
	{
	  if ($this->CheckAccess($this->menuname, $this->isupload) == false) {
		Yii::app()->end();
	  } else {
        Yii::import("ext.EAjaxUpload.qqFileUploader");
      }
	}
	
protected function eja($n) {
		$dasar = array(1=>'satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan');
		$angka = array(1000000000,1000000,1000,100,10,1);
		$satuan = array('milyar','juta','ribu','ratus','puluh','');
		
		$i=0;
		$str="";
		while($n!=0){
			$count = (int)($n/$angka[$i]);
			if($count>=10) $str .= $this->eja($count). " ".$satuan[$i]." ";
			else if($count > 0 && $count < 10)
				$str .= $dasar[$count] . " ".$satuan[$i]." ";
			$n -= $angka[$i] * $count;
			$i++;
		}
		$str = preg_replace("/satu puluh (\w+)/i","\\1 belas",$str);
		$str = preg_replace("/satu (ribu|ratus|puluh|belas)/i","se\\1",$str);
		return $str;
	}
	
	public function actionDownload()
	{
		if ($this->CheckAccess($this->menuname, $this->isdownload) == false) {
			Yii::app()->end();
		} else {
			require_once("pdf.php");
			$this->connection=Yii::app()->db;    
			$this->pdf = new PDF();
		}
	}

		public function actionHelp()
	{
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'div'=>$this->renderPartial($this->txt, null, true)
			  ));
		  Yii::app()->end();
	  }
	}   
}
