DELIMITER $$
DROP PROCEDURE IF EXISTS `pExecuteImmediate`$$
CREATE DEFINER=`capella3`@`localhost` PROCEDURE `pExecuteImmediate`(IN tSQLStmt TEXT)
BEGIN
  SET @executeImmediateSQL = tSQLStmt;
  PREPARE executeImmediateSTML FROM @executeImmediateSQL;
  EXECUTE executeImmediateSTML;
  DEALLOCATE PREPARE executeImmediateSTML;
END$$

DROP PROCEDURE IF EXISTS `pRaiseError`$$
CREATE DEFINER=`capella3`@`localhost` PROCEDURE `pRaiseError`(sError VARCHAR(255))
BEGIN
        CALL pExecuteImmediate(fFormat('CALL `error: %s', sError));
END$$

DROP FUNCTION IF EXISTS `GetParamValue`$$
CREATE DEFINER=`capella3`@`localhost` FUNCTION `GetParamValue`(vParamName text) RETURNS text CHARSET utf8
BEGIN
	declare ret text;
	select paramvalue
	into ret
	from parameter
	where lower(paramname) = lower(vParamName);
	return ret;
END$$

DROP FUNCTION IF EXISTS `GetRunNo`$$
CREATE DEFINER=`capella3`@`localhost` FUNCTION `GetRunNo`(vsnroid int,vdate datetime) RETURNS varchar(100) CHARSET utf8
BEGIN
	declare vformatdoc,vformatno,vmr,vrepeatby,vrom varchar(100);
	declare vdd,vmm,vyy,vcurrvalue,lyy,vtrap integer;

	select formatdoc,formatno,repeatby
	into vformatdoc,vformatno,vrepeatby
	from snro
	where snroid = vsnroid;

	select day(vdate) into vdd;
	select month(vdate) into vmm;	
	select year(vdate) into vyy;
	if position('MONROM' in vformatno) then
		select monthrm into vmr 
		from romawi
		where monthcal = vmm;
	end if; 

	if (position('YYYY' in vrepeatby) > 0) then
		set lyy = 4;
	else
		if (position('YY' in vrepeatby) > 0) then
			set lyy = 2;
		end if;
	end if;

  if (vrepeatby = '') then
		select count(1)
		into vcurrvalue
		from snrodet
		where snroid = vsnroid;
    set vtrap = 4;

		if vcurrvalue > 0 then
			select curvalue
			into vcurrvalue
			from snrodet
			where snroid = vsnroid;

			set vcurrvalue=vcurrvalue + 1;

			update snrodet
			set curvalue = vcurrvalue
			where snroid = vsnroid;
		else
			set vcurrvalue=1;
			insert into snrodet (snroid,curdd,curmm,curyy,curvalue)
			values (vsnroid,0,0,0,1);
		end if;
  else
if (position('DD' in vrepeatby) > 0) and
	   (position('MM' in vrepeatby) > 0) and
	   (position('YY' in vrepeatby) > 0) then
		select count(1)
		into vcurrvalue
		from snrodet
		where snroid = vsnroid and curdd = vdd and curmm = vmm and curyy = vyy;
set vtrap = 3;

		if vcurrvalue > 0 then
			select curvalue
			into vcurrvalue
			from snrodet
			where snroid = vsnroid and curdd = vdd and curmm = vmm and curyy = vyy;

			set vcurrvalue=vcurrvalue + 1;

			update snrodet
			set curvalue = vcurrvalue
			where snroid = vsnroid and curdd = vdd and curmm = vmm and curyy = vyy;
		else
			set vcurrvalue=1;
			insert into snrodet (snroid,curdd,curmm,curyy,curvalue)
			values (vsnroid,vdd,vmm,vyy,1);
		end if;
  else
if (position('MM' in vrepeatby) > 0) and
	   (position('YY' in vrepeatby) > 0) then
