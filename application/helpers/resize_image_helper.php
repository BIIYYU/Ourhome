<?php

function resizeImageCk($image)
{
  $CI = &get_instance();
  $configer['image_library'] = 'gd2';
  $configer['source_image'] = $image;
  $configer['maintain_ratio'] = TRUE;
  $configer['width'] = 1024;
  $configer['height'] = 768;
  $CI->load->library('image_lib', $configer);
  $CI->image_lib->clear();
  $CI->image_lib->initialize($configer);
  $CI->image_lib->resize();
}
