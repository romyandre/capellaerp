<div id="module-pnl"> <!-- tambahan baru -->
<div class="well">
					<h3>Recent Update</h3>
					<ul>
					<?php
					$translog = Translog::model()->findallbysql('select * from translog where menuname = "'.$this->menuname.'" order by createddate desc');
					$i=0;
					if ($translog !== null)
					{
						foreach ($translog as $log)
						{
						$i+=1;
						if ($i <= 3) {
						echo "<li>Created Date: ". $log->createddate ."<br/>User : ". $log->username ."<br/>ID : ".$log->tableid."<br/>Action : ".$log->useraction;
						}
						}
					}
					?>
					</ul>
					</div>
			</div>