set vtrap = 2;
		select count(1)
		into vcurrvalue
		from snrodet
		where snroid = vsnroid and curmm = vmm and curyy = vyy;


		if vcurrvalue > 0 then
			select curvalue
			into vcurrvalue
			from snrodet
			where snroid = vsnroid and curmm = vmm and curyy = vyy;

			set vcurrvalue=vcurrvalue + 1;

			update snrodet
			set curvalue = vcurrvalue
			where snroid = vsnroid and curmm = vmm and curyy = vyy;
		else
			set vcurrvalue=1;
			insert into snrodet (snroid,curdd,curmm,curyy,curvalue)
			values (vsnroid,0,vmm,vyy,1);
		end if;
  else
	if (position('YY' in vrepeatby) > 0) then
		select count(1)
		into vcurrvalue
		from snrodet
		where snroid = vsnroid and curyy = vyy;

		if vcurrvalue > 0 then
			select curvalue
			into vcurrvalue
			from snrodet
			where snroid = vsnroid and curyy = vyy;

			set vcurrvalue=vcurrvalue + 1;
			
			update snrodet
			set curvalue = vcurrvalue
			where snroid = vsnroid and curyy = vyy;
		else
			set vcurrvalue=1;
			insert into snrodet (snroid,curdd,curmm,curyy,curvalue)
			values (vsnroid,0,0,vyy,1);
		end if;
  end if;

  end if;

  end if;
	end if;


	select concat(abc,substring(formatdoc,length(abc)+1)) 
	into vformatdoc
	from (
	select formatdoc,formatno, concat(left(formatdoc,position(formatno in formatdoc)-1),
	concat(left(formatno,length(formatno)-length(angka)),angka))
	as abc
	from (
	select vcurrvalue as angka, formatdoc, formatno 
	from snro where snroid = vsnroid
	) a ) b;

	if vdd < 10 then
		select replace(vformatdoc,'DD',concat('0',vdd)) into vformatdoc;
	else
		select replace(vformatdoc,'DD',vdd) into vformatdoc;
	end if;

	if vmm < 10 then
		select replace(vformatdoc,'MM',concat('0',vmm)) into vformatdoc;
	else
		select replace(vformatdoc,'MM',vmm) into vformatdoc;
	end if;
	
	if (position('YY' in vrepeatby) > 0) then
		if lyy = 4 then
			select replace(vformatdoc,'YYYY',vyy) into vformatdoc;
		else
		if lyy = 2 then
			select replace(vformatdoc,'YY',right(vyy,lyy)) into vformatdoc;
		end if;	
		end if;
	else
		select replace(vformatdoc,'YY',right(vyy,2)) into vformatdoc;
	end if;

	if (position('MONROM' in vformatdoc) > 0) then
		select monthrm 
		into vrom 
		from romawi
		where monthcal = vmm;
		select replace(vformatdoc,'MONROM',vrom) into vformatdoc;
	end if;

	return vformatdoc;
END$$

DROP FUNCTION IF EXISTS `GetRunNoSp`$$
CREATE DEFINER=`capella3`@`localhost` FUNCTION `GetRunNoSp`(vsnroid int,
vdate datetime,vCC varchar(5), vPT varchar(5), vPP varchar(5) ) RETURNS varchar(100) CHARSET utf8
BEGIN
	declare vformatdoc,vformatno,vmr,vrepeatby,vrom varchar(100);
	declare vdd,vmm,vyy,vcurrvalue,lyy integer;
	select formatdoc,formatno,repeatby
	into vformatdoc,vformatno,vrepeatby
	from snro
	where snroid = vsnroid;
	
	select day(vdate) into vdd;
	select month(vdate) into vmm;	
	select year(vdate) into vyy;
	if position('MONROM' in vformatno) then
		select monthrm into vmr 
		from romawi
		where monthcal = vmm;
	end if;

	if (position('YYYY' in vrepeatby) > 0) then
		set lyy = 4;
	else
		if (position('YY' in vrepeatby) > 0) then
			set lyy = 2;
		end if;
	end if;
	
