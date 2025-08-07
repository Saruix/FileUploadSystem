<?php
include './../Model/DocumentCM.php';
class UploadCO extends DocumentCM
{
    //Defining properties
    private $documentId;
    private $documentTitle;
    private $documentDesc;
    private $documentFile;
    private $documentName;
    private $documentType;
    private $error;
    private $documentSize;
    private $tmpName;
    private $destinationDir;

    //Defining Constructor
    public function __construct($document_Id, $document_Title, $document_Desc, $document_File)
    {
        $this->documentId = $document_Id;
        $this->documentTitle = $document_Title;
        $this->documentDesc = $document_Desc;
        $this->documentFile = $document_File;
        $this->documentName = $this->documentFile['name'] ?? "";
        $this->documentType = $this->documentFile['type'] ?? "";
        $this->error = $this->documentFile['error'] ?? "";
        $this->documentSize = $this->documentFile['size'] ?? "";
        $this->tmpName = $this->documentFile['tmp_name'] ?? "";
        $this->destinationDir = "./../../Uploads/" . $this->documentName;

    }
    public function introduceDuc()
    {
        if ($this->emptyInputs() == true) {
            header("Location:./../../index.php?msg=empty_uploads");
            exit();
        }

        if ($this->isUploadOK() == false) {
            header("Location:./../../index.php?msg=upload_error");
            exit();
        }

        if ($this->isFileAlreadyExists() == true) {
            header("Location:./../../index.php?msg=file_already_exists");
            exit();
        }

        if ($this->isTypeValid() == false) {
            header("Location:./../../index.php?msg=in_valid");
            exit();
        }
        if ($this->isFileMoved() == false) {
            header("Location:./../../index.php?msg=file_is_not_moved");
            exit();
        }

        if ($this->isSizeValid() == false) {
            header("Location:./../../index.php?msg=over_size");
            exit();
        }

        $this->appendDocument(
            $this->documentTitle,
            $this->documentDesc,
            $this->documentName,
            $this->documentType,
            $this->documentSize
        );
    }
    public function eliminateDoc()
    {
        $documentFile = $this->fetchFileName($this->documentId);
        if ($this->isFileUnlinked($documentFile) == false) {
            $response = [
                'success' => false,
                'message' => 'failed-to-link'
            ];
            $responce = $this->removeDoc($this->documentId);
            return $responce;
        }

    }

    public function updateDoc()
    {
        if ($this->emptyUploads() == true) {
            header("Location:./../../file-edit.php?fid=$this->documentId&msg=empty_fields");
            exit();
        }

        $res=$this->modifyDocument(

            $this->documentId,
            $this->documentTitle,
            $this->documentDesc
        );
        return $res;
    }
    private function emptyInputs()
    {
        if (empty($this->documentTitle) || empty($this->documentDesc) || empty($this->documentFile)) {
            return true;
        } else {
            return false;
        }
    }
    private function isUploadOK()
    {
        if ($this->error > 0) {
            return false;
        } else {
            return true;
        }
    }
    private function isTypeValid()
    {
        if ($this->documentType != "application/pdf" && $this->documentType != "application/vnd.openxmlformats-officedocument.wordprocessingml.document" && $this->documentType != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" && $this->documentType != "application/vnd.ms-excel") {
            return false;
        } else {
            return true;
        }
    }
    private function isFileAlreadyExists()
    {
        if (file_exists($this->destinationDir)) {
            return true;
        } else {
            return false;
        }
    }
    private function isFileMoved()
    {
        if (move_uploaded_file($this->tmpName, $this->destinationDir)) {
            return true;
        } else {
            return false;
        }
    }
    private function isSizeValid()
    {
        if ($this->documentSize > 1000000) {
            return false;
        } else {
            return true;
        }
    }
    private function isFileUnlinked($documentFile)
    {
        if (unlink("./../../Uploads/" . $documentFile)) {
            return true;
        } else {
            return false;
        }
    }
    private function emptyUploads()
    {
        if (empty($this->documentTitle) || empty($this->documentDesc)) {
            return true;
        } else {
            return false;
        }
}

}