use db_gepi;

create or replace view ViewEquipmentAvailable as

select 
	equipment.EqpCod as EqpCod,
    equipment.EqpDsc as EqpDsc,
    (select concat(PicDir, PicSrc, '.', PicExt) from Picture where Picture.PicCod = equipment.EqpPic) as EqpImgSrc
from (
	select EqpCod from (
	(
		select EqpCod 
		from stockflow 
		where StkFlwRsvCod = 0 
		  and StkFlwBlq = 'S'
	) union (
		select EqpCod 
		from equipment 
		where EqpBlq = 'N'
	)
	) as FilterEquipmentAvailable
	group by EqpCod
) as EquipmentAvailable
inner join equipment
on equipment.EqpCod = EquipmentAvailable.EqpCod
;
