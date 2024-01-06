import pymysql

#DB연결
conn = pymysql.connect(host='localhost', port=3306, user='wpadmin', password='11223344', db='wpdb')
curs = conn.cursor(pymysql.cursors.DictCursor)


clear = 'drop table if exists credits_db'
curs.execute(clear)

#no = No
#credit_num = 과목번호
#credit_name = 교과목명
#prof = 담당교수
#credit = 학점
#time = 시간
#credit_cla = 이수구분
#credit_area = 영역
mk_table = 'create table if not exists credits_db (no int, credit_num text, credit_name text, prof text, credit int, time int, credit_cla text, credit_area text)'
curs.execute(mk_table)

conn.commit()

#종료
curs.close()
conn.close()
