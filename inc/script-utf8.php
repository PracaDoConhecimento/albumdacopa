<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
require_once('connection.php');

$conn = new Conexao();
$conn->Connect();

$database = 'webpraca_albumdacopa';
$table = 'perguntas_respostas';
$column = 'respostas';
$primarykey = 'id';

if (mb_internal_encoding() != 'UTF-8') {
    die('This script must be run in an UTF-8 environment!');
}

$utf8_encode_callback = create_function('&$item,$key', 'if (is_string($item)) $item = utf8_encode($item);');

$tablecol = $table .'.'. $column;
$getvaluesSQL = "SELECT ". $tablecol ." AS thevalue, ". $primarykey ." AS primkey FROM ". $database .".". $table ." WHERE ". $tablecol ." IS NOT NULL AND LENGTH(". $tablecol .") > 0";

//TODO: insert code here for executing $getvaluesSQL against your database

if (mysqli_num_rows($db_getvalues) > 0) {
    while ($getvalues = mysqli_fetch_assoc($db_getvalues)) {
        $php = unserialize(utf8_decode($getvalues['thevalue']));

        if (is_array($php)) {
            array_walk_recursive($php, $utf8_encode_callback);
        } elseif (is_string($php)) {
            $php = utf8_encode($php);
        }

        $new_ser = serialize($php);

        # For checking that conversion happened correctly (compare the two files):
        #file_put_contents('c:/dump0.txt', $getvalues['thevalue'] ."\r\n", FILE_APPEND);
        #file_put_contents('c:/dump1.txt', $new_ser ."\r\n", FILE_APPEND);

        $sql = "UPDATE ". $database .".". $table ." SET ". $tablecol ." = '". sql_esc($new_ser) ."' WHERE ". $primarykey ." = ". $getvalues['primkey'];

        //TODO: insert code here for executing $sql against your database

    }
}
echo '<div>Done with '. $tablecol .'</div>';
?>