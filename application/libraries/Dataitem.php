<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Dataitem{
    function data_item($frmkode){
        switch ($frmkode){
            case $frmkode == "intqad080":
                $data['item_select'] = 'select headerid as "Data ID", dttahun as "Tahun", dtbulan as "Bulan", id_larutan as "Nama Larutan", to_char(completedate, \'DD/MM/YYYY\') as "Tanggal Input Terakhir", completetime as "Jam Input Terakhir"';
            break;
            default:
            break;
        }
    }
}
?>
