use db_gepi;

-- // data fake // --
insert into Collaborator (ClbCod,ClbNme,ClbBlq,ClbSup,ClbKey)
value ('c6139297-6b91-11ef-9f1a-00090faa0001', 'Agatha Sarah Viana', 'N', 'S', '2f13225d-6b92-11ef-9f1a-00090faa0001');

insert into Collaborator (ClbCod,ClbNme,ClbBlq,ClbSup,ClbKey)
value ('41b906de-6b92-11ef-9f1a-00090faa0001', 'Carlos Davi Pires', 'N', 'N', '596d0810-6b92-11ef-9f1a-00090faa0001');

insert into Collaborator (ClbCod,ClbNme,ClbBlq,ClbSup,ClbKey)
value ('64257b66-6b92-11ef-9f1a-00090faa0001', 'Ruan Yuri Renato Peixoto', 'N', 'N', '7413e356-6b92-11ef-9f1a-00090faa0001');

insert into Collaborator (ClbCod,ClbNme,ClbBlq,ClbSup,ClbKey)
value ('882c68f0-6b92-11ef-9f1a-00090faa0001', 'Manoel Luiz Paulo Assis', 'N', 'N', '8d61832e-6b92-11ef-9f1a-00090faa0001');

-- // data fake // --

-- Botina Bidensidade com Bico de PVC 10VB48BP Vulcaflex - Marluvas | CA - 43377
insert into Picture (PicCod,PicNme,PicSrc,PicDir,PicExt,PicSze)
values ('716ba88a-6b93-11ef-9f1a-00090faa0001','Botina Bidensidade com Bico de PVC 10VB48BP Vulcaflex - Marluvas','botina_marluvas_14','/images/','webp',4856);

-- Bota de PVC Cano Médio 25cm Branca 110VFLEXBR Vulcaflex - Marluvas | CA - 42291
insert into Picture (PicCod,PicNme,PicSrc,PicDir,PicExt,PicSze)
values ('3887c6a5-6b94-11ef-9f1a-00090faa0001','Bota de PVC Cano Médio 25cm Branca 110VFLEXBR Vulcaflex - Marluvas','bota_branca_marluvas_1_1','/images/','jpg',5899);

-- Bota de PVC Cano Médio 25cm Preta 110VFLEXPRA Vulcaflex - Marluvas | CA - 42291
insert into Picture (PicCod,PicNme,PicSrc,PicDir,PicExt,PicSze)
values ('7e6d74e0-6b94-11ef-9f1a-00090faa0001','Bota de PVC Cano Médio 25cm Preta 110VFLEXPRA Vulcaflex - Marluvas','bota-de-pvc-cano-medio-25cm-preta-110vflexpra-vulcaflex-marluvas-ca-42291-1','/images/','jpg',8725);

-- Capacete Classe A e B Branco H700 com Carneira de Ajuste Fácil e Jugular - 3M | CA - 29638
insert into Picture (PicCod,PicNme,PicSrc,PicDir,PicExt,PicSze)
values ('d0070180-6b94-11ef-9f1a-00090faa0001','Capacete Classe A e B Branco H700 com Carneira de Ajuste Fácil e Jugular - 3M','capacete_2','/images/','webp',3224);

-- Abafador Concha Acoplável - 3M | CA - 33835
insert into Picture (PicCod,PicNme,PicSrc,PicDir,PicExt,PicSze)
values ('226928dd-6b95-11ef-9f1a-00090faa0001','Abafador Concha Acoplável - 3M','acoplavel_3m','/images/','jpg',12965);

-- Abafador Concha Acoplável - Camper | CA - 43430
insert into Picture (PicCod,PicNme,PicSrc,PicDir,PicExt,PicSze)
values ('5d075926-6b95-11ef-9f1a-00090faa0001','Abafador Concha Acoplável - Camper','abafador_concha_acopl_vel_-_camper_ca_-_43430_1','/images/','jpg',13373);

-- // data fake // --
insert into equipment (EqpCod,EqpDsc,EqpPic,EqpBlq,EqpObs)
values ('6aa48018-6b96-11ef-9f1a-00090faa0001','Botina Bidensidade com Bico de PVC 10VB48BP Vulcaflex - Marluvas | CA - 43376','716ba88a-6b93-11ef-9f1a-00090faa0001','N','Tamanho P');

insert into equipment (EqpCod,EqpDsc,EqpPic,EqpBlq,EqpObs)
values ('d2459317-6b95-11ef-9f1a-00090faa0001','Botina Bidensidade com Bico de PVC 10VB48BP Vulcaflex - Marluvas | CA - 43377','716ba88a-6b93-11ef-9f1a-00090faa0001','N','Tamanho M');

insert into equipment (EqpCod,EqpDsc,EqpPic,EqpBlq,EqpObs)
values ('769273bf-6b96-11ef-9f1a-00090faa0001','Botina Bidensidade com Bico de PVC 10VB48BP Vulcaflex - Marluvas | CA - 43378','716ba88a-6b93-11ef-9f1a-00090faa0001','N','Tamanho G');

insert into equipment (EqpCod,EqpDsc,EqpPic,EqpBlq,EqpObs)
values ('8a7f5c59-6b96-11ef-9f1a-00090faa0001','Botina Bidensidade com Bico de PVC 10VB48BP Vulcaflex - Marluvas | CA - 43379','716ba88a-6b93-11ef-9f1a-00090faa0001','S','Tamanho G');

insert into equipment (EqpCod,EqpDsc,EqpPic,EqpBlq,EqpObs)
values ('d73755e6-6b97-11ef-9f1a-00090faa0001','Bota de PVC Cano Médio 25cm Branca 110VFLEXBR Vulcaflex - Marluvas | CA - 42291','3887c6a5-6b94-11ef-9f1a-00090faa0001','N','Tamanho G');

insert into equipment (EqpCod,EqpDsc,EqpPic,EqpBlq,EqpObs)
values ('0977d783-6b98-11ef-9f1a-00090faa0001','Bota de PVC Cano Médio 25cm Branca 110VFLEXBR Vulcaflex - Marluvas | CA - 42292','3887c6a5-6b94-11ef-9f1a-00090faa0001','N','Tamanho G');

insert into equipment (EqpCod,EqpDsc,EqpPic,EqpBlq,EqpObs)
values ('1bdcf0a5-6b98-11ef-9f1a-00090faa0001','Bota de PVC Cano Médio 25cm Branca 110VFLEXBR Vulcaflex - Marluvas | CA - 42293','3887c6a5-6b94-11ef-9f1a-00090faa0001','N','Tamanho M');