if (vrepeatby = '') then
		select count(1)
		into vcurrvalue
		from snrodet
		where snroid = vsnroid;

		if vcurrvalue > 0 then
			select curvalue
			into vcurrvalue
			from snrodet
			where snroid = vsnroid;

			set vcurrvalue=vcurrvalue + 1;

			update snrodet
			set curvalue = vcurrvalue
			where snroid = vsnroid;
		else
			set vcurrvalue=1;
			insert into snrodet (snroid,curdd,curmm,curyy,curvalue, curcc,curpt,curpp)
			values (vsnroid,0,0,0,1,vcc,vpt,vpp);
		end if;
else
if (position('MT' in vrepeatby) > 0) and
	   (position('PMG' in vrepeatby) > 0) and
	   (position('MM' in vrepeatby) > 0) and
	   (position('YY' in vrepeatby) > 0) and
	   (position('MGO' in vrepeatby) > 0) then
		select count(1)
		into vcurrvalue
		from snrodet
		where snroid = vsnroid and curdd = vdd and curmm = vmm and curyy = vyy and
       curcc = vcc and curpt = vpt and curpp = vpp;

		if vcurrvalue > 0 then
			select curvalue
			into vcurrvalue
			from snrodet
			where snroid = vsnroid and curdd = vdd and curmm = vmm and curyy = vyy and
       curcc = vcc and curpt = vpt and curpp = vpp;

			set vcurrvalue=vcurrvalue + 1;

			update snrodet
			set curvalue = vcurrvalue
			where snroid = vsnroid and curdd = vdd and curmm = vmm and curyy = vyy and
       curcc = vcc and curpt = vpt and curpp = vpp;
		else
			set vcurrvalue=1;
			insert into snrodet (snroid,curdd,curmm,curyy,curvalue,curcc,curpt,curpp)
			values (vsnroid,vdd,vmm,vyy,1,vcc,vpt,vpp);
		end if;
  else
if (position('MT' in vrepeatby) > 0) and
	   (position('MM' in vrepeatby) > 0) and
	   (position('YY' in vrepeatby) > 0) and
	   (position('MGO' in vrepeatby) > 0) then
		select count(1)
		into vcurrvalue
		from snrodet
		where snroid = vsnroid and curdd = vdd and curmm = vmm and curyy = vyy and
       curcc = vcc and curpt = vpt;

		if vcurrvalue > 0 then
			select curvalue
			into vcurrvalue
			from snrodet
			where snroid = vsnroid and curdd = vdd and curmm = vmm and curyy = vyy and
       curcc = vcc and curpt = vpt;

			set vcurrvalue=vcurrvalue + 1;

			update snrodet
			set curvalue = vcurrvalue
			where snroid = vsnroid and curdd = vdd and curmm = vmm and curyy = vyy and
       curcc = vcc and curpt = vpt;
		else
			set vcurrvalue=1;
			insert into snrodet (snroid,curdd,curmm,curyy,curvalue,curcc,curpt)
			values (vsnroid,vdd,vmm,vyy,1,vcc,vpt);
		end if;
  else
if (position('CC' in vrepeatby) > 0) and
	   (position('PT' in vrepeatby) > 0) and
	   (position('MM' in vrepeatby) > 0) and
	   (position('YY' in vrepeatby) > 0) and
	   (position('PP' in vrepeatby) > 0) then
		select count(1)
		into vcurrvalue
		from snrodet
		where snroid = vsnroid and curdd = vdd and curmm = vmm and curyy = vyy and
       curcc = vcc and curpt = vpt and curpp = vpp;

		if vcurrvalue > 0 then
			select curvalue
			into vcurrvalue
			from snrodet
			where snroid = vsnroid and curdd = vdd and curmm = vmm and curyy = vyy and
       curcc = vcc and curpt = vpt and curpp = vpp;

			set vcurrvalue=vcurrvalue + 1;
			
			update snrodet
			set curvalue = vcurrvalue
			where snroid = vsnroid and curdd = vdd and curmm = vmm and curyy = vyy and
       curcc = vcc and curpt = vpt and curpp = vpp;
		else
			set vcurrvalue=1;
			insert into snrodet (snroid,curdd,curmm,curyy,curvalue,curcc,curpt,curpp)
			values (vsnroid,vdd,vmm,vyy,1,vcc,vpt,vpp);
		end if;
  else
