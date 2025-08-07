<?php
include './Api/Config/DatabaseConfig.php';
class Documents extends DatabaseConfig
{
    public function fetchDocuments()
    {
        $fetchstmt = $this->integrate()->prepare('SELECT * FROM `documents` ORDER BY `documentAddedDate` DESC;');
        if (!$fetchstmt->execute()) {
            return [
                'success' => false,
                'message' => "Server Error"

            ];
        }
        if ($fetchstmt->rowCount() > 0) {
            while ($record = $fetchstmt->fetch(PDO::FETCH_ASSOC)) {
                echo '
                <div class="document-card">
                        <div class="document-icon">';

                if ($record['documentType'] == "application/pdf") {
                    echo '<img src="./Assets/Imgs/icons/pdf.png">';
                } else if ($record['documentType'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                    echo '<img src="./Assets/Imgs/icons/word.png">';
                } else if ($record['documentType'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
                    echo '<img src="./Assets/Imgs/icons/xl.png">';
                } else if ($record['documentType'] == "application/vnd.ms-excel") {
                    echo '<img src="./Assets/Imgs/icons/xls.png">';
                }
                echo '
                        </div>
                        <div class="document-info">
                            <p><b>' . $record['documentTitle'] . '</b></p>
                            <p><b>' . $record['documentDesc'] . '</b></p>
                            <p><b>' . $record['documentFile'] . '</b></p>
                            <p><b>' . $record['documentSize'] . '</b></p>
                        </div>
                        <div class="card-buttons">
                            <button><a href="./file-edit.php?fid='.$record['documentId'].'">Edit</a></button>
                            <button><a href="./Api/Hook/UploadHK.php?fid='.$record['documentId'].'">Delete</a></button>
                            <button><a href="./Uploads/'.$record['documentFile'].'"download>Download</a></button>
                        </div>
                        </div>
                ';
            }

        } else {
            echo "<p align='Center'>No Documents Available</p>";

        }
    }
}