-- Function: trg_classificacao()

-- DROP FUNCTION trg_classificacao();

CREATE OR REPLACE FUNCTION trg_classificacao()
  RETURNS trigger AS
$BODY$
DECLARE
  v_pontos_mandante integer;
  v_jogos_mandante integer;
  v_vitorias_mandante integer;
  v_emptates_mandante integer;
  v_derrotas_mandante integer;
  v_golsp_mandante integer;
  v_golsc_mandante integer;
  v_saldo_mandante integer;
  v_aprov_mandante integer;
  c_item RECORD;
BEGIN 
  --
  IF (TG_OP = 'DELETE') THEN
    --
    -- Limpa os dados do time mandante
    --
    UPDATE grupoclubes SET pontos = 0,
			   jogos = 0,
			   vitorias = 0,
			   empates = 0,
			   derrotas = 0,
			   gols_pro = 0,
			   gols_contras = 0,
			   saldo = 0,
			   aproveitamento = 0
		     WHERE campeonato_id = OLD.campeonato_id
		       AND ano = OLD.ano
		       AND formula_id = OLD.formula_id
		       AND clube_id = OLD.clube_id_01
		       AND fase_id = OLD.fase_id
		       AND grupo_id = OLD.grupo_id;
    --
    -- Jogos que o time mandante jogou em casa
    --
    FOR c_item IN SELECT clube_id_01, 
			 clube_id_02, 
			 gols_01, 
			 gols_02 
		    FROM jogos 
		   WHERE campeonato_id = OLD.campeonato_id
		     AND ano = OLD.ano
		     AND formula_id = OLD.formula_id
		     AND clube_id_01 = OLD.clube_id_01
		     AND fase_id = OLD.fase_id
		     AND grupo_id = OLD.grupo_id
		     AND situacaojogo = 4
    LOOP
    --
      IF (c_item.gols_01 >  c_item.gols_02) THEN
        --
        UPDATE grupoclubes SET pontos = pontos + 3,
			       jogos = jogos + 1,
			       vitorias = vitorias + 1,
			       gols_pro = gols_pro + c_item.gols_01,
			       gols_contras = gols_contras + c_item.gols_02,
			       saldo = saldo + (c_item.gols_01 - c_item.gols_02)
		         WHERE campeonato_id = OLD.campeonato_id
		           AND ano = OLD.ano
		           AND formula_id = OLD.formula_id
		           AND clube_id = OLD.clube_id_01
		           AND fase_id = OLD.fase_id
		           AND grupo_id = OLD.grupo_id;
        --
      ELSIF (c_item.gols_01 <  c_item.gols_02) THEN
        --
        UPDATE grupoclubes SET jogos = jogos + 1,
			       derrotas = derrotas + 1,
			       gols_pro = gols_pro + c_item.gols_01,
			       gols_contras = gols_contras + c_item.gols_02,
			       saldo = saldo - (c_item.gols_02 - c_item.gols_01)
		         WHERE campeonato_id = OLD.campeonato_id
		           AND ano = OLD.ano
		           AND formula_id = OLD.formula_id
		           AND clube_id = OLD.clube_id_01
		           AND fase_id = OLD.fase_id
		           AND grupo_id = OLD.grupo_id;
        --
      ELSIF (c_item.gols_01 =  c_item.gols_02) THEN
        --
        UPDATE grupoclubes SET pontos = pontos + 1,
			       jogos = jogos + 1,
			       empates = empates + 1,
			       gols_pro = gols_pro + c_item.gols_01,
			       gols_contras = gols_contras + c_item.gols_02
		         WHERE campeonato_id = OLD.campeonato_id
		           AND ano = OLD.ano
		           AND formula_id = OLD.formula_id
		           AND clube_id = OLD.clube_id_01
		           AND fase_id = OLD.fase_id
		           AND grupo_id = OLD.grupo_id;
        --
      END IF;
      --
    END LOOP;
    --
    -- Jogos que o time mandante jogou fora
    --
    FOR c_item IN SELECT clube_id_01, 
			 clube_id_02, 
			 gols_01, 
			 gols_02 
		    FROM jogos 
		   WHERE campeonato_id = OLD.campeonato_id
		     AND ano = OLD.ano
		     AND formula_id = OLD.formula_id
		     AND clube_id_02 = OLD.clube_id_01
		     AND fase_id = OLD.fase_id
		     AND grupo_id = OLD.grupo_id
		     AND situacaojogo = 4
    LOOP
      --
      IF (c_item.gols_02 >  c_item.gols_01) THEN
        --
        UPDATE grupoclubes SET pontos = pontos + 3,
			       jogos = jogos + 1,
			       vitorias = vitorias + 1,
			       gols_pro = gols_pro + c_item.gols_02,
			       gols_contras = gols_contras + c_item.gols_01,
			       saldo = saldo + (c_item.gols_02 - c_item.gols_01)
		         WHERE campeonato_id = OLD.campeonato_id
		           AND ano = OLD.ano
		           AND formula_id = OLD.formula_id
		           AND clube_id = OLD.clube_id_01
		           AND fase_id = OLD.fase_id
		           AND grupo_id = OLD.grupo_id;
        --
      ELSIF (c_item.gols_02 <  c_item.gols_01) THEN
        --
        UPDATE grupoclubes SET jogos = jogos + 1,
			       derrotas = derrotas + 1,
			       gols_pro = gols_pro + c_item.gols_02,
			       gols_contras = gols_contras + c_item.gols_01,
			       saldo = saldo - (c_item.gols_01 - c_item.gols_02)
		         WHERE campeonato_id = OLD.campeonato_id
		           AND ano = OLD.ano
		           AND formula_id = OLD.formula_id
		           AND clube_id = OLD.clube_id_01
		           AND fase_id = OLD.fase_id
		           AND grupo_id = OLD.grupo_id;
        --
      ELSIF (c_item.gols_02 =  c_item.gols_01) THEN
        --
        UPDATE grupoclubes SET pontos = pontos + 1,
			       jogos = jogos + 1,
			       empates = empates + 1,
			       gols_pro = gols_pro + c_item.gols_02,
			       gols_contras = gols_contras + c_item.gols_01
		         WHERE campeonato_id = OLD.campeonato_id
		           AND ano = OLD.ano
		           AND formula_id = OLD.formula_id
		           AND clube_id = OLD.clube_id_01
		           AND fase_id = OLD.fase_id
		           AND grupo_id = OLD.grupo_id;
        --
      END IF;
      --
    END LOOP;
    --
    -- Atualiza o aproveitamento do clube mandante
    --
    UPDATE grupoclubes SET aproveitamento = CASE WHEN jogos = 0 THEN 0 ELSE (pontos * 100 / (jogos * 3)) END
		     WHERE campeonato_id = OLD.campeonato_id
		       AND ano = OLD.ano
		       AND formula_id = OLD.formula_id
		       AND clube_id = OLD.clube_id_01
		       AND fase_id = OLD.fase_id
		       AND grupo_id = OLD.grupo_id;
    --
    -- Limpa os dados do time visitante
    --
    UPDATE grupoclubes SET pontos = 0,
			   jogos = 0,
			   vitorias = 0,
			   empates = 0,
			   derrotas = 0,
			   gols_pro = 0,
			   gols_contras = 0,
			   saldo = 0,
			   aproveitamento = 0
		     WHERE campeonato_id = OLD.campeonato_id
		       AND ano = OLD.ano
		       AND formula_id = OLD.formula_id
		       AND clube_id = OLD.clube_id_02
		       AND fase_id = OLD.fase_id
		       AND grupo_id = OLD.grupo_id;
    --
    -- Jogos que o time visitante jogou em casa
    --
    FOR c_item IN SELECT clube_id_01, 
			 clube_id_02, 
			 gols_01, 
			 gols_02 
		    FROM jogos 
		   WHERE campeonato_id = OLD.campeonato_id
		     AND ano = OLD.ano
		     AND formula_id = OLD.formula_id
		     AND clube_id_01 = OLD.clube_id_02
		     AND fase_id = OLD.fase_id
		     AND grupo_id = OLD.grupo_id
		     AND situacaojogo = 4
    LOOP
    --
      IF (c_item.gols_01 >  c_item.gols_02) THEN
        --
        UPDATE grupoclubes SET pontos = pontos + 3,
			       jogos = jogos + 1,
			       vitorias = vitorias + 1,
			       gols_pro = gols_pro + c_item.gols_01,
			       gols_contras = gols_contras + c_item.gols_02,
			       saldo = saldo + (c_item.gols_01 - c_item.gols_02)
		         WHERE campeonato_id = OLD.campeonato_id
		           AND ano = OLD.ano
		           AND formula_id = OLD.formula_id
		           AND clube_id = OLD.clube_id_02
		           AND fase_id = OLD.fase_id
		           AND grupo_id = OLD.grupo_id;
        --
      ELSIF (c_item.gols_01 <  c_item.gols_02) THEN
        --
        UPDATE grupoclubes SET jogos = jogos + 1,
			       derrotas = derrotas + 1,
			       gols_pro = gols_pro + c_item.gols_01,
			       gols_contras = gols_contras + c_item.gols_02,
			       saldo = saldo - (c_item.gols_02 - c_item.gols_01)
		         WHERE campeonato_id = OLD.campeonato_id
		           AND ano = OLD.ano
		           AND formula_id = OLD.formula_id
		           AND clube_id = OLD.clube_id_02
		           AND fase_id = OLD.fase_id
		           AND grupo_id = OLD.grupo_id;
        --
      ELSIF (c_item.gols_01 =  c_item.gols_02) THEN
        --
        UPDATE grupoclubes SET pontos = pontos + 1,
			       jogos = jogos + 1,
			       empates = empates + 1,
			       gols_pro = gols_pro + c_item.gols_01,
			       gols_contras = gols_contras + c_item.gols_02
		         WHERE campeonato_id = OLD.campeonato_id
		           AND ano = OLD.ano
		           AND formula_id = OLD.formula_id
		           AND clube_id = OLD.clube_id_02
		           AND fase_id = OLD.fase_id
		           AND grupo_id = OLD.grupo_id;
        --
      END IF;
      --
    END LOOP;
    --
    -- Jogos que o time visitante jogou fora
    --
    FOR c_item IN SELECT clube_id_01, 
			 clube_id_02, 
			 gols_01, 
			 gols_02 
		    FROM jogos 
		   WHERE campeonato_id = OLD.campeonato_id
		     AND ano = OLD.ano
		     AND formula_id = OLD.formula_id
		     AND clube_id_02 = OLD.clube_id_02
		     AND fase_id = OLD.fase_id
		     AND grupo_id = OLD.grupo_id
		     AND situacaojogo = 4
    LOOP
      --
      IF (c_item.gols_02 >  c_item.gols_01) THEN
        --
        UPDATE grupoclubes SET pontos = pontos + 3,
			       jogos = jogos + 1,
			       vitorias = vitorias + 1,
			       gols_pro = gols_pro + c_item.gols_02,
			       gols_contras = gols_contras + c_item.gols_01,
			       saldo = saldo + (c_item.gols_02 - c_item.gols_01)
		         WHERE campeonato_id = OLD.campeonato_id
		           AND ano = OLD.ano
		           AND formula_id = OLD.formula_id
		           AND clube_id = OLD.clube_id_02
		           AND fase_id = OLD.fase_id
		           AND grupo_id = OLD.grupo_id;
        --
      ELSIF (c_item.gols_02 <  c_item.gols_01) THEN
        --
        UPDATE grupoclubes SET jogos = jogos + 1,
			       derrotas = derrotas + 1,
			       gols_pro = gols_pro + c_item.gols_02,
			       gols_contras = gols_contras + c_item.gols_01,
			       saldo = saldo - (c_item.gols_01 - c_item.gols_02)
		         WHERE campeonato_id = OLD.campeonato_id
		           AND ano = OLD.ano
		           AND formula_id = OLD.formula_id
		           AND clube_id = OLD.clube_id_02
		           AND fase_id = OLD.fase_id
		           AND grupo_id = OLD.grupo_id;
        --
      ELSIF (c_item.gols_02 =  c_item.gols_01) THEN
        --
        UPDATE grupoclubes SET pontos = pontos + 1,
			       jogos = jogos + 1,
			       empates = empates + 1,
			       gols_pro = gols_pro + c_item.gols_02,
			       gols_contras = gols_contras + c_item.gols_01
		         WHERE campeonato_id = OLD.campeonato_id
		           AND ano = OLD.ano
		           AND formula_id = OLD.formula_id
		           AND clube_id = OLD.clube_id_02
		           AND fase_id = OLD.fase_id
		           AND grupo_id = OLD.grupo_id;
        --
      END IF;
      --
    END LOOP;
    --
    -- Atualiza o aproveitamento do clube visitante
    --
    UPDATE grupoclubes SET aproveitamento = CASE WHEN jogos = 0 THEN 0 ELSE (pontos * 100 / (jogos * 3)) END
		     WHERE campeonato_id = OLD.campeonato_id
		       AND ano = OLD.ano
		       AND formula_id = OLD.formula_id
		       AND clube_id = OLD.clube_id_02
		       AND fase_id = OLD.fase_id
		       AND grupo_id = OLD.grupo_id;
    --
  ELSIF (TG_OP = 'UPDATE') THEN
    --
    -- Testar se a nova situacao eh 4 e a antiga nao. Aih soh atualiza esse jogo
    --
    IF (NEW.situacaojogo = 4 AND OLD.situacaojogo <> 4) THEN
      --
      IF (NEW.gols_01 > NEW.gols_02) THEN
        --
        -- Atualiza dados do time mandante
        --
        UPDATE grupoclubes SET pontos = pontos + 3,
			       jogos = jogos + 1,
			       vitorias = vitorias + 1,
			       gols_pro = gols_pro + NEW.gols_01,
			       gols_contras = gols_contras + NEW.gols_02,
			       saldo = saldo + (NEW.gols_01 - NEW.gols_02)
		         WHERE campeonato_id = NEW.campeonato_id
		           AND ano = NEW.ano
		           AND formula_id = NEW.formula_id
		           AND clube_id = NEW.clube_id_01
		           AND fase_id = NEW.fase_id
		           AND grupo_id = NEW.grupo_id;
        --
        -- Atualiza dados do time visitante
        --
        UPDATE grupoclubes SET jogos = jogos + 1,
			       derrotas = derrotas + 1,
			       gols_pro = gols_pro + NEW.gols_02,
			       gols_contras = gols_contras + NEW.gols_01,
			       saldo = saldo - (NEW.gols_01 - NEW.gols_02)
		         WHERE campeonato_id = NEW.campeonato_id
		           AND ano = NEW.ano
		           AND formula_id = NEW.formula_id
		           AND clube_id = NEW.clube_id_02
		           AND fase_id = NEW.fase_id
		           AND grupo_id = NEW.grupo_id;
        --
      ELSIF (NEW.gols_01 <  NEW.gols_02) THEN
        --
        -- Atualiza dados do time mandante
        --
        UPDATE grupoclubes SET jogos = jogos + 1,
			       derrotas = derrotas + 1,
			       gols_pro = gols_pro + NEW.gols_01,
			       gols_contras = gols_contras + NEW.gols_02,
			       saldo = saldo - (NEW.gols_02 - NEW.gols_01)
		         WHERE campeonato_id = NEW.campeonato_id
		           AND ano = NEW.ano
		           AND formula_id = NEW.formula_id
		           AND clube_id = NEW.clube_id_01
		           AND fase_id = NEW.fase_id
		           AND grupo_id = NEW.grupo_id;
        --
        -- Atualiza dados do time visitante
        --
        UPDATE grupoclubes SET pontos = pontos + 3,
			       jogos = jogos + 1,
			       vitorias = vitorias + 1,
			       gols_pro = gols_pro + NEW.gols_02,
			       gols_contras = gols_contras + NEW.gols_01,
			       saldo = saldo + (NEW.gols_02 - NEW.gols_01)
		         WHERE campeonato_id = NEW.campeonato_id
		           AND ano = NEW.ano
		           AND formula_id = NEW.formula_id
		           AND clube_id = NEW.clube_id_02
		           AND fase_id = NEW.fase_id
		           AND grupo_id = NEW.grupo_id;
        --
      ELSIF (NEW.gols_01 =  NEW.gols_02) THEN
        --
        -- Atualiza dados do time mandante
        --
        UPDATE grupoclubes SET pontos = pontos + 1,
			       jogos = jogos + 1,
			       empates = empates + 1,
			       gols_pro = gols_pro + NEW.gols_01,
			       gols_contras = gols_contras + NEW.gols_02
		         WHERE campeonato_id = NEW.campeonato_id
		           AND ano = NEW.ano
		           AND formula_id = NEW.formula_id
		           AND clube_id = NEW.clube_id_01
		           AND fase_id = NEW.fase_id
		           AND grupo_id = NEW.grupo_id;
	--
        -- Atualiza dados do time visitante
        --
        UPDATE grupoclubes SET pontos = pontos + 1,
			       jogos = jogos + 1,
			       empates = empates + 1,
			       gols_pro = gols_pro + NEW.gols_02,
			       gols_contras = gols_contras + NEW.gols_01
		         WHERE campeonato_id = NEW.campeonato_id
		           AND ano = NEW.ano
		           AND formula_id = NEW.formula_id
		           AND clube_id = NEW.clube_id_02
		           AND fase_id = NEW.fase_id
		           AND grupo_id = NEW.grupo_id;
        --
      END IF;
      --
      -- Atualiza o aproveitamento do time mandante
      --
      UPDATE grupoclubes SET aproveitamento = CASE WHEN jogos = 0 THEN 0 ELSE (pontos * 100 / (jogos * 3)) END
		       WHERE campeonato_id = NEW.campeonato_id
		         AND ano = NEW.ano
		         AND formula_id = NEW.formula_id
		         AND clube_id = NEW.clube_id_01
		         AND fase_id = NEW.fase_id
		         AND grupo_id = NEW.grupo_id;
      --
      -- Atualiza o aproveitamento do clube visitante
      --
      UPDATE grupoclubes SET aproveitamento = CASE WHEN jogos = 0 THEN 0 ELSE (pontos * 100 / (jogos * 3)) END
		       WHERE campeonato_id = NEW.campeonato_id
		         AND ano = NEW.ano
		         AND formula_id = NEW.formula_id
		         AND clube_id = NEW.clube_id_02
		         AND fase_id = NEW.fase_id
		         AND grupo_id = NEW.grupo_id;
      --
      -- Atualiza todos os jogos dos times alterados após finalizar o jogo
      --
      ELSIF (NEW.situacaojogo = 4 AND OLD.situacaojogo = 4) THEN
      --
      -- Limpa os dados do time mandante
      --
      UPDATE grupoclubes SET pontos = 0,
			     jogos = 0,
			     vitorias = 0,
			     empates = 0,
			     derrotas = 0,
			     gols_pro = 0,
			     gols_contras = 0,
			     saldo = 0,
			     aproveitamento = 0
		       WHERE campeonato_id = NEW.campeonato_id
		         AND ano = NEW.ano
		         AND formula_id = NEW.formula_id
		         AND clube_id = NEW.clube_id_01
		         AND fase_id = NEW.fase_id
		         AND grupo_id = NEW.grupo_id;
      --
      -- Jogos que o time mandante jogou em casa
      --
      FOR c_item IN SELECT clube_id_01, 
			   clube_id_02, 
			   gols_01, 
			   gols_02 
		      FROM jogos 
		     WHERE campeonato_id = NEW.campeonato_id
		       AND ano = NEW.ano
		       AND formula_id = NEW.formula_id
		       AND clube_id_01 = NEW.clube_id_01
		       AND fase_id = NEW.fase_id
		       AND grupo_id = NEW.grupo_id
		       AND situacaojogo = 4
      LOOP
        --
        IF (c_item.gols_01 >  c_item.gols_02) THEN
          --
          UPDATE grupoclubes SET pontos = pontos + 3,
			         jogos = jogos + 1,
			         vitorias = vitorias + 1,
			         gols_pro = gols_pro + c_item.gols_01,
			         gols_contras = gols_contras + c_item.gols_02,
			         saldo = saldo + (c_item.gols_01 - c_item.gols_02)
		           WHERE campeonato_id = NEW.campeonato_id
		             AND ano = NEW.ano
		             AND formula_id = NEW.formula_id
		             AND clube_id = NEW.clube_id_01
		             AND fase_id = NEW.fase_id
		             AND grupo_id = NEW.grupo_id;
          --
        ELSIF (c_item.gols_01 <  c_item.gols_02) THEN
          --
          UPDATE grupoclubes SET jogos = jogos + 1,
				 derrotas = derrotas + 1,
				 gols_pro = gols_pro + c_item.gols_01,
				 gols_contras = gols_contras + c_item.gols_02,
				 saldo = saldo - (c_item.gols_02 - c_item.gols_01)
		           WHERE campeonato_id = NEW.campeonato_id
		             AND ano = NEW.ano
		             AND formula_id = NEW.formula_id
		             AND clube_id = NEW.clube_id_01
		             AND fase_id = NEW.fase_id
		             AND grupo_id = NEW.grupo_id;
          --
        ELSIF (c_item.gols_01 =  c_item.gols_02) THEN
          --
          UPDATE grupoclubes SET pontos = pontos + 1,
				 jogos = jogos + 1,
				 empates = empates + 1,
				 gols_pro = gols_pro + c_item.gols_01,
				 gols_contras = gols_contras + c_item.gols_02
		           WHERE campeonato_id = NEW.campeonato_id
		             AND ano = NEW.ano
		             AND formula_id = NEW.formula_id
		             AND clube_id = NEW.clube_id_01
		             AND fase_id = NEW.fase_id
		             AND grupo_id = NEW.grupo_id;
          --
        END IF;
        --
      END LOOP;
      --
      -- Jogos que o time mandante jogou fora
      --
      FOR c_item IN SELECT clube_id_01, 
			   clube_id_02, 
			   gols_01, 
			   gols_02 
		      FROM jogos 
		     WHERE campeonato_id = NEW.campeonato_id
		       AND ano = NEW.ano
		       AND formula_id = NEW.formula_id
		       AND clube_id_02 = NEW.clube_id_01
		       AND fase_id = NEW.fase_id
		       AND grupo_id = NEW.grupo_id
		       AND situacaojogo = 4
      LOOP
        --
        IF (c_item.gols_02 >  c_item.gols_01) THEN
          --
          UPDATE grupoclubes SET pontos = pontos + 3,
				 jogos = jogos + 1,
				 vitorias = vitorias + 1,
				 gols_pro = gols_pro + c_item.gols_02,
				 gols_contras = gols_contras + c_item.gols_01,
				 saldo = saldo + (c_item.gols_02 - c_item.gols_01)
		           WHERE campeonato_id = NEW.campeonato_id
		             AND ano = NEW.ano
		             AND formula_id = NEW.formula_id
		             AND clube_id = NEW.clube_id_01
		             AND fase_id = NEW.fase_id
		            AND grupo_id = NEW.grupo_id;
          --
        ELSIF (c_item.gols_02 <  c_item.gols_01) THEN
          --
          UPDATE grupoclubes SET jogos = jogos + 1,
				 derrotas = derrotas + 1,
				 gols_pro = gols_pro + c_item.gols_02,
				 gols_contras = gols_contras + c_item.gols_01,
				 saldo = saldo - (c_item.gols_01 - c_item.gols_02)
		           WHERE campeonato_id = NEW.campeonato_id
		             AND ano = NEW.ano
		             AND formula_id = NEW.formula_id
		             AND clube_id = NEW.clube_id_01
		             AND fase_id = NEW.fase_id
		             AND grupo_id = NEW.grupo_id;
          --
        ELSIF (c_item.gols_02 =  c_item.gols_01) THEN
          --
          UPDATE grupoclubes SET pontos = pontos + 1,
				 jogos = jogos + 1,
				 empates = empates + 1,
				 gols_pro = gols_pro + c_item.gols_02,
				 gols_contras = gols_contras + c_item.gols_01
		           WHERE campeonato_id =NEW.campeonato_id
		             AND ano = NEW.ano
		             AND formula_id = NEW.formula_id
		             AND clube_id = NEW.clube_id_01
		             AND fase_id = NEW.fase_id
		             AND grupo_id = NEW.grupo_id;
          --
        END IF;
        --
      END LOOP;
      --
      -- Atualiza o aproveitamento do clube mandante
      --
      UPDATE grupoclubes SET aproveitamento = CASE WHEN jogos = 0 THEN 0 ELSE (pontos * 100 / (jogos * 3)) END
		       WHERE campeonato_id = NEW.campeonato_id
		         AND ano = NEW.ano
		         AND formula_id = NEW.formula_id
		         AND clube_id = NEW.clube_id_01
		         AND fase_id = NEW.fase_id
		         AND grupo_id = NEW.grupo_id;
      --
      --
      -- Limpa os dados do time visitante
      --
      UPDATE grupoclubes SET pontos = 0,
			     jogos = 0,
			     vitorias = 0,
			     empates = 0,
			     derrotas = 0,
			     gols_pro = 0,
			     gols_contras = 0,
			     saldo = 0,
			     aproveitamento = 0
		       WHERE campeonato_id = NEW.campeonato_id
		         AND ano = NEW.ano
		         AND formula_id = NEW.formula_id
		         AND clube_id = NEW.clube_id_02
		         AND fase_id = NEW.fase_id
		         AND grupo_id = NEW.grupo_id;
      --
      -- Jogos que o time visitante jogou em casa
      --
      FOR c_item IN SELECT clube_id_01, 
			   clube_id_02, 
			   gols_01, 
			   gols_02 
		      FROM jogos 
		     WHERE campeonato_id = NEW.campeonato_id
		       AND ano = NEW.ano
		       AND formula_id = NEW.formula_id
		       AND clube_id_01 = NEW.clube_id_02
		       AND fase_id = NEW.fase_id
		       AND grupo_id = NEW.grupo_id
		       AND situacaojogo = 4
      LOOP
        --
        IF (c_item.gols_01 >  c_item.gols_02) THEN
          --
          UPDATE grupoclubes SET pontos = pontos + 3,
				 jogos = jogos + 1,
				 vitorias = vitorias + 1,
				 gols_pro = gols_pro + c_item.gols_01,
				 gols_contras = gols_contras + c_item.gols_02,
				 saldo = saldo + (c_item.gols_01 - c_item.gols_02)
		           WHERE campeonato_id = NEW.campeonato_id
			     AND ano = NEW.ano
			     AND formula_id = NEW.formula_id
			     AND clube_id = NEW.clube_id_02
			     AND fase_id = NEW.fase_id
			     AND grupo_id = NEW.grupo_id;
          --
        ELSIF (c_item.gols_01 <  c_item.gols_02) THEN
          --
          UPDATE grupoclubes SET jogos = jogos + 1,
				 derrotas = derrotas + 1,
				 gols_pro = gols_pro + c_item.gols_01,
				 gols_contras = gols_contras + c_item.gols_02,
				 saldo = saldo - (c_item.gols_02 - c_item.gols_01)
		           WHERE campeonato_id = NEW.campeonato_id
		             AND ano = NEW.ano
		             AND formula_id = NEW.formula_id
		             AND clube_id = NEW.clube_id_02
		             AND fase_id = NEW.fase_id
		             AND grupo_id = NEW.grupo_id;
          --
        ELSIF (c_item.gols_01 =  c_item.gols_02) THEN
          --
          UPDATE grupoclubes SET pontos = pontos + 1,
				 jogos = jogos + 1,
				 empates = empates + 1,
				 gols_pro = gols_pro + c_item.gols_01,
				 gols_contras = gols_contras + c_item.gols_02
		           WHERE campeonato_id = NEW.campeonato_id
		             AND ano = NEW.ano
		             AND formula_id = NEW.formula_id
		             AND clube_id = NEW.clube_id_02
		             AND fase_id = NEW.fase_id
		             AND grupo_id = NEW.grupo_id;
          --
        END IF;
        --
      END LOOP;
      --
      -- Jogos que o time visitante jogou fora
      --
      FOR c_item IN SELECT clube_id_01, 
			   clube_id_02, 
			   gols_01, 
			   gols_02 
		      FROM jogos 
		     WHERE campeonato_id = NEW.campeonato_id
		       AND ano = NEW.ano
		       AND formula_id = NEW.formula_id
		       AND clube_id_02 = NEW.clube_id_02
		       AND fase_id = NEW.fase_id
		       AND grupo_id = NEW.grupo_id
		       AND situacaojogo = 4
      LOOP
        --
        IF (c_item.gols_02 >  c_item.gols_01) THEN
          --
          UPDATE grupoclubes SET pontos = pontos + 3,
				 jogos = jogos + 1,
				 vitorias = vitorias + 1,
				 gols_pro = gols_pro + c_item.gols_02,
				 gols_contras = gols_contras + c_item.gols_01,
				 saldo = saldo + (c_item.gols_02 - c_item.gols_01)
		           WHERE campeonato_id = NEW.campeonato_id
		             AND ano = NEW.ano
		             AND formula_id = NEW.formula_id
		             AND clube_id = NEW.clube_id_02
		             AND fase_id = NEW.fase_id
		             AND grupo_id = NEW.grupo_id;
          --
        ELSIF (c_item.gols_02 <  c_item.gols_01) THEN
          --
          UPDATE grupoclubes SET jogos = jogos + 1,
				 derrotas = derrotas + 1,
				 gols_pro = gols_pro + c_item.gols_02,
				 gols_contras = gols_contras + c_item.gols_01,
				 saldo = saldo - (c_item.gols_01 - c_item.gols_02)
		           WHERE campeonato_id = NEW.campeonato_id
		             AND ano = NEW.ano
		             AND formula_id = NEW.formula_id
		             AND clube_id = NEW.clube_id_02
		             AND fase_id = NEW.fase_id
		             AND grupo_id = NEW.grupo_id;
          --
        ELSIF (c_item.gols_02 =  c_item.gols_01) THEN
          --
          UPDATE grupoclubes SET pontos = pontos + 1,
				 jogos = jogos + 1,
				 empates = empates + 1,
				 gols_pro = gols_pro + c_item.gols_02,
				 gols_contras = gols_contras + c_item.gols_01
		           WHERE campeonato_id = NEW.campeonato_id
		             AND ano = NEW.ano
		             AND formula_id = NEW.formula_id
		             AND clube_id = NEW.clube_id_02
		             AND fase_id = NEW.fase_id
		             AND grupo_id = NEW.grupo_id;
          --
        END IF;
        --
      END LOOP;
      --
      -- Atualiza o aproveitamento do clube visitante
      --
      UPDATE grupoclubes SET aproveitamento = CASE WHEN jogos = 0 THEN 0 ELSE (pontos * 100 / (jogos * 3)) END
		       WHERE campeonato_id = NEW.campeonato_id
		         AND ano = NEW.ano
		         AND formula_id = NEW.formula_id
		         AND clube_id = NEW.clube_id_02
		         AND fase_id = NEW.fase_id
		         AND grupo_id = NEW.grupo_id;
    --
    END IF;
    --
  END IF;
  --
  RETURN OLD;
  --
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;