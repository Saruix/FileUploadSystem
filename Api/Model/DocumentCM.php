<?php
include './../Config/DatabaseConfig.php';
//Defining class for database interactions
class DocumentCM extends DatabaseConfig
{
    protected function appendDocument(
        $document_title,
        $document_desc,
        $document_file,
        $document_type,
        $document_size,
    ) {
        $stashStmt = $this->integrate()->prepare('INSERT INTO `documents`(`documentTitle`, `documentDesc`, `documentFile`, `documentType`, `documentSize`) VALUES (?,?,?,?,?);');
        if (!$stashStmt->execute([$document_title, $document_desc, $document_file, $document_type, $document_size])) {
            header('Location:./../../index.php?msg=server_error');
            exit;
        }
        $stashStmt = null;
    }
    protected function removeDoc($document_id)
    {
        $remStmt = $this->integrate()->prepare('DELETE FROM `documents` WHERE `documentId`=?; ');
        if (!$remStmt->execute([$document_id])) {
            return [
                'success' => false,
                'message' => 'delete_failed'
            ];
        }
        return [
            'success' => true,
            'message' => 'deletion_success'
        ];
    }
    protected function fetchFileName($document_id)
    {
        $fetchStmt = $this->integrate()->prepare('SELECT `documentFile`FROM `documents`WHERE `documentId`=?;');
        if (!$fetchStmt->execute([$document_id])) {
            return [
                'success' => false,
                'message' => 'Fetching_error'
            ];
        }
        if ($fetchStmt->rowCount() > 0) {
            $record = $fetchStmt->fetch(PDO::FETCH_ASSOC);
            return $record['documentFile'];
        } else {
            return ['success' => false, 'message' => 'No_data_availabe'];
        }
    }

    protected function modifyDocument($document_id, $document_title, $document_desc) {
        $updateStmt = $this->integrate()->prepare('UPDATE `documents` SET `documentTitle`=?, `documentDesc`=? WHERE `documentId`=?;');
        if (!$updateStmt->execute([$document_title, $document_desc, $document_id,])) {
            return [
                'success' => false,
                'message' => 'Server_error'
            ];
        }
        return[
            'success' => true,
            'message' => 'Update_success'
        ];
    }

}