if (position('DD' in vrepeatby) > 0) and
	   (position('MM' in vrepeatby) > 0) and
	   (position('YY' in vrepeatby) > 0) then
		select count(1)
		into vcurrvalue
		from snrodet
		where snroid = vsnroid and curdd = vdd and curmm = vmm and curyy = vyy;

		if vcurrvalue > 0 then
			select curvalue
			into vcurrvalue
			from snrodet
			where snroid = vsnroid and curdd = vdd and curmm = vmm and curyy = vyy;

			set vcurrvalue=vcurrvalue + 1;
			
			update snrodet
			set curvalue = vcurrvalue
			where snroid = vsnroid and curdd = vdd and curmm = vmm and curyy = vyy;
		else
			set vcurrvalue=1;
			insert into snrodet (snroid,curdd,curmm,curyy,curvalue)
			values (vsnroid,vdd,vmm,vyy,1);
		end if;
	else
if (position('MM' in vrepeatby) > 0) and
	   (position('YY' in vrepeatby) > 0) then
		select count(1)
		into vcurrvalue
		from snrodet
		where snroid = vsnroid and curmm = vmm and curyy = vyy;

		if vcurrvalue > 0 then
			select curvalue
			into vcurrvalue
			from snrodet
			where snroid = vsnroid and curmm = vmm and curyy = vyy;

			set vcurrvalue=vcurrvalue + 1;
			
			update snrodet
			set curvalue = vcurrvalue
			where snroid = vsnroid and curmm = vmm and curyy = vyy;
		else
			set vcurrvalue=1;
			insert into snrodet (snroid,curdd,curmm,curyy,curvalue)
			values (vsnroid,0,vmm,vyy,1);
		end if;	
	else
	if (position('YY' in vrepeatby) > 0) then
		select count(1)
		into vcurrvalue
		from snrodet
		where snroid = vsnroid and curyy = vyy;

		if vcurrvalue > 0 then
			select curvalue
			into vcurrvalue
			from snrodet
			where snroid = vsnroid and curyy = vyy;

			set vcurrvalue=vcurrvalue + 1;
			
			update snrodet
			set curvalue = vcurrvalue
			where snroid = vsnroid and curyy = vyy;
		else
			set vcurrvalue=1;
			insert into snrodet (snroid,curdd,curmm,curyy,curvalue)
			values (vsnroid,0,0,vyy,1);
		end if;


	end if;	
	end if; 
	end if;
	end if;
end if;
end if;
end if;

	

	select concat(abc,substring(formatdoc,length(abc)+1)) 
	into vformatdoc
	from (
	select formatdoc,formatno, concat(left(formatdoc,position(formatno in formatdoc)-1),
	concat(left(formatno,length(formatno)-length(angka)),angka))
	as abc
	from (
	select vcurrvalue as angka, formatdoc, formatno 
	from snro where snroid = vsnroid
	) a ) b;

	if vdd < 10 then
		select replace(vformatdoc,'DD',concat('0',vdd)) into vformatdoc;
	else
		select replace(vformatdoc,'DD',vdd) into vformatdoc;
	end if;

	if vmm < 10 then
		select replace(vformatdoc,'MM',concat('0',vmm)) into vformatdoc;
	else
		select replace(vformatdoc,'MM',vmm) into vformatdoc;
	end if;
	
	if (position('YY' in vrepeatby) > 0) then
		if lyy = 4 then
			select replace(vformatdoc,'YYYY',vyy) into vformatdoc;
		else
		if lyy = 2 then
			select replace(vformatdoc,'YY',right(vyy,lyy)) into vformatdoc;
		end if;	
		end if;
	else
		select replace(vformatdoc,'YY',right(vyy,2)) into vformatdoc;
	end if;

	if (position('MONROM' in vformatdoc) > 0) then
		select monthrm 
		into vrom 
		from romawi
		where monthcal = vmm;
		select replace(vformatdoc,'MONROM',vrom) into vformatdoc;
	end if;

  if (position('CC' in vformatdoc) > 0) then
    select replace(vformatdoc,'CC',vcc) into vformatdoc;
  end if;

  if (position('PT' in vformatdoc) > 0) then
    select replace(vformatdoc,'PT',vpt) into vformatdoc;
  end if;


  if (position('PP' in vformatdoc) > 0) then
    select replace(vformatdoc,'PP',vpp) into vformatdoc;
  end if;

  if (position('MT' in vformatdoc) > 0) then
    select replace(vformatdoc,'MT',vcc) into vformatdoc;
  end if;

  if (position('MGO' in vformatdoc) > 0) then
    select replace(vformatdoc,'MGO',vpt) into vformatdoc;
  end if;


  if (position('PMG' in vformatdoc) > 0) then
    select replace(vformatdoc,'PMG',vpp) into vformatdoc;
  end if;

	return vformatdoc;
