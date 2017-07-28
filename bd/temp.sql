

SELECT 
                        solicitacao.id_solicitacao
                        ,setor.nome as setor
                        ,DATE_FORMAT(solicitacao.dt_saida, '%d/%m/%Y %H:%i') dt_saida 
                        ,DATE_FORMAT(solicitacao.dt_retorno_prev, '%d/%m/%Y %H:%i') dt_retorno_prev 
                        ,veiculo.placa
                        ,motorista.nome as motorista
                        ,status_solicitacao.nome situacao
                        ,(
                            SELECT localidade.nome
                            FROM destinos 
                            INNER JOIN localidade ON localidade.id_localidade = destinos.id_localidade
                            WHERE destinos.id_solicitacao = solicitacao.id_solicitacao 
                            ORDER BY  id_destino DESC LIMIT 1
                        ) as destino
		    ,DATE_FORMAT(solicitacao.dt_saida, '%H:%i') dt_saida
                    FROM solicitacao
                        INNER JOIN veiculo ON veiculo.id_veiculo = solicitacao.id_veiculo
                        INNER JOIN pessoa motorista ON motorista.id_pessoa = solicitacao.id_pessoa_motorista
                        INNER JOIN status_solicitacao ON status_solicitacao.id_status_solicitacao = solicitacao.id_status_solicitacao
                        LEFT JOIN setor ON setor.id_setor = solicitacao.id_setor
                    WHERE status_solicitacao.id_status_solicitacao = 3 
                    ORDER BY solicitacao.dt_saida

SELECT solicitacao.dt_saida
	,TIMEDIFF(solicitacao.dt_saida,now())
FROM solicitacao where id_solicitacao = 41

update solicitacao set dt_saida = '2016/12/27 18:00' where id_solicitacao = 41

SELECT valor_parametro.valor 
FROM parametros 
INNER JOIN valor_parametro ON valor_parametro.id_parametro = parametros.id_parametro
WHERE parametros.id_parametro = 1

select * from parametros







