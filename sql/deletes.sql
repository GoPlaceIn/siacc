select * from mescaso


select * from mescasohipotdiagn

/* excluir hipótese diagnóstica */
delete from mesrelhipotesesexames where codcaso = 4 and codhipotese in(6, 7)
delete from mescasohipotdiagn where codcaso = 4 and codhipotese in(6, 7)


select * from mesrelhipotesesexames where codcaso = 4 and codhipotese in(6, 7)


select * from mescasoexames where codcaso = 4 and codexame = 16

/* excluir exame */
delete from mesrelexamediagnostico where codcaso = 4 and codexame = 16
delete from mescasoexamesitens where codcaso = 4 and codexame = 16
delete from mescasoexames where codcaso = 4 and codexame = 16