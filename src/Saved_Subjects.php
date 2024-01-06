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
            #서버에 delete_subjectd 값이 없다면 NULL, 있다면 $delete_subject에 받아온 값 저장
            if(empty($_REQUEST["delete_subject"])) {
                $delete_subject ="";
            }
            else{
                $delete_subject =$_REQUEST["delete_subject"];
            }

            /* DB연결 */
            $conn = mysqli_connect('localhost', 'wpadmin', '11223344', 'wpdb');
            if ( !$conn ) die('DB Error');

            /* 로그인한 유저 정보 */
            #내가 로그인한 유저 이름 $user에 저장
            global $current_user;
            wp_get_current_user();
            $user = $current_user->user_login;

            /* 저장된 교과목 DB에서 가져오기 */
            #users_subject 테이블에서 user열 중 내가 로그인한 유저($user)가 해당하는 행 가져오기
            $sql1 = "SELECT * FROM users_subject WHERE user='$user'";
            #쿼리문 실행 후 $rs에 저장
            $rs = mysqli_query($conn, $sql1);
            
            /* 표 만들기 */
            echo '<center>*삭제 버튼 클릭 시 페이지를 새로고침 하세요.</center>' . 
                '<table class="text-center"><tr>' .
                '<th>과목번호</th><th>과목명</th><th>담당교수</th>
                <th>학점</th><th>시간</th><th>이수구분</th><th>영역</th><th><center>삭제하기</center></th>' .
                '</tr>';
            
            /* 저장된 교과목 table로 출력 */
            #$rs에 저장된 값 배열에 저장 후 불러오기
            while($info = mysqli_fetch_array($rs))
            {
                #각 열을 하나하나 불러와서 표 만들기
                echo '<tr><td>' . $info['credit_num'] . '</td>' .
                    '<td>' . $info['credit_name'] . '</td>' .
                    '<td>' . $info['prof'] . '</td>' .
                    '<td>' . $info['credit'] . '</td>' .
                    '<td>' . $info['time'] . '</td>' .
                    '<td>' . $info['credit_cla'] . '</td>' .
                    '<td>' . $info['credit_area'] . '</td>';
                
                /* 삭제 버튼 */
                #서버에 post 방식으로 delete_subject 값을 전달해줌
                echo '<form class="navbar-form pull-left" method="post" action="">';
                echo "<td class='text-right'><center><button type='submit' name='delete_subject' value='".$info['credit_num']."'>삭제</button>
                </td></tr></form></center>";
            }
            echo '</table>';

            /* 교과목 삭제 */
            #users_subject 테이블에서 클릭한 버튼의 과목번호($delete_subject)와 내가 로그인한 유저 이름($user)이 있는 행 삭제
            $sql2 = "DELETE FROM users_subject WHERE user='$user' AND credit_num = '$delete_subject'";
            #퀴리문 실행
            mysqli_query($conn, $sql2);

            /* auto_increment 1부터 재정렬 */
            $sql3 = "SET @count=0;";
            $sql4 = "UPDATE users_subject SET no = @count:=@count+1;";
            #퀴리문 실행
            mysqli_query($conn, $sql3);
            mysqli_query($conn, $sql4);

            /* DB연결 닫기 */
            mysqli_close($conn);
        ?>
    </body>
</html>