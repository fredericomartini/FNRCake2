-- Trigger: gera_classificacao on jogos

-- DROP TRIGGER gera_classificacao ON jogos;

CREATE TRIGGER gera_classificacao
  AFTER UPDATE OR DELETE
  ON jogos
  FOR EACH ROW
  EXECUTE PROCEDURE trg_classificacao();