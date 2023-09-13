<?php
session_start();
date_default_timezone_set( 'Asia/Bangkok' );
require_once 'lib/nusoap.php';
require_once 'inc/db_connect.php';
$mysqli = connect();

 $user = $mysqli->real_escape_string($_POST[ 'user' ]);
 $pass = $mysqli->real_escape_string($_POST[ 'pass' ]);
 $status = $mysqli->real_escape_string($_POST[ 'status' ]);
 $ipaddress = $_SERVER[ 'REMOTE_ADDR' ];
//Check if form submit with capt variable
if ($_POST['submit']) {


if ( $status == 1 ) {
	// "IN";
  $client = new SoapClient( "http://regpr.msu.ac.th/webservice/WsStudentlogin.php?wsdl");
  $params = array(
    'studentcode' => $user, 'out_password' => $pass
  );
  $data = $client->__soapCall( 'Studentlogin', $params );

  $mydata = json_decode( $data, true ); // json decode from web service
  $user_count= count( $mydata );
 if($user_count>0){
    $_SESSION[ "SES_LEVEL_LER" ] = "std_ses";
    $_SESSION[ "SES_USER_LER" ] = $_POST[ 'user' ];
    echo "";
 }else{

 }


}
} else if ( $status == 2 ) {
  $client = new SoapClient( "http://regpr.msu.ac.th/webservice/WsOfficerlogin.php?wsdl");
  $params = array(
    'officercode' => $_REQUEST[ 'user' ], 'out_password' => $_REQUEST[ 'pass' ]
  );
  $data = $client->__soapCall( "Officerlogin", $params );
  //echo $data;

  $mydata = json_decode( $data, true ); // json decode from web service


  if ( count( $mydata ) == 0 ) {
    //echo "Not found data!";
    $sql_login = " select prefixname,advisorname,advisorsurname,citizenid from request_advisor  where advisorcode='$user' "; // บัณฑิตวิทยาลัย
    $rs_login = $mysqli->query( $sql_login );
    $num = $rs_login->num_rows;
    $row_login = $rs_login->fetch_array();
    if ( $num > 0 ) {

      if ( $row_login[ 'citizenid' ] == $pass ) {
        $_SESSION[ "SES_LEVEL" ] = "advisor_ses";
        $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];
        $pass = $_REQUEST[ 'pass' ];
        echo 2; // เข้าระบบได้เป็นสถานะ อาจารย์
      } else {

        echo 0;
      }

    }
  } else {
    ?>
<?php
foreach ( $mydata as $result ) {

  if ( $result[ "xpass" ] == 1 ) {
    $_SESSION[ "SES_LEVEL" ] = "advisor_ses";
    $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];

    echo 2; // เข้าระบบได้เป็นสถานะ อาจารย์
  } elseif ( $result[ "xpass" ] == 0 ) {
    //echo 0;
    $sql_login = " select prefixname,advisorname,advisorsurname,citizenid from request_advisor  where advisorcode='$user' "; // บัณฑิตวิทยาลัย
    $rs_login = $mysqli->query( $sql_login );
    $num = $rs_login->num_rows;
    $row_login = $rs_login->fetch_array();
    if ( $num > 0 ) {

      if ( $row_login[ 'citizenid' ] == $pass ) {
        $_SESSION[ "SES_LEVEL" ] = "advisor_ses";
        $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];
        $pass = $_REQUEST[ 'pass' ];
        echo 2; // เข้าระบบได้เป็นสถานะ อาจารย์
      } else {

        echo 0;
      }

    }
  }

}
}

} else if ( $status == 3 ) {

  $user = $_REQUEST[ 'user' ];
  $pass = $_REQUEST[ 'pass' ];
  $pass_en = sha1( $pass );
  $sql_login = " select staff_user,staff_pass,staff_id,staff_level from request_staff  where staff_user='$user' "; // บัณฑิตวิทยาลัย
  $rs_login = $mysqli->query( $sql_login );
  $num = $rs_login->num_rows;
  $row_login = $rs_login->fetch_array();
  $level_stas = $row_login['staff_level'];
  if ( $num > 0 ) {
    $row_login[ 'staff_pass' ] . "==" . $pass_en;

    if ( $row_login[ 'staff_pass' ] == $pass_en ) {
      //เช็คว่าถ้าเป็นพี่ปุ้ม 
      //echo "<hr>";
      if ( $user == "staff01" ) {
        $_SESSION[ "SES_LEVEL" ] = "staff_ses";
        $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];
        $_SESSION[ "SES_ID" ] = $row_login[ 'staff_id' ];
        echo 3;
      } else if ( $user == "staff02" ) {
        $_SESSION[ "SES_LEVEL" ] = "staff_ses";
        $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];
        $_SESSION[ "SES_ID" ] = $row_login[ 'staff_id' ];
        echo 11;
      } else if ( $user == "staff03" ) {
        $_SESSION[ "SES_LEVEL" ] = "staff_ses";
        $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];
        $_SESSION[ "SES_ID" ] = $row_login[ 'staff_id' ];
        echo 11;
      } else if ( $level_stas == "staffreg" ) { //กองทะเบียน
        $_SESSION[ "SES_LEVEL" ] = "staffreg";
        $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];
        $_SESSION[ "SES_ID" ] = $row_login[ 'staff_id' ];
        echo 99;//กองทะเบียน
      } else { //บุคลากรบัณฑิตวิทยาลัย
        $_SESSION[ "SES_LEVEL" ] = "person_ses";
        $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];
        $_SESSION[ "SES_ID" ] = $row_login[ 'staff_id' ];
        echo 10;
      }
    }
  }
  // เจ้าหน้าที่คณะ
  $sql_login_off = " select staff_fac_title,staff_fac_name,staff_fac_surname,staff_faculty_id,staff_ses,staff_pass from request_staff_faculty  where staff_username='$user' ";
  $rs_login_off = $mysqli->query( $sql_login_off );
  $num_off = $rs_login_off->num_rows;
  $row_login_off = $rs_login_off->fetch_array();
  if ( $num_off > 0 ) {
    if ( $row_login_off[ 'staff_pass' ] == $pass_en ) {
      $_SESSION[ "SES_LEVEL" ] = "office";
      $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];
      $_SESSION[ "SES_fAC" ] = $row_login_off[ 'staff_faculty_id' ];
      echo 20;
    } else {
      echo $row_login_off[ 'staff_pass' ] . "==" . $pass_en;
    }
  }

} else if ( $status == 4 ) {

  $user = $_REQUEST[ 'user' ];
  $pass = $_REQUEST[ 'pass' ];
  $pass_en = sha1( $pass );
  $sql_login = " select staff_id,staff_user,staff_pass from request_staff  where staff_user='$user' ";
  $rs_login = $mysqli->query( $sql_login );
  $num = $rs_login->num_rows;
  $row_login = $rs_login->fetch_array();
  if ( $num > 0 ) {
    $row_login[ 'staff_pass' ] . "==" . $pass_en;
    if ( $row_login[ 'staff_pass' ] == $pass_en ) {
      $_SESSION[ "SES_LEVEL" ] = "admin_ses";
      $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];
      $_SESSION[ "SES_STEFF_ID" ] = $row_login[ 'staff_id' ];
      echo 4;
    }
  }


}
        exit;
    }else{
        echo "<span style='color:red;'>Wrong</span>";
        $_SESSION['num_to_check'][0]=rand(1,9);
        $_SESSION['num_to_check'][1]=rand(1,9);     
        exit;   
		//echo "KKKKKK";
    }

?>

<?php /*?>
$sql_login_in = " INSERT INTO request_login (login_user,login_ip,login_date)VALUES('$user','$ipaddress',Now()) "; // บัณฑิตวิทยาลัย
$mysqli->query( $sql_login_in );

if ( $status == 1 ) {
  $client = new nusoap_client( "http://regpr.msu.ac.th/webservice/WsStudentlogin.php?wsdl", true );
  $params = array(
    'studentcode' => $_REQUEST[ 'user' ], 'out_password' => $_REQUEST[ 'pass' ]
  );
  $data = $client->call( "Studentlogin", $params );
  //echo $data;

  $mydata = json_decode( $data, true ); // json decode from web service


  if ( count( $mydata ) == 0 ) {
    //echo "Not found data!";
    $sql_login = " select std_id_crad from request_student  where std_id_std='$user' ";
    $rs_login = $mysqli->query( $sql_login );
    $row_login = $rs_login->fetch_array();
    if ( $row_login[ 'std_id_crad' ] == $pass ) {
      echo 1;

    } else {
      echo 3;
    }
  } else {
    ?>
<?php
foreach ( $mydata as $result ) {

  if ( $result[ "xpass" ] == 1 ) {
    echo 1; // เข้าระบบได้เป็นสถานะ นิสิต
  } elseif ( $result[ "xpass" ] == 0 ) {
    $sql_login = " select std_id_crad from request_student  where std_id_std='$user' ";
    $rs_login = $mysqli->query( $sql_login );
    $row_login = $rs_login->fetch_array();
    if ( $row_login[ 'std_id_crad' ] == $pass ) {
      echo 1;
    } else {
        
      echo 3; 
    }

  }

}
}
} else if ( $status == 2 ) {
  $client = new nusoap_client( "http://regpr.msu.ac.th/webservice/WsOfficerlogin.php?wsdl", true );
  $params = array(
    'officercode' => $_REQUEST[ 'user' ], 'out_password' => $_REQUEST[ 'pass' ]
  );
  $data = $client->call( "Officerlogin", $params );
  //echo $data;

  $mydata = json_decode( $data, true ); // json decode from web service


  if ( count( $mydata ) == 0 ) {
    //echo "Not found data!";
    $sql_login = " select prefixname,advisorname,advisorsurname,citizenid from request_advisor  where advisorcode='$user' "; // บัณฑิตวิทยาลัย
    $rs_login = $mysqli->query( $sql_login );
    $num = $rs_login->num_rows;
    $row_login = $rs_login->fetch_array();
    if ( $num > 0 ) {

      if ( $row_login[ 'citizenid' ] == $pass ) {
        $_SESSION[ "SES_LEVEL" ] = "advisor_ses";
        $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];
        $pass = $_REQUEST[ 'pass' ];
        echo 2; // เข้าระบบได้เป็นสถานะ อาจารย์
      } else {

        echo 0;
      }

    }
  } else {
    ?>
<?php
foreach ( $mydata as $result ) {

  if ( $result[ "xpass" ] == 1 ) {
    $_SESSION[ "SES_LEVEL" ] = "advisor_ses";
    $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];

    echo 2; // เข้าระบบได้เป็นสถานะ อาจารย์
  } elseif ( $result[ "xpass" ] == 0 ) {
    //echo 0;
    $sql_login = " select prefixname,advisorname,advisorsurname,citizenid from request_advisor  where advisorcode='$user' "; // บัณฑิตวิทยาลัย
    $rs_login = $mysqli->query( $sql_login );
    $num = $rs_login->num_rows;
    $row_login = $rs_login->fetch_array();
    if ( $num > 0 ) {

      if ( $row_login[ 'citizenid' ] == $pass ) {
        $_SESSION[ "SES_LEVEL" ] = "advisor_ses";
        $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];
        $pass = $_REQUEST[ 'pass' ];
        echo 2; // เข้าระบบได้เป็นสถานะ อาจารย์
      } else {

        echo 0;
      }

    }
  }

}
}

} else if ( $status == 3 ) {

  $user = $_REQUEST[ 'user' ];
  $pass = $_REQUEST[ 'pass' ];
  $pass_en = sha1( $pass );
  $sql_login = " select staff_user,staff_pass,staff_id from request_staff  where staff_user='$user' "; // บัณฑิตวิทยาลัย
  $rs_login = $mysqli->query( $sql_login );
  $num = $rs_login->num_rows;
  $row_login = $rs_login->fetch_array();
  if ( $num > 0 ) {
    $row_login[ 'staff_pass' ] . "==" . $pass_en;

    if ( $row_login[ 'staff_pass' ] == $pass_en ) {
      //เช็คว่าถ้าเป็นพี่ปุ้ม 
      //echo "<hr>";
      if ( $user == "staff01" ) {
        $_SESSION[ "SES_LEVEL" ] = "staff_ses";
        $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];
        $_SESSION[ "SES_ID" ] = $row_login[ 'staff_id' ];
        echo 3;
      } else if ( $user == "staff02" ) {
        $_SESSION[ "SES_LEVEL" ] = "staff_ses";
        $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];
        $_SESSION[ "SES_ID" ] = $row_login[ 'staff_id' ];
        echo 11;
      } else if ( $user == "staff03" ) {
        $_SESSION[ "SES_LEVEL" ] = "staff_ses";
        $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];
        $_SESSION[ "SES_ID" ] = $row_login[ 'staff_id' ];
        echo 11;
      } else { //บุคลากรบัณฑิตวิทยาลัย
        $_SESSION[ "SES_LEVEL" ] = "person_ses";
        $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];
        $_SESSION[ "SES_ID" ] = $row_login[ 'staff_id' ];
        echo 10;
      }
    }
  }
  // เจ้าหน้าที่คณะ
  $sql_login_off = " select staff_fac_title,staff_fac_name,staff_fac_surname,staff_faculty_id,staff_ses,staff_pass from request_staff_faculty  where staff_username='$user' ";
  $rs_login_off = $mysqli->query( $sql_login_off );
  $num_off = $rs_login_off->num_rows;
  $row_login_off = $rs_login_off->fetch_array();
  if ( $num_off > 0 ) {
    if ( $row_login_off[ 'staff_pass' ] == $pass_en ) {
      $_SESSION[ "SES_LEVEL" ] = "office";
      $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];
      $_SESSION[ "SES_fAC" ] = $row_login_off[ 'staff_faculty_id' ];
      echo 20;
    } else {
      echo $row_login_off[ 'staff_pass' ] . "==" . $pass_en;
    }
  }

} else if ( $status == 4 ) {

  $user = $_REQUEST[ 'user' ];
  $pass = $_REQUEST[ 'pass' ];
  $pass_en = sha1( $pass );
  $sql_login = " select staff_id,staff_user,staff_pass from request_staff  where staff_user='$user' ";
  $rs_login = $mysqli->query( $sql_login );
  $num = $rs_login->num_rows;
  $row_login = $rs_login->fetch_array();
  if ( $num > 0 ) {
    $row_login[ 'staff_pass' ] . "==" . $pass_en;
    if ( $row_login[ 'staff_pass' ] == $pass_en ) {
      $_SESSION[ "SES_LEVEL" ] = "admin_ses";
      $_SESSION[ "SES_USER" ] = $_REQUEST[ 'user' ];
      $_SESSION[ "SES_STEFF_ID" ] = $row_login[ 'staff_id' ];
      echo 4;
    }
  }


}<?php */?>


