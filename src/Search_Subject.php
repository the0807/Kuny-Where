<!DOCTYPE html>
<html>
    <head>
    <style type="text/css">
            table {
                border: 0;
                border-collapse: collapse;
                border-spacing: 0;
            }
            table td, table th {
                border: 1px solid;
                padding: 2px 5px 2px 5px;
            }
            .text-center { text-align: center; }
            .text-right { text-align: right; }
        </style>
    </head>

    <body>
        <?php
            /* 변수에 서버에서 받아온 값 저장 */
            #서버에 search_word 값이 없다면 NULL, 있다면 $search_word에 값 저장
            if(empty($_REQUEST["search_word"])) {
                $search_word ="";
            }
            else{
                $search_word =$_REQUEST["search_word"];
            }

            #서버에 save_subject 값이 없다면 NULL, 있다면 $save_subject에 값 저장
            if(empty($_REQUEST["save_subject"])) {
                $save_subject ="";
            }
            else{
                $save_subject =$_REQUEST["save_subject"];
            }
        ?>
        
        <!-- 검색 입력창과 버튼 -->
        <!-- 서버에 post 방식으로 search_word 값을 전달해줌 -->
        <center>
        <form class="navbar-form pull-left" method="post" action="">
        <input type="text" name="search_word" class="form-control" placeholder="" autofocus>
        <button type="submit">검색</button>
        <br><br></form>
        </center>

        <?php
            /* DB연결 */
            $conn = mysqli_connect('localhost', 'wpadmin', '11223344', 'wpdb');
            if ( !$conn ) die('DB Error');
            
            /* 로그인한 유저 정보 */
            #내가 로그인한 유저 이름 $user에 저장
            global $current_user;
            wp_get_current_user();
            $user = $current_user->user_login;

            /* 검색어 DB에서 검색 */            
            #검색창에 입력한 값($search_word)을 credits_db 테이블에서 credit_num, credit_name, prof, credit, credit_cla, credit_area 내에서 찾기
            $sql1 = "SELECT * FROM credits_db where credit_num LIKE '%$search_word%'
            or credit_name LIKE '%$search_word%'
            or prof LIKE '%$search_word%'
            or credit LIKE '%$search_word%'
            or credit_cla LIKE '%$search_word%'
            or credit_area LIKE '%$search_word%'"; 
            #쿼리문 실행 후 $rs에 저장
            $rs = mysqli_query($conn, $sql1);
            
            /* 표 만들기 */
            echo '<table class="text-center"><tr>' .
                '<th>No</th><th>과목번호</th><th>과목명</th><th>담당교수</th>
                <th>학점</th><th>시간</th><th>이수구분</th><th>영역</th><th><center>저장하기</center></th>' .
                '</tr>';
            
            /* DB에서 검색한 정보 table로 출력 */
            #$rs에 저장된 값 배열에 저장 후 불러오기
            while($info = mysqli_fetch_array($rs))
            {
                #각 열을 하나하나 불러와서 표 만들기
                echo '<tr><td>' . $info['no'] . '</td>' .
                    '<td>' . $info['credit_num'] . '</td>' .
                    '<td>' . $info['credit_name'] . '</td>' .
                    '<td>' . $info['prof'] . '</td>' .
                    '<td>' . $info['credit'] . '</td>' .
                    '<td>' . $info['time'] . '</td>' .
                    '<td>' . $info['credit_cla'] . '</td>' .
                    '<td>' . $info['credit_area'] . '</td>';
                
                /* 저장 버튼 */
                #서버에 post 방식으로 save_subject 값을 전달해줌
                echo '<form class="navbar-form pull-left" method="post" action="">';
                echo "<td class='text-right'><center><button type='submit' name='save_subject' value='".$info['credit_num']."'>저장</button>
                </td></tr></form></center>";
            }
            echo '</table>';

            /* 교과목 저장 */
            #클릭한 버튼의 행에서 과목번호($save_subject)를 credits_db 테이블에서 찾고 credit_num, credit_name, prof, credit, time, credit_cla, credit_area 값들을 users_subject 테이블로 복사
            $sql2 = "INSERT INTO users_subject (credit_num, credit_name, prof, credit, time, credit_cla, credit_area) 
            SELECT credit_num, credit_name, prof, credit, time, credit_cla, credit_area
            FROM credits_db WHERE credit_num='$save_subject' ";

            /* 저장된 교과목에 유저 라벨링 */
            #users_subject 테이블에서 no열의 최대값을 갖는 행에서 user열을 내가 로그인한 유저 이름($user)로 변경
            #이부분 여러 사용자가 동시에 사용하게 되면 오류가 있지만 지금 건들기엔 복잡하므로 걍 패스
            $sql3 = "UPDATE users_subject SET user='$user' WHERE no=(select MAX(no) from users_subject) limit 1";
            #퀴리문 실행
            mysqli_query($conn, $sql2);
            mysqli_query($conn, $sql3);

            /* DB연결 닫기 */
            mysqli_close($conn);
        ?>
    </body>
</html>