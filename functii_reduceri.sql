set serveroutput on;
   CREATE OR REPLACE FUNCTION reduceri (v_id int) RETURN  int AS
    v_frecventa int;
    v_tip int;
    BEGIN
      select frecventa into v_frecventa from clienti where id=v_id;
      --select tip into v_tip from abonamente a join abonati ab on a.id = ab.id_abonament join clienti c on c.id=ab.id_client where c.id=v_id;
      select id_abonament into v_tip from abonati where id_client = v_id;
      select tip into v_tip from abonamente where id = v_tip;
      
      IF (v_frecventa>90 and v_tip=1) THEN
      RETURN 100;
      END IF;
      IF (v_frecventa>90 and v_tip=2) THEN
      RETURN 200;
      END IF;
      IF (v_frecventa>90 and v_tip=3) THEN
      RETURN 300;
      END IF;
       
       RETURN 0;
    END reduceri;   
    /

    CREATE OR REPLACE function frecventa_la_sala (v_id  int) return varchar2 IS
    v_frecventa int;
    BEGIN
      select frecventa into v_frecventa from clienti where id_client=v_id;
      v_frecventa:= v_frecventa +1;
      update clienti set frecventa=v_frecventa where id_client=v_id;
    END frecventa_la_sala;
    /
    
     CREATE OR REPLACE FUNCTION bmi (v_id int) RETURN  VARCHAR2 AS
    v_greutate float;
    v_inaltime float;
    v_bmi float;
    BEGIN
      select greutate into v_greutate from clienti where id=v_id;
      select inaltime into v_inaltime from clienti where id=v_id;
      v_inaltime := v_inaltime / 100;
      v_bmi:= v_greutate/(v_inaltime*v_inaltime);
       
      IF ( v_bmi<=16) THEN
      RETURN 'severely underweight';
      END IF;
      IF (v_bmi>16 and v_bmi<=18) THEN
      RETURN 'underweight';
      END IF;
      IF (v_bmi>18 and v_bmi<=25) THEN
      RETURN 'normal';
      END IF;
      IF (v_bmi>25 and v_bmi<=30) THEN
      RETURN 'moderately obese';
      END IF;
      IF (v_bmi>30 ) THEN
      RETURN 'severely obese';
      END IF;
       RETURN 'no bmi';
    END bmi;
    /
    DECLARE
    t int;
    BEGIN
        select id into t from clienti where client_top(id) = 1;  
          DBMS_OUTPUT.PUT_LINE(t);
    END;
 
    -- true=1, false=0
    CREATE OR REPLACE FUNCTION promotii (v_id int) RETURN  int AS
        v_experienta int;
        v_valid VARCHAR2(100);
    BEGIN
      select experienta into v_experienta from clienti where id=v_id;
      v_valid:= bmi(v_id);
      IF (v_experienta=5 and v_valid='normal') THEN
      RETURN 1;
      END IF;
       RETURN 0;
    END promotii; 
    /
    
      --1 da, 0 nu
  CREATE OR REPLACE FUNCTION client_top (v_id int) RETURN  int AS
    v_frecventa int;
    v_tip int;
    BEGIN
      select frecventa into v_frecventa from clienti where id=v_id;
     -- select tip into v_tip from abonamente a join abonati ab on a.id_abonament=ab.id_abonament join clienti c on c.id=ab.id_client where c.id_client=v_id;
      select id_abonament into v_tip from abonati where id_client = v_id;
      select tip into v_tip from abonamente where id = v_tip;
      
      IF (v_frecventa>365 and v_tip=3) THEN
      RETURN 1;
      END IF;
       RETURN 0;
    END client_top; 

UPDATE CLIENTI SET EMAIL = 'alexandra@b.ro' where id = 4;

DECLARE
p1 int;
p2 varchar(100) := 'alexandra@b.ro';
BEGIN 
select id into p1 from clienti where p2 = email;
EXCEPTION when no_data_found 
THEN p1 := null;
 
DBMS_OUTPUT.PUT_LINE('test:' || p1);
end;