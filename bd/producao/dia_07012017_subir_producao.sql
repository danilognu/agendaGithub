UPDATE menu set nome = 'Solicitação' where id_menu = 12


UPDATE menu set ordenacao = 1 where id_menu = 12;
UPDATE menu set ordenacao = 2 where id_menu = 30;
UPDATE menu set ordenacao = 3 where id_menu = 13;
UPDATE menu set ordenacao = 4 where id_menu = 25;

UPDATE menu set url = '../../solicitacao/apresentacao/consulta-atencimentos.php' where id_menu = 30;