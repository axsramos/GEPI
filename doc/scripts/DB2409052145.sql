use db_gepi;

create or replace view ViewEquipmentAvailable as

select 
	Equipment.EqpCod as EqpCod,
    Equipment.EqpDsc as EqpDsc,
    (select concat(PicDir, PicSrc, '.', PicExt) from Picture where Picture.PicCod = Equipment.EqpPic) as EqpImgSrc
from (
	select EqpCod from (
	(
		select EqpCod 
		from StockFlow 
		where StkFlwRsvCod = 0 
		  and StkFlwBlq = 'S'
	) union (
		select EqpCod 
		from Equipment 
		where EqpBlq = 'N'
	)
	) as FilterEquipmentAvailable
	group by EqpCod
) as EquipmentAvailable
inner join Equipment
on Equipment.EqpCod = EquipmentAvailable.EqpCod
;
