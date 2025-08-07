<?php
include("./../Controller/UploadCO.php");

if (!isset($_POST["Upload"]) && !isset($_GET['fid']) && !isset($_POST['updateDoc'])) {
    exit(json_encode(['success' => false, 'message' => "Invalid Request"]));
} else if (isset($_POST["Upload"])) {
    //print_r($_POST);
    $Title = $_POST["document_title"];
    $Duc_desc = $_POST["document_desc"];
    $Duc_file = $_FILES["document_file"];

    // echo "Document Title :$Title ";
    // echo "Document Desc $Duc_desc ";
    // print_r($Duc_file);

    $AddDuc = new UploadCO(null, $Title, $Duc_desc, $Duc_file);
    $AddDuc->introduceDuc();
    header("Location: ./../../index.php?msg=upload_success");

} else if (isset($_GET["fid"])) {
    $document_id = $_GET["fid"];
    $deleteDoc = new UploadCO(
        $document_id,
        null,
        null,
        null
    );
    $res = $deleteDoc->eliminateDoc();
    header("Location:./../../index.php?msg=" . $res['message']);
}else if (isset($_POST['updateDoc'])){
    $document_id=$_POST['documentId'];
    $document_title=$_POST['document_title'];
    $document_desc=$_POST['document_desc'];

    $update = new UploadCO($document_id,
        $document_title,
        $document_desc,
        ""
);
        
    $res=$update->updateDoc();
       if ($res['success'] == false) {
        header('Location: ./../../file-edit.php?msg='.$res['message']);
    }else {
        header('Location: ./../../index.php?msg='.$res['message']);
    }
       
    
}