<?php

    session_name("userid_login");
    session_start();

    if(!isset($_SESSION["user_id"])) {
        header("Location: /admin/login/");
    }

?>
<!DOCTYPE html>
<html lang="de-DE" prefix="og: https://ogp.me/ns#" xmlns:og="http://opengraphprotocol.org/schema/">
    <head>
        <?php

            $root = realpath($_SERVER["DOCUMENT_ROOT"]);

            include_once "$root/admin/sites/head.html";

        ?>
        <title>Lehrer bearbeiten - Admin Panel - Friedrich-Gymnasium Luckenwalde</title>
    </head>
    <body>
        <div class="bodyDiv">
        <?php

            include_once "$root/admin/sites/header.html";

            include_once "$root/admin/sites/permissions.php";

            include_once "$root/admin/no-permission.html";
        ?>

        <?php

        require_once "$root/sites/credentials.php";
        $conn = get_connection();

        $sql = "SELECT * FROM lehrer WHERE id = " . $_GET['id'] . ";";
        $result = mysqli_query($conn,$sql);
        $myArray = array();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $faecher = explode(";", $row["faecher"]);
            $date = $row["datum"];
            $vorname = $row["vorname"];
            $nachname = $row["nachname"];
            $position = $row["position"];
            $email = $row["email"];
            $infotext = $row["beschreibung"];
        }

        if($lehrer_own == 1 && $_SESSION["vorname"] == $vorname && $_SESSION["nachname"] == $nachname){
            $ownedit = true;
            $disabled = false;
        }elseif($lehrer_all == 0){
            echo("<script>$('.no_perm').show();</script>");
            $disabled = true;
        };

        ?>
        <div class="page-beginning"></div>

        <div class="add-input">
            <form method="POST" enctype="multipart/form-data">
                <input id="first" type="text" width="" placeholder="Vorname*" name="vorname" value="<?php echo $vorname; ?>"  <?php if($disabled or $ownedit){echo("disabled");} ?> required><br>
                <input type="text" placeholder="Nachname*" name="nachname" value="<?php echo $nachname; ?>" <?php if($disabled or $ownedit){echo("disabled");} ?> required><br>
                <input type="email" placeholder="Email*" name="email" value="<?php echo $email; ?>" <?php if($disabled or $ownedit){echo("disabled");} ?> required><br>
                <div class="position">
                    <label class="heading2">Position</label>
                    <ul>
                        <li><label><input type="radio" name="position" value="Lehrer*in" <?php if ($position == 'Lehrer*in') echo "checked"; ?> <?php if($disabled or $ownedit){echo("disabled");} ?>>Lehrer*in</label></li>
                        <li><label><input type="radio" name="position" value="Referendar*in" <?php if ($position == 'Referendar*in') echo "checked"; ?> <?php if($disabled or $ownedit){echo("disabled");} ?>>Referendar*in</label></li>
                        <li><label><input type="radio" name="position" value="Schulleiter*in" <?php if ($position == 'Schulleiter*in') echo "checked"; ?> <?php if($disabled or $ownedit){echo("disabled");} ?>>Schulleiter*in</label></li>
                        <li><label><input type="radio" name="position" value="stellvertretender Schulleiter*in" <?php if ($position == 'stellvertretender Schulleiter*in') echo "checked"; ?> <?php if($disabled or $ownedit){echo("disabled");} ?>>stellvertretender Schulleiter*in</label></li>
                        <li><label><input type="radio" name="position" value="Oberstufenkoordinator*in" <?php if ($position == 'Oberstufenkoordinator*in') echo "checked"; ?> <?php if($disabled or $ownedit){echo("disabled");} ?>>Oberstufenkooridnator*in</label></li>
                        <li><label><input type="radio" name="position" value="Sekretär*in" <?php if ($position == 'Sekretär*in') echo "checked"; ?> <?php if($disabled or $ownedit){echo("disabled");} ?>>Sekretär*in</label></li>
                        <br>
                    </ul>
                    <br>
                </div>
                <div class="faecher">
                <label class="heading2">Fächer</label>
                    <ul>
                        <ul>
                            <label class="heading">Sprachwissenschaften</label>
                            <li><label><input type="checkbox" name="chk_group[]" value="DE" <?php foreach ($faecher as $fach) if ($fach == "DE") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Deutsch</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="EN" <?php foreach ($faecher as $fach) if ($fach == "EN") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Englisch</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="FR" <?php foreach ($faecher as $fach) if ($fach == "FR") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Französisch</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="PO" <?php foreach ($faecher as $fach) if ($fach == "PO") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Polnisch</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="RU" <?php foreach ($faecher as $fach) if ($fach == "RU") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Russisch</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="SN" <?php foreach ($faecher as $fach) if ($fach == "SN") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Spanisch</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="TR" <?php foreach ($faecher as $fach) if ($fach == "TR") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Türkisch</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="LA" <?php foreach ($faecher as $fach) if ($fach == "LA") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Latein</label></li>
                        </ul>
                        <ul>
                            <label class="heading">Naturwissenschaften</label>
                            <li><label><input type="checkbox" name="chk_group[]" value="MA" <?php foreach ($faecher as $fach) if ($fach == "MA") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Mathematik</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="BI" <?php foreach ($faecher as $fach) if ($fach == "BI") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Biologie</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="CH" <?php foreach ($faecher as $fach) if ($fach == "CH") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Chemie</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="PH" <?php foreach ($faecher as $fach) if ($fach == "PH") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Physik</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="IF" <?php foreach ($faecher as $fach) if ($fach == "IF") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Informatik</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="NW" <?php foreach ($faecher as $fach) if ($fach == "NW") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Naturwissenschaften</label></li>
                        </ul>
                        <ul>
                            <label class="heading">Gesellschaftswissenschaften</label>
                            <li><label><input type="checkbox" name="chk_group[]" value="EK" <?php foreach ($faecher as $fach) if ($fach == "EK") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Erdkunde</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="GE" <?php foreach ($faecher as $fach) if ($fach == "GE") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Geschichte</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="PB" <?php foreach ($faecher as $fach) if ($fach == "PB") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Politische Bildung</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="EG" <?php foreach ($faecher as $fach) if ($fach == "EG") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Gesellschaftswissenschaften</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="RE" <?php foreach ($faecher as $fach) if ($fach == "RE") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Evangelischer Religionsunterricht</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="RK" <?php foreach ($faecher as $fach) if ($fach == "RK") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Katholischer Religionsunterricht</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="LE" <?php foreach ($faecher as $fach) if ($fach == "LE") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Lebensgestaltung-Ethik-Religionskunde</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="AL" <?php foreach ($faecher as $fach) if ($fach == "AL") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Wirtschaft-Arbeit-Technik</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="WW" <?php foreach ($faecher as $fach) if ($fach == "WW") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Wirtschaftswissenschaften</label></li>
                        </ul>
                        <ul>
                            <label class="heading">Künstlerische Fächer</label>
                            <li><label><input type="checkbox" name="chk_group[]" value="DS" <?php foreach ($faecher as $fach) if ($fach == "DS") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Darstellendes Spiel</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="KU" <?php foreach ($faecher as $fach) if ($fach == "KU") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Kunst</label></li>
                            <li><label><input type="checkbox" name="chk_group[]" value="MU" <?php foreach ($faecher as $fach) if ($fach == "MU") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Musik</label></li>
                        </ul>
                        <ul>
                            <label class="heading">Sonstige</label>
                            <li><label><input type="checkbox" name="chk_group[]" value="SP" <?php foreach ($faecher as $fach) if ($fach == "SP") echo "checked" ; ?> <?php if($disabled){echo "disabled";} ?>>Sport</label></li>
                        </ul>
                    </ul>
                </div>
                <textarea rows="10" columns="50%" placeholder="Infotext (Optional)" name="beschreibung" <?php if($disabled){echo "disabled";} ?>><?php echo $infotext; ?></textarea><br>
                <input type="date" placeholder="Geburtstag (Optional)" name="geburtstag" value="<?php echo $date; ?>" Optional <?php if($disabled){echo "disabled";} ?>><br>
                <input type="file" name="pictureUpload" id="pictureUpload" accept=".jpg,.jpeg,.png"/>
                    <label for="pictureUpload" id="file">Bild auswählen...</label><br>
                    <div id="preview">
                        <?php
                            $file_exists = false;
                            $phppath = "$root/files/site-ressources/lehrer-bilder/" . strtolower(str_replace(" ","_",$vorname)."_".str_replace(" ","_",$nachname)).".";
                            $imgpath = "/files/site-ressources/lehrer-bilder/" . strtolower(str_replace(" ","_",$vorname)."_".str_replace(" ","_",$nachname)).".";
                            if (file_exists($phppath."jpg")) {
                                $imgpath = $imgpath."jpg";
                                $file_exists = true;
                            }elseif (file_exists($phpath."jpeg")) {
                                $imgpath = $imgpath."jpeg";
                                $file_exists = true;
                            }elseif (file_exists($phppath."png")) {
                                $imgpath = $imgpath."png";
                                $file_exists = true;
                            }
                            if($file_exists){echo('<img src="'.$imgpath.'" width="300" height="auto"/>');}
                        ?>
                        <input type="hidden" id="deletefile" name="deletefile" value="" />
                    </div><br>
                    <div id="invalidfiletype" style="display:none"><p>Nur .jpg, .jpeg und .png Dateien sind erlaubt!</p></div><br>
                    <div id="previewbuttons" style="display: none">
                        <label for="pictureUpload" id="changepic">Bild ersetzen</label>
                        <label id="rmpic" onclick="rmimage();">Bild entfernen</label>
                    </div>
                    <?php if($file_exists){echo("<script>document.getElementById('previewbuttons').style.display = '';</script>");} ?>
                <input style="cursor: pointer;" type="submit" name="submit" <?php if($disabled){echo "disabled";} ?> value="Speichern">
                <div class="page-ending"></div>
            </form>
        </div>

        <div style='left: 0;' class='confirm'>
            <span class='helper'></span>
            <div class='scroll'>
                <div class='confirmation'>
                    <h1>Änderungen erfolgreich!</h1><br>
                    <p>Der Lehrer wurde erfolgreich aktualisiert.</p><br>
                    <a href='/admin/lehrer/' class='back'>Zurück zur Übersicht</a>
                </div>
            </div>
        </div>

        <script>
                function imagePreview(fileInput) {
                    if (fileInput.files && fileInput.files[0]) {
                        var filebutton = document.getElementById('file');
                        filebutton.innerHTML = "Bild ausgewählt!";
                        document.getElementById('deletefile').value = 'false';
                        filebutton.style.cursor = "default";
                        filebutton.htmlFor = "";
                        var fileReader = new FileReader();
                        fileReader.onload = function (event) {
                            $('#preview').html('<img src="'+event.target.result+'" width="300" height="auto"/>');
                        };
                        document.getElementById('previewbuttons').style.display = "";
                        fileReader.readAsDataURL(fileInput.files[0]);
                        var fileName = fileInput.value; //Check of Extension
                        var extension = fileName.substring(fileName.lastIndexOf('.') + 1);
                        if ((extension == "jpg" || extension == "jpeg" || extension == "png")){
                            document.getElementById('invalidfiletype').style.display = "none";
                            document.getElementById('preview').style.display = "";
                        }else{
                            document.getElementById('invalidfiletype').style.display = "";
                            document.getElementById('preview').style.display = "none";
                        }
                    }
                };
                function rmimage() { // TODO: Delete Picture button not removing picture from server and fix img replacing
                    var filebutton = document.getElementById('file');
                    filebutton.innerHTML = "Bild auswählen...";
                    filebutton.style.cursor = "pointer";
                    filebutton.htmlFor = "pictureUpload";
                    document.getElementById('deletefile').value = 'true';
                    document.getElementById('preview').style.display = "none";
                    document.getElementById('previewbuttons').style.display = "none";
                    document.getElementById('invalidfiletype').style.display = "none";
                }
                $("#pictureUpload").change(function () {
                    imagePreview(this);
                });
            </script>

        <?php
            if(isset($_POST["submit"])) {
            $vorname = $_POST["vorname"];
            $nachname = $_POST["nachname"];
            $email = $_POST["email"];
            $position = $_POST["position"];
            $faecher_array = $_POST["chk_group"];
            $faecher = "";
            $infotext = $_POST["beschreibung"];
            $geburtstag = $_POST["geburtstag"];
            $id = $_GET['id'];
            $conn = get_connection();
            for ($i=0; $i < count($faecher_array); $i++) {
                $faecher = $faecher.$faecher_array[$i];
                if ($i < count($faecher_array)-1) {
                    $faecher = $faecher.";";
                }
            }
            if(isset($_POST["submit"]) && ($disabled == false && $ownedit == false)) {
                $insert = mysqli_query($conn, "UPDATE lehrer SET vorname='{$vorname}', nachname='{$nachname}', email='{$email}', position=NULLIF('{$position}', ''), faecher='{$faecher}', beschreibung=NULLIF('{$infotext}', ''), datum=NULLIF('{$geburtstag}','') WHERE id='{$id}'");
            }elseif(isset($_POST["submit"]) && ($disabled == false && $ownedit)){
                $insert = mysqli_query($conn, "UPDATE lehrer SET faecher='{$faecher}', beschreibung=NULLIF('{$infotext}', ''), datum=NULLIF('{$geburtstag}','') WHERE id='{$id}'");
            }
            if ($insert) {
                echo("<script>$('.confirm').show();</script>");
                if($_POST['deletefile'] == 'true' && $file_exists){ //delete File if delete is true
                    unlink($root.$imgpath);
                } elseif ($_FILES["pictureUpload"]["error"] != 4) {
                    $target_dir = "/usr/www/users/greenyr/frgym/new/files/site-ressources/lehrer-bilder/";
                    $extension = strtolower(pathinfo(basename($_FILES["pictureUpload"]["name"]),PATHINFO_EXTENSION));
                    $lehrername = strtolower(str_replace(" ","_",$_POST["vorname"])."_".str_replace(" ","_",$_POST["nachname"]));
                    $targetfilename = $lehrername.".".$extension;
                    $target_file = $target_dir . $targetfilename;
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                    echo $target_dir;
                    echo $lehrername;
                    echo $extension;
                    echo $imageFileType;

                    if(file_exists($root.$imgpath)) {
                        unlink($root.$imgpath);
                    }

                    // Check file size
                    if ($_FILES["pictureUpload"]["size"] > 10000000) {
                        // echo "Sorry, your file is too large.";
                        $uploadOk = 0;
                    }

                    // Allow certain file formats
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                        // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOk = 0;
                    }
                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        // echo "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                    } else {
                        if (move_uploaded_file($_FILES["pictureUpload"]["tmp_name"], $target_file)) {
                            // echo "The file ". htmlspecialchars( basename( $_FILES["pictureUpload"]["name"])). " has been uploaded.";
                        } else {
                            // echo "Sorry, there was an error uploading your file.";
                        }
                    }
                }
            }
        }
        ?>
        <div class="page-ending"></div>
        </div>
        <?php include_once "$root/sites/footer.html" ?>
    </body>
</html>