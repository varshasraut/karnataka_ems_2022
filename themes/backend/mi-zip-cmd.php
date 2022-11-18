<?php
if(isset($_POST['create_zip'])){
    
    $dir = trim($_POST['dir']);
    $zip_type = trim($_POST['zip_type']);
    $zip = trim($_POST['zip']);

    if( $dir != '' && $zip != '' ){

        echo "<pre>";
        if( $zip_type == 'zip' ){
            echo system("zip -r $zip $dir");
            //echo exec("zip -r $zip $dir");
        }elseif( $zip_type == 'tar' ){
            echo system("tar -zcvf $zip $dir");
            //echo exec("tar -zcvf $zip $dir");
        }
        
        echo "<br>";
        echo "Successfully Created!";
        echo "</pre>";
        die();
        
    }
    
}


$DR = getcwd();
?>
DOCUMENT_ROOT: <?php echo $DR;?>
<br><br>
<form action="" method="post">

    Directory:<br>
    <input type="text" name="dir" style="width: 500px;"><br>
    Ex. <?php echo $DR.'/test';?>

    <br><br>

    Zip Type:<br>
    <select name="zip_type" style="width: 500px;">
        <option>Select Type</option>
        <option value="zip">zip</option>
        <option value="tar">tar</option>
    </select><br>

    <br><br>

    Zip File Path:<br>
    <input type="text" name="zip" style="width: 500px;"><br>
    Ex. <?php echo $DR.'/test.zip';?>

    <br><br>

    <input type="submit" name="create_zip" value="Create Zip">

</form>