END$$

DROP FUNCTION IF EXISTS `GetWfBefStat`$$
CREATE DEFINER=`capella3`@`localhost` FUNCTION `GetWfBefStat`(vwfname varchar(50), 
vcreatedby varchar(50)) RETURNS int(11)
BEGIN
	declare vreturn int;
	select b.wfbefstat
	into vreturn
	from assignments a
	inner join wfgroup b on upper(b.items) = upper(a.itemname)
	inner join workflow c on c.workflowid = b.workflowid
	where a.userid = vcreatedby and upper(c.wfname) = upper(vwfname);

	return vreturn;
END$$

DROP FUNCTION IF EXISTS `GetWfBefStatByCreated`$$
CREATE DEFINER=`capella3`@`localhost` FUNCTION `GetWfBefStatByCreated`(vwfname varchar(50),
vbefstat tinyint,
vcreatedby varchar(50)) RETURNS int(11)
BEGIN
	declare vreturn int;

  select ifnull(count(1),0)
	into vreturn
	from usergroup a
  inner join useraccess d on d.useraccessid = a.useraccessid
	inner join wfgroup b on b.groupaccessid = a.groupaccessid
	inner join workflow c on c.workflowid = b.workflowid
	where upper(d.username) = upper(vcreatedby) and upper(c.wfname) = upper(vwfname) and b.wfbefstat = vbefstat;

  if vreturn > 0 then
	select b.wfgroupid
	into vreturn
	from usergroup a
  inner join useraccess d on d.useraccessid = a.useraccessid
	inner join wfgroup b on b.groupaccessid = a.groupaccessid
	inner join workflow c on c.workflowid = b.workflowid
	where upper(d.username) = upper(vcreatedby) and upper(c.wfname) = upper(vwfname) and b.wfbefstat = vbefstat;
  end if;

	return vreturn;
END$$

DROP FUNCTION IF EXISTS `GetWFCompareMax`$$
CREATE DEFINER=`capella3`@`localhost` FUNCTION `GetWFCompareMax`(vwfname varchar(50),
vnextstat int,
vcreatedby varchar(50)) RETURNS int(11)
BEGIN
	declare vrecstat,vmaxstat,vreturn int;
	select distinct b.wfrecstat,c.wfmaxstat
	into vrecstat,vmaxstat
	from usergroup a
  inner join useraccess d on d.useraccessid = a.useraccessid
	inner join wfgroup b on b.groupaccessid = a.groupaccessid
	inner join workflow c on c.workflowid = b.workflowid
	where upper(d.username) = upper(vcreatedby) and upper(c.wfname) = upper(vwfname) and b.wfbefstat = vnextstat-1;

	if vnextstat = vmaxstat then
		set vreturn = 1;
	else
		set vreturn = 0;
	end if;

	return vreturn;
END$$

DROP FUNCTION IF EXISTS `GetWFCompareMinApp`$$
CREATE DEFINER=`capella3`@`localhost` FUNCTION `GetWFCompareMinApp`(vwfname varchar(50),
vnextstat int,
vcreatedby varchar(50)) RETURNS int(11)
BEGIN
	declare vrecstat,vmaxstat,vreturn int;
	select b.wfrecstat,c.wfminstat
	into vrecstat,vmaxstat
	from usergroup a
  inner join useraccess d on d.useraccessid = a.useraccessid
	inner join wfgroup b on b.groupaccessid = a.groupaccessid
	inner join workflow c on c.workflowid = b.workflowid
	where upper(d.username) = upper(vcreatedby) and upper(c.wfname) = upper(vwfname) limit 1;


	if vnextstat = vmaxstat then
		set vreturn = 1;
	else
		set vreturn = 0;
	end if;

	return vreturn;
END$$

DROP FUNCTION IF EXISTS `GetWfMaxStatByWfName`$$
CREATE DEFINER=`capella3`@`localhost` FUNCTION `GetWfMaxStatByWfName`(vwfname varchar(50)) RETURNS int(11)
BEGIN
	declare vreturn int;

	select ifnull(count(1),0)
	into vreturn
	from workflow c
	where upper(c.wfname) = upper(vwfname);

  if vreturn > 0 then
	  select c.wfmaxstat
	  into vreturn
	  from workflow c
	  where upper(c.wfname) = upper(vwfname);
  end if;

	return vreturn;
END$$

DROP FUNCTION IF EXISTS `GetWfMinStatByWfName`$$
CREATE DEFINER=`capella3`@`localhost` FUNCTION `GetWfMinStatByWfName`(vwfname varchar(50),vcreatedby integer) RETURNS int(11)
BEGIN
	declare vreturn int;
	select c.wfminstat
	into vreturn
	from usergroup a
	inner join wfgroup b on b.groupaccessid = a.groupaccessid
	inner join workflow c on c.workflowid = b.workflowid
	where a.useraccessid = vcreatedby and upper(c.wfname) = upper(vwfname);

	return vreturn;
END$$

DROP FUNCTION IF EXISTS `GetWfNextStatByCreated`$$
CREATE DEFINER=`capella3`@`localhost` FUNCTION `GetWfNextStatByCreated`(vwfname varchar(50), 
vbefstat tinyint,
vcreatedby varchar(50)) RETURNS int(11)
BEGIN
	declare vreturn int;
	select ifnull(b.wfgroupid,0)
	into vreturn
	from assignments a
	inner join wfgroup b on upper(b.items) = upper(a.itemname)
	inner join workflow c on c.workflowid = b.workflowid
	where a.userid = vcreatedby and upper(c.wfname) = upper(vwfname) and b.wfrecstat = vbefstat;

	return vreturn;
END$$

DROP FUNCTION IF EXISTS `GetWFRecStatByCreated`$$
CREATE DEFINER=`capella3`@`localhost` FUNCTION `GetWFRecStatByCreated`(vwfname varchar(50),
vbefstat tinyint,
vcreatedby varchar(50)) RETURNS int(11)
BEGIN
	declare vreturn int;

  select ifnull(count(1),0)
  into vreturn
	from usergroup a
  inner join useraccess d on d.useraccessid = a.useraccessid
	inner join wfgroup b on b.groupaccessid = a.groupaccessid
	inner join workflow c on c.workflowid = b.workflowid
	where upper(d.username) = upper(vcreatedby) and upper(c.wfname) = upper(vwfname) and b.wfbefstat = vbefstat;

  if vreturn > 0 then
	  select b.wfrecstat
	  into vreturn
	  from usergroup a
    inner join useraccess d on d.useraccessid = a.useraccessid
	  inner join wfgroup b on b.groupaccessid = a.groupaccessid
	  inner join workflow c on c.workflowid = b.workflowid
	  where upper(d.username) = upper(vcreatedby) and upper(c.wfname) = upper(vwfname) and b.wfbefstat = vbefstat;
  end if;
	return vreturn;
END$$

COMMIT;
