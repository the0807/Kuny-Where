<!DOCTYPE html>
<html>
    <head>
    <style type="text/css">
            * {
                font-weight: bold;
            }
            /* progress bar CSS*/
            .softprogress *:not([code-softprogress]) {
                margin: 5px 0;
                font-size: 20px;
            }
            .softprogress {
                width: 100%;
                max-width: 100%;
                padding: 15px;
                box-sizing: border-box;
            }
            .softprogress [code-softprogress] {
                height: 40px;
                box-shadow: 0 0 1px 1px rgba(0, 20, 0, 0.35) inset;
                border-radius: 20px;
                margin: 5px 0 10px 0;
                overflow: hidden;
                background-color: #fff;
            }
            [code-softprogress]::after {
                content: "";
                display: flex;
                justify-content: flex-end;
                align-items: center;
                background: #fdaf3a;
                width: 0;
                height: 100%;
                box-sizing: border-box;
                font-size: 18px;
                color: #fff;
                border-radius: 20px;
                padding: 0 10px;
                transition: 2s;
            }
            [code-softprogress].run-softprogress::after {
                content: attr(code-softprogress) "%";
                width: var(--run-softprogress);
            }
        </style>
    </head>

    <body>
        <!-- progress bar JavaScript-->
        <script type="text/javascript">
            window.onload = function () {
            if (
                document.querySelectorAll(".softprogress").length > 0 &&
                document.querySelectorAll(".softprogress [code-softprogress]").length > 0
            ) {
                document
                .querySelectorAll(".softprogress [code-softprogress]")
                .forEach((x) => runsoftprogress(x));
            }};
            function runsoftprogress(el) {
                el.className = "run-softprogress";
                el.setAttribute(
                    "style",
                    `--run-softprogress:${el.getAttribute("code-softprogress")}%;`
            );}
        </script>

        <?php
            /* DB연결 */
            $conn = mysqli_connect('localhost', 'wpadmin', '11223344', 'wpdb');
            if ( !$conn ) die('DB Error');
            
            /* 로그인한 유저 정보 */
            #내가 로그인한 유저 이름 $user에 저장
            global $current_user;
            wp_get_current_user();
            $user = $current_user->user_login;

            /* 졸업이수학점 */
            $sql1 = "SELECT sum(credit) FROM users_subject WHERE user = '$user'";
            #쿼리문 실행 후 $rs1에 저장
            $rs1 = mysqli_query($conn, $sql1);
            #$rs1값 배열에 저장
            $info1 = mysqli_fetch_array($rs1);
            #print_r($info1);    //$rs1의 결과($info1) print
            #백분율 계산
            $sum1 = round(($info1[0] * 100) / 132, 1);
            #$sum1 값이 100 이상이 되면 100으로 저장
            if ($sum1 > 100){
                $sum1 = 100;
            }
    
            /* KU인성 */
            #내가 로그인한 유저($user)가 저장한 KU인성 과목의 갯수
            $sql2 = "SELECT sum(credit) FROM users_subject WHERE user = '$user' AND credit_cla = '인성'";
            $rs2 = mysqli_query($conn, $sql2);
            $info2 = mysqli_fetch_array($rs2);
            $sum2 = round(($info2[0] * 100) / 4, 1);
            if ($sum2 > 100){
                $sum2 = 100;
            } 
            /* 나 영역 */
            $query1 = "SELECT sum(credit) FROM users_subject WHERE user = '$user' AND credit_area = '나'";
            $a1 = mysqli_query($conn, $query1);
            $result1 = mysqli_fetch_array($a1);
            $add1 = round(($result1[0] * 100) / 2, 1);
            if ($add1 > 100){
                $add1 = 100;
            }
            /* 우리, 함께 영역 */
            $query2 = "SELECT sum(credit) FROM users_subject WHERE user = '$user' AND (credit_area = '우리' OR credit_area = '함께')";
            $a2 = mysqli_query($conn, $query2);
            $result2 = mysqli_fetch_array($a2);
            $add2 = round(($result2[0] * 100) / 2, 1);
            if ($add2 > 100){
                $add2 = 100;
            }

            /* 기초교양 */
            #내가 로그인한 유저($user)가 저장한 기초교양 과목의 갯수
            $sql3 = "SELECT sum(credit) FROM users_subject WHERE user = '$user' AND credit_cla = '기초'";
            $rs3 = mysqli_query($conn, $sql3);
            $info3 = mysqli_fetch_array($rs3);
            $sum3 = round(($info3[0] * 100) / 18, 1);
            if ($sum3 > 100){
                $sum3 = 100;
            }
            /* 의사소통 영역 */
            $query3 = "SELECT sum(credit) FROM users_subject WHERE user = '$user' AND credit_area = '의사소통'";
            $a3 = mysqli_query($conn, $query3);
            $result3 = mysqli_fetch_array($a3);
            $add3 = round(($result3[0] * 100) / 6, 1);
            if ($add3 > 100){
                $add3 = 100;
            }
            /* 인문사고 영역 */
            $query4 = "SELECT sum(credit) FROM users_subject WHERE user = '$user' AND credit_area = '인문기초'";
            $a4 = mysqli_query($conn, $query4);
            $result4 = mysqli_fetch_array($a4);
            $add4 = round(($result4[0] * 100) / 3, 1);
            if ($add4 > 100){
                $add4 = 100;
            }
            /* 과학사고 영역 */
            $query5 = "SELECT sum(credit) FROM users_subject WHERE user = '$user' AND credit_area = '과학기초'";
            $a5 = mysqli_query($conn, $query5);
            $result5 = mysqli_fetch_array($a5);
            $add5 = round(($result5[0] * 100) / 3, 1);
            if ($add5 > 100){
                $add5 = 100;
            }
            /* 국제화 영역 */
            $query6 = "SELECT sum(credit) FROM users_subject WHERE user = '$user' AND credit_area = '외국어기초'";
            $a6 = mysqli_query($conn, $query6);
            $result6 = mysqli_fetch_array($a6);
            $add6 = round(($result6[0] * 100) / 6, 1);
            if ($add6 > 100){
                $add6 = 100;
            }

            /* 심화교양 */
            #내가 로그인한 유저($user)가 저장한 심화교양 과목의 갯수
            $sql4 = "SELECT sum(credit) FROM users_subject WHERE user = '$user' AND credit_cla = '심화'";
            $rs4 = mysqli_query($conn, $sql4);
            $info4 = mysqli_fetch_array($rs4);
            $sum4 = round(($info4[0] * 100) / 8, 1);
            if ($sum4 > 100){
                $sum4 = 100;
            }

            /* KU소양 */
            #내가 로그인한 유저($user)가 저장한 KU소양 과목의 갯수
            $sql5 = "SELECT sum(credit) FROM users_subject WHERE user = '$user' AND credit_cla = '소양'";
            $rs5 = mysqli_query($conn, $sql5);
            $info5 = mysqli_fetch_array($rs5);
            $sum5 = round(($info5[0] * 100) / 6, 1);
            if ($sum5 > 100){
                $sum5 = 100;
            }
            /* 실무 영역 */
            $query7 = "SELECT sum(credit) FROM users_subject WHERE user = '$user' AND credit_area = '실무'";
            $a7 = mysqli_query($conn, $query7);
            $result7 = mysqli_fetch_array($a7);
            $add7 = round(($result7[0] * 100) / 4, 1);
            if ($add7 > 100){
                $add7 = 100;
            }
            /* 실기 영역 */
            $query8 = "SELECT sum(credit) FROM users_subject WHERE user = '$user' AND credit_area = '실기'";
            $a8 = mysqli_query($conn, $query8);
            $result8 = mysqli_fetch_array($a8);
            $add8 = round(($result8[0] * 100) / 2, 1);
            if ($add8 > 100){
                $add8 = 100;
            }
            
            /* progress bar 출력*/
            #졸업이수학점
            echo '<div class="softprogress">' . 
            '<p><strong>졸업이수학점 - ' . $info1[0] . ' / 132 학점 이상' . '</strong></p>' . 
            '<div code-softprogress="' . $sum1 . '"></div><br><br>';
            #KU인성
            echo '<p><strong>KU인성 - ' . $info2[0] . ' / 4 학점 이상' . '</strong></p>' . 
            '<div code-softprogress="' . $sum2 . '"></div>' . 
            '<p align="right"><strong>나 영역 - ' . $result1[0] . ' / 2 학점 이상' . '</strong></p>' . 
            '<div code-softprogress="' . $add1 . '"></div>' . 
            '<p align="right"><strong>우리, 함께 영역 - ' . $result2[0] . ' / 2 학점 이상' . '</strong></p>' . 
            '<div code-softprogress="' . $add2 . '"></div><br><br>';
            #기초교양
            echo '<p><strong>기초교양 - ' . $info3[0] . ' / 18 학점 이상' . '</strong></p>' . 
            '<div code-softprogress="' . $sum3 . '"></div>' . 
            '<p align="right"><strong>의사소통 영역 - ' . $result3[0] . ' / 6 학점 이상' . '</strong></p>' . 
            '<div code-softprogress="' . $add3 . '"></div>' . 
            '<p align="right"><strong>인문사고 영역 - ' . $result4[0] . ' / 3 학점 이상' . '</strong></p>' . 
            '<div code-softprogress="' . $add4 . '"></div>' . 
            '<p align="right"><strong>과학사고 영역 - ' . $result5[0] . ' / 3 학점 이상' . '</strong></p>' . 
            '<div code-softprogress="' . $add5 . '"></div>' . 
            '<p align="right"><strong>국제화 영역 - ' . $result6[0] . ' / 6 학점 이상' . '</strong></p>' . 
            '<div code-softprogress="' . $add6 . '"></div><br><br>';
            #심화교양
            echo '<p><strong>심화교양 - ' . $info4[0] . ' / 8 학점 이상' . '</strong></p>' . 
            '<div code-softprogress="' . $sum4 . '"></div><br><br>';
            #KU소양
            echo '<p><strong>KU소양 - ' . $info5[0] . ' / 6 학점 이상' . '</strong></p>' . 
            '<div code-softprogress="' . $sum5 . '"></div>' . 
            '<p align="right"><strong>실무 영역 - ' . $result7[0] . ' / 4 학점 이상' . '</strong></p>' . 
            '<div code-softprogress="' . $add7 . '"></div>' . 
            '<p align="right"><strong>실기 영역 - ' . $result8[0] . ' / 2 학점 이상' . '</strong></p>' . 
            '<div code-softprogress="' . $add8 . '"></div><br><br>' . 
            '</div>';

            /* DB연결 닫기 */
            mysqli_close($conn);
        ?>
    </body>
</html>