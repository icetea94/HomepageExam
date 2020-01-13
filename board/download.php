<?php

    $srcName= $_GET['src_name'];   //원본파일명
    $filePath= $_GET['file_path']; //저장된 파일경로 및 파일명
    $fileSize= $_GET['file_size']; //파일 사이즈

    //저장된 파일을 사용에게 byte단위로 echo시킨다고 생각하면됨
    //byte단위로 echo시키면 그것이 다운로드 동작임

    //그러기 위해서 저장된 파일을 읽어오기
    if(  file_exists($filePath) ){

        // 파일을 바이트단위로 읽기위한 파일포인터 얻어오기
        $fp= fopen($filePath, "rb"); //2진수 모드로 읽기

        //다운로드받을 사용자에게 파일에 대한 meta메타데이터를 
        //헤더에 추가해서 보내줘야만 다운로드가 가능함
        Header("Content-Type: application/x-msdownload");
        Header("Content-Length: ".$fileSize);
        Header("Content-Disposition: attachment; filename=".$srcName); //파일첨부; filename= 은 사용자의 브라우저에 보여지는 파일명
        Header("Content-Transfer-Encoding: binary");
        Header("Content-Description: File Transfer"); //콘텐츠의 세부행동이 파일전송이다
        Header("Expires: 0");
    }

    //fpassthru() : 사용자에게 파일의 내용을 뿌려주는 함수 [ 파일포인터의 끝까지 모든 데이터를 출력해주는 함수 ]
    //즉, 파일의 데이터들을 byte단위로 echo해주는 함수라고 보면 됨
    // 파일 끝에 도달하면 false가 리턴됨, 즉 false가 오면 파일데이터 출력(다운로드)이 끝났다는 것임
    if( !fpassthru($fp) ) fclose($fp);



?>