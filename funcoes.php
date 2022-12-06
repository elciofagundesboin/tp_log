<?php
function ckpt_pending_transactions($line){
    $remove = array("<", ">", "ckpt", "CKPT", " ", "(", ")");
    $new_line = str_replace($remove, "", $line);
    $transactions = explode(",", $new_line);
    return $transactions;
}
?>