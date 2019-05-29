set serveroutput on;

create type varr is varray(20) of int;


CREATE OR REPLACE FUNCTION get_ex(p_id int) return varr is
     t_ex varr := varr(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
     
     p_pref int;
      -- counter si cursor pentru exercitii 
    p_cnt int := 1;
    p_id_ex int;
    p_id_muschi int;
    p_procent int;
    p_sum int := 0;
    i int := 1;
    CURSOR lucr IS select id_exercitiu, id_muschi, procent from lucreaza order by id_muschi asc, procent desc;
    CURSOR lucr_upper IS select id_exercitiu, id_muschi, procent from lucreaza where id_muschi in (1,2,3,6) order by id_muschi asc, procent desc;
    CURSOR lucr_core IS select id_exercitiu, id_muschi, procent from lucreaza where id_muschi in (4,5,7,6) order by id_muschi  asc, procent desc;
    CURSOR lucr_lower IS select id_exercitiu, id_muschi, procent from lucreaza where id_muschi in (8,9,10) order by id_muschi  asc, procent desc;
begin
    select prefer into p_pref from clienti where id = p_id;
-- in functie de ce parte a corpului vrea sa o lucreze mai mult
    if (p_pref = 0) then
      
        
         OPEN lucr;
            LOOP
                FETCH lucr INTO p_id_ex, p_id_muschi, p_procent;
                EXIT WHEN lucr%NOTFOUND;
                
                if (p_sum < 100 and p_cnt = p_id_muschi) then
                    t_ex(i) := p_id_ex;    
                  
                    i := i + 1;
                   p_sum := p_sum + p_procent;
                else 
                   p_sum := 0;
                   p_cnt := p_id_muschi + 1;
                end if;
                
                
            END LOOP;
        CLOSE lucr;  
        
    elsif (p_pref = 1) then
        
          OPEN lucr_upper;
            LOOP
                FETCH lucr_upper INTO p_id_ex, p_id_muschi, p_procent;
                EXIT WHEN lucr_upper%NOTFOUND;
                
                if (p_sum < 100 and p_cnt = p_id_muschi) then
                    t_ex(i) := p_id_ex;    
                  
                    i := i + 1;
                    p_sum := p_sum + p_procent;
                else 
                   p_sum := 0;
                    if (p_cnt = p_id_muschi) then p_cnt := p_id_muschi + 1; end if;
                end if;
                
                
            END LOOP;
        CLOSE lucr_upper;  
        
         
    elsif(p_pref = 2) then
       
           p_cnt := 4;
         OPEN lucr_core;
            LOOP
                FETCH lucr_core INTO p_id_ex, p_id_muschi, p_procent;
                EXIT WHEN lucr_core%NOTFOUND;
                
                if (p_sum < 100 and p_cnt = p_id_muschi) then
                    t_ex(i) := p_id_ex;    
                  
                    i := i + 1;
                   p_sum := p_sum + p_procent;
                   
               
                else 
                   p_sum := 0;
                   if (p_cnt = p_id_muschi) then p_cnt := p_id_muschi + 1; end if;
                end if;
                
                
            END LOOP;
        CLOSE lucr_core;  
         
    else
      
          p_cnt := 8;
          p_sum := 0;
          OPEN lucr_lower;
            LOOP
                FETCH lucr_lower INTO p_id_ex, p_id_muschi, p_procent;
                EXIT WHEN lucr_lower%NOTFOUND;
                
                if(p_cnt < p_id_muschi) then p_cnt := p_id_muschi; p_sum := 0; end if;
            
                if (p_sum < 100 and p_cnt = p_id_muschi) then
                    t_ex(i) := p_id_ex;    
                 
                    i := i + 1;
                   p_sum := p_sum + p_procent;
                  
                   if(p_sum > 100) then p_cnt := p_id_muschi + 1; end if;
                
                end if;
                
                
            END LOOP;
        CLOSE lucr_lower;  
    
    end if;
    return t_ex;
end;


CREATE OR REPLACE PROCEDURE get_training (p_id IN clienti.id%type, p_res out varchar2)
AS

    ret varchar2(32760) := ' ';
    nume_ex varchar2(50);
    -- aici o sa fie puse exercitiile pe care le face
    t_ex varr;
    --exercitii(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
    p_proc varr := varr(95,90,88,86,83,80,78,76,75,72,70);
    
    -- date client
    p_inalt  clienti.inaltime%type;
    p_greutate  clienti.greutate%type; 
    p_exp  clienti.experienta%type;
    p_sex  clienti.sex%type;
    p_activ  clienti.nivel_activ%type;
    p_rm  int;
    p_pref  clienti.prefer%type;
    v_varsta int;
    
    -- variabile
    p_gr int;
    p_rep int;
    p_set int;
    p_aux int;
    pr int;
    
BEGIN 
    select inaltime, greutate, experienta, sex, nivel_activ, prefer INTO p_inalt, p_greutate, p_exp, p_sex, p_activ, p_pref from clienti where id = p_id;  
    select months_between(trunc(sysdate), data_nastere)/12 into v_varsta from clienti where id = p_id; -- aflu varsta
   
    t_ex := get_ex(p_id);
    DBMS_OUTPUT.PUT_LINE(p_exp);
    if(p_exp = 1) then
        pr := 10;
    elsif(p_exp = 2) then
        pr := 8;
    elsif(p_exp = 3) then
        pr := 6;
    elsif(p_exp = 4) then
        pr:= 4;
    elsif(p_exp = 5) then
        pr := 3;
    end if;
    -- daca nu are exp mai multe repetitii greutate mai putina
        for i in 1..t_ex.count loop
            begin
            select rpm into p_rm from oneRPM where id_client = p_id and id_exercitiu = t_ex(i);
            EXCEPTION WHEN NO_DATA_FOUND
                then null;
                if(i = 1) then
                    DBMS_OUTPUT.PUT_LINE('Acest client nu si-a inregistrat 1RP max');
                end if;
                exit;
            end;
            --DBMS_OUTPUT.PUT_LINE(t_ex(i) || ' '  || p_rm);
            p_gr:= p_proc(pr)*p_rm/100 - 10;
            if(p_gr < 0 ) then p_gr := 0; end if;
            p_rep := pr;
            p_aux := p_gr * p_rep;
            p_set := 1;
            while( p_aux < 15*p_gr ) loop
                p_set := p_set + 1;
                p_aux := p_aux + p_gr * p_rep;
            end loop;
            select nume into nume_ex from exercitii where id = t_ex(i);
            ret := ret || nume_ex || ' -- '|| p_set || ' seturi, ' || p_rep || ' repetitii cu ' || p_gr || ' de kg<br>';
            
            
            
        end loop;
       -- DBMS_OUTPUT.PUT_LINE(ret);


        p_res := ret || '<br>';
               EXCEPTION when no_data_found then
        p_res := 'No data found';
END;
    
    
DECLARE
testt varchar2(32760);
BEGIN

    get_training(2000000, testt);
    
    DBMS_OUTPUT.PUT_LINE('test:' || testt);
    
end;

create or  replace procedure show_statistic(p_id int, p_res out varchar2) as
     -- date client
    p_inalt  clienti.inaltime%type;
    p_greutate  clienti.greutate%type; 
    p_exp  clienti.experienta%type;
    p_sex  clienti.sex%type;
    p_activ  clienti.nivel_activ%type;
    p_rm  int;
    p_pref  clienti.prefer%type;
    v_varsta int;
    
    p_id_asem int;

    -- date antrenament
    avg_greutate int := 0;
    avg_seturi int:= 0;
    avg_repetitii int:= 0;
    avg_ex int:= 0;
    
    avg_ex_char varchar2(50);
    
    
     t_ex varr := get_ex(p_id);
     
     res varchar2(32760) := ' ';
    
    cursor cli_asem is select id from clienti where greutate between p_greutate - 5 and p_greutate + 5 and experienta = p_exp and sex = p_sex and months_between(trunc(sysdate), data_nastere)/12 between v_varsta - 3 and v_varsta + 3 and inaltime
        between p_inalt - 5 and p_inalt + 5; 
    
    cursor antr_data is select id_exercitiu, avg(greutate), avg(seturi), avg(repetitii) from antrenament where id_client in
    (select id from clienti where greutate between p_greutate - 5 and p_greutate + 5 and experienta = p_exp and sex = p_sex and months_between(trunc(sysdate), data_nastere)/12 between v_varsta - 3 and v_varsta + 3 and inaltime
        between p_inalt - 5 and p_inalt + 5)
     and id_exercitiu in (select * from table(t_ex)) group by id_exercitiu ;
    
   
   
begin
      select inaltime, greutate, experienta, sex, nivel_activ, prefer INTO p_inalt, p_greutate, p_exp, p_sex, p_activ, p_pref from clienti where id = p_id;
      select months_between(trunc(sysdate), data_nastere)/12 into v_varsta from clienti where id = p_id; -- aflu varsta
      OPEN antr_data;
            LOOP
                FETCH antr_data INTO avg_ex, avg_greutate, avg_seturi, avg_repetitii;
                EXIT WHEN antr_data%NOTFOUND;
                select nume into avg_ex_char from exercitii where avg_ex = id; 
                res := res || avg_ex_char || ' -- greutatea medie: ' || avg_greutate || ', numarul mediu de seturi: ' || avg_seturi || ', numarul mediu de repetitii: ' || avg_repetitii || '<br>';
                
            END LOOP;
        CLOSE antr_data;  
        p_res := res || '<br>';
          EXCEPTION when no_data_found then
        p_res := 'No data found';
        --get_training(p_id);
end;

CREATE OR REPLACE TRIGGER fr
   before INSERT OR DELETE ON antrenament
   FOR EACH ROW
BEGIN
  CASE   
     WHEN INSERTING THEN update clienti set frecventa = frecventa + 1 where id = :new.id_client; 
     WHEN DELETING THEN update clienti set frecventa = frecventa - 1 where id = :old.id_client;
    
  END CASE;
END;

DECLARE
r varchar2(32760);
BEGIN
    show_statistic(2000000, r);
   DBMS_OUTPUT.PUT_LINE('test:' || r);
end;




delete from oneRPM where id_client = 4;