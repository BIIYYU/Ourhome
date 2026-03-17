<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('modal_anim_load')) {
    function modal_anim_load($msg)
    {
        $html = '<div class="modal fade test" data-backdrop="static" data-keyboard="false" id="modalanimLoadData" tabindex="-1" role="dialog" aria-labelledby="modalanimLoadDataTitle" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                         <img src="' . base_url('assets/planegif.gif') . '" width="40%" height="40%">
                        <p class="mt-1">' . $msg . '</p>
                    </div>
                </div>
            </div>
        </div>';
        return $html;
    }
}

if (!function_exists('modal_anim_load2')) {
    function modal_anim_load2($msg)
    {
        $html = '<div class="modal fade test" data-backdrop="static" data-keyboard="false" id="modalanimLoadData2" tabindex="-1" role="dialog" aria-labelledby="modalanimLoadDataTitle" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="' . base_url('assets/planegif.gif') . '" width="40%" height="40%">
                    <p class="mt-1">' . $msg . '</p>
                </div>
              </div>
            </div>
        </div>';
        return $html;
    }
}

if (!function_exists('modal_anim_load3')) {
    function modal_anim_load3($msg) {
        $html = '<div class="wrap modal fade test" data-backdrop="static" data-keyboard="false" id="modalanimLoadData3" tabindex="-1" role="dialog" aria-labelledby="modalanimLoadDataTitle" style="display: none;" aria-hidden="true">
            <div class="loading">
                <div class="bounceball"></div>
                <div class="text">NOW LOADING</div>
                <p class="mt-1">' . $msg . '</p>
            </div>
        </div>';
        return $html;
    }
}

function greeting_time()
{
  $time = date("H");

  if ($time < "12") {
    $greetings = "good morning";
  } elseif ($time < "17") {
    $greetings = "good afternoon";
  } elseif ($time <= "19") {
    $greetings = "good afternoon";
  } elseif ($time >= "19") {
    $greetings = "good night";
  }

  return $greetings;
}

function tanggal_indo($tanggal, $cetak_hari = false)
{
  $hari = array(
    1 => 'Senin',
    'Selasa',
    'Rabu',
    'Kamis',
    'Jumat',
    'Sabtu',
    'Minggu'
  );

  $bulan = array(
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $split    = explode('-', $tanggal);
  $tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

  if ($cetak_hari) {
    $num = date('N', strtotime($tanggal));
    return $hari[$num] . ', ' . $tgl_indo;
  }
  return $tgl_indo;
}

