<?php
class style_helper
{
    public static $AUDITOR = "Auditor";
}

class exelstyles
{
    var $PT_STYLE =
    array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => true,
            'name' => 'Times New Roman',
            'size' => 12
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );

    var $headerStyle = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => true,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );

    var $headerStyleLeft = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => true,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );

    var $headerStyleRight = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => true,
            'name' => 'Times New Roman',
            'size' => 14
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );

    var $headerStyleLeftRight = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => false,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );

    var $headerStyleLeftTop = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => false,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );

    var $headerStyleRightTop = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => false,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );

    var $headerStyleLeftBottomTop =  array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => false,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );

    var $header_vertical = [
        'fill' => [
            'fillType' => PHPExcel_Style_Fill::FILL_SOLID
        ],
        'font' => [
            'bold' => false,
            'name' => 'Times New Roman',
            'size' => 9,
            'italic' => true // Set text to italic
        ],
        'numberFormat' => [
            'formatCode' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ],
        'borders' => [
            'bottom' => ['borderStyle' => PHPExcel_Style_Border::BORDER_THIN],
            'right' => ['borderStyle' => PHPExcel_Style_Border::BORDER_THIN],
            'left' => ['borderStyle' => PHPExcel_Style_Border::BORDER_THIN],
            'top' => ['borderStyle' => PHPExcel_Style_Border::BORDER_THIN]
        ],
        'alignment' => [
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrapText' => true,
            'textRotation' => 90 // Rotate text vertically
        ]
    ];

    var $headerStyleRightBottomTop = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => false,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );
    var $DetailStyle = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => false,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );
    var $DetailheaderStyle = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => true,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );
    var $DetailheaderStyle_noborder = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => false,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );
    var $DetailheaderStyleKiri = array(
        'fill'   => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'D3D3D3' // Light gray color
            )
        ),
        'font' => array(
            'bold'    => true,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );
    var $DetailheaderStyleLeft = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => true,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );

    var $bodyStyle = array(
        'fill'   => array(
            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('argb' => 'FFFFFFFF')
        ),
        'font'   => array(
            'name' => 'Times New Roman',
            'size'  => 10
        ),
        'numberformat'   => array(
            'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'     => true
        ),
    );

    var $bodyStyleAlignLeft = array(
        'fill'   => array(
            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('argb' => 'FFFFFFFF')
        ),
        'font'   => array(
            'name' => 'Times New Roman',
            'size'  => 10
        ),
        'numberformat'   => array(
            'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'     => true
        ),
    );
    var $bodyStyleAlignLeftTop = array(
        'fill'   => array(
            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('argb' => 'FFFFFFFF')
        ),
        'font'   => array(
            'bold'    => true,
            'name' => 'Times New Roman',
            'size'  => 10
        ),
        'numberformat'   => array(
            'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
            'wrap'     => true
        ),
    );
    var $bodyStyleAlignLeftBold = array(
        'fill'   => array(
            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('argb' => 'FFFFFFFF')
        ),
        'font'   => array(
            'bold'    => true,
            'name' => 'Times New Roman',
            'size'  => 10
        ),
        'numberformat'   => array(
            'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'     => true
        ),
    );
    var $bodyStyleLeft = array(
        'fill'   => array(
            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('argb' => 'FFFFFFFF')
        ),
        'font'   => array(
            'name' => 'Times New Roman',
            'size'  => 10
        ),
        'numberformat'   => array(
            'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'     => true
        ),
    );

    var $bodyStyleRight = array(
        'fill'   => array(
            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('argb' => 'FFFFFFFF')
        ),
        'font'   => array(
            'name' => 'Times New Roman',
            'size'  => 10
        ),
        'numberformat'   => array(
            'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'     => true
        ),
    );

    var $noborderStyle = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => false,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );
    var $noborderStyleBold = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => true,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );
    var $noborderStyleAlignRight = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => false,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );
    var $noborderStyleUnderline = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => true,
            'underline'    => true,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );
    var $footerStyle = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => false,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );
    var $footerStyleLeftbottom = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => false,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'left'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );
    var $footerStyleRightbottom = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'bold'    => false,
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        'borders' => array(
            'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );
    var $HDRheaderStyle = array(
        'fill'   => array(
            'type'    => PHPExcel_Style_Fill::FILL_SOLID
        ),
        'font' => array(
            'name' => 'Times New Roman',
            'size' => 9
        ),
        'numberformat'   => array(
            'code'    => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        ),
        // 'borders' => array(
        //   'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        //   'right'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        //   'left'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        //   'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        // ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap'       => true
        ),
    );

    var $DiagonalBorder = array(
        'borders' => array(
            'diagonal' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
            'diagonaldirection' => PHPExcel_Style_Borders::DIAGONAL_DOWN,
        ),
    );
}
