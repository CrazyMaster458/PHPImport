<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class="container" data-new-gr-c-s-check-loaded="14.1026.0" data-gr-ext-installed>
    <?php 
    $name = "";

    if($_FILES){
        $targetDir = "../uploads/";
        $targetFIle = $targetDir . basename($_FILES['uploadedFile']['name']);
        $fileType = strtolower(pathinfo($targetFIle, PATHINFO_EXTENSION));
        $fileType2 = $_FILES['uploadedFile']['type'];

        $uploadSuccess = true;

        //kontrola erroru
        if($_FILES['uploadedFile']['error'] != 0){
            echo "Chyba serveru";
            $uploadSuccess = false;
        }

        //kontrola existence
        else if(file_exists($targetFIle)){
            echo "Soubor už existuje";
            $uploadSuccess = false;
        }

        //Kontrola velikosti
        else if($_FILES['uploadedFile']['size'] > 8000000){
            echo "Soubor je moc veký";
            $uploadSuccess = false;
        }

        //kontrola typu
        elseif(explode("/", $fileType2)[0] !== "image" && explode("/", $fileType2)[0] !== "video" && explode("/", $fileType2)[0] !== "audio"){
            echo "Soubor má špatný typ";
            $uploadSuccess = false;
        }


        //přesun souboru
        if(!$uploadSuccess){
            echo "Došlo k chybě";
        }
        else{
            if(move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $targetFIle)){
                echo "Success soubor byl ulozen";
                $name = $_FILES['uploadedFile']['name'];
            }
            else{
                echo "Došlo k chybě";
            }
        }
    }
    ?>
    <img src="C:\wamp64\www\IP3\05_Upload\uploads\progress.png" alt="">
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">  
            <label for="formFile" class="form-label">Select image to upload:</label>
            <input class="form-control" type="file" name="uploadedFile" id="formFile"/>
        </div>
        <input type="submit" class="btn btn-primary" value="Nahrát" name="submit"/>
    </form>
    <?php
        if($uploadSuccess){
            switch(explode("/", $fileType2)[0]){
                case "image":
                    echo "<img src='../uploads/$name' alt=''>";
                    break;
                case "video":
                    echo "<video controls autoplay src='../uploads/$name'></video>";
                    break;
                case "audio":
                    echo "<audio controls autoplay src='../uploads/$name'></audio>";
                    break;
                default:
                break;
    
            }
        }
    ?>
</body>
</html>