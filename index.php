<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./Assets/Css/app.css">
</head>

<body>
    <div class="wrapper">
        <div class="form-controller">
            <form action="./Api/Hook/UploadHK.php" method="post" enctype="multipart/form-data">
                <div class="form-header">
                    <h2>upload Document</h2>

                </div>
                <div class="from-control">
                    <input type="text" name="document_title" placeholder="Document Title">
                </div>
                <div class="from-control">
                    <input type="text" name="document_desc" placeholder="Document Desc">
                </div>
                <div class="from-control">
                    <input type="file" name="document_file">
                </div>
                <div class="from-control">
                    <input type="submit" value="upload" name="Upload">
                </div>
            </form>

            <div class="documents-container">
                <div class="documents-header">
                    <h2>Document Gallery</h2>
                </div>
                <div class="documents">

                    <?php
                        include './Api/View/Documents.php';
                        $documents = new Documents();
                        $documents->fetchDocuments();
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>