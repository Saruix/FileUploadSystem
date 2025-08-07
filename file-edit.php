<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if (!isset($_GET['fid'])) {

    } else {
        $document_id = $_GET['fid'];

        include './Api/View/Document.php';
        $document = new Document();
        $documentData = $document->fetchDocument($document_id);
        print_r($documentData);
    }
    ?>
    <div class="wrapper">
        <div class="form-controller">
            <form action="./Api/Hook/UploadHK.php" method="post" enctype="multipart/form-data">
                <input type="hidden" value="<?php echo $document_id; ?>" name="documentId">
                <div class="form-header">
                    <h2>upload Document</h2>

                </div>
                <div class="from-control">
                    <input type="text" name="document_title" value="<?php echo $documentData['documentTitle']; ?>">
                </div>
                <div class="from-control">
                    <input type="text" name="document_desc" value="<?php echo $documentData['documentDesc']; ?>">
                </div>
                <input type="submit" name="updateDoc" value="update Document">
            </form>
        </div>
    </div>
</body>

</html>