<?php
/**
 * Generate PWA icons - jalankan 1x di browser:
 * http://localhost/mealplan/generate_icons.php
 */

function createIcon($size, $filename) {
    $img = imagecreatetruecolor($size, $size);
    imagesavealpha($img, true);

    // Background - brand orange
    $bg = imagecolorallocate($img, 232, 93, 38); // #e85d26
    imagefilledrectangle($img, 0, 0, $size, $size, $bg);

    // Rounded corners (simulate with circles)
    $radius = (int)($size * 0.18);
    $white = imagecolorallocate($img, 245, 245, 244);

    // Center circle (plate)
    $cx = (int)($size / 2);
    $cy = (int)($size / 2);
    $plateR = (int)($size * 0.28);
    imagefilledellipse($img, $cx, $cy, $plateR * 2, $plateR * 2, $white);

    // Inner circle
    $innerR = (int)($size * 0.18);
    $lightOrange = imagecolorallocate($img, 255, 243, 238);
    imagefilledellipse($img, $cx, $cy, $innerR * 2, $innerR * 2, $lightOrange);

    // Fork (left)
    $dark = imagecolorallocate($img, 196, 74, 26);
    $forkX = (int)($cx - $size * 0.22);
    imagesetthickness($img, max(2, (int)($size * 0.025)));
    imageline($img, $forkX, (int)($cy - $size * 0.25), $forkX, (int)($cy + $size * 0.25), $dark);
    // Fork prongs
    $prongW = (int)($size * 0.04);
    for ($i = -1; $i <= 1; $i++) {
        $px = $forkX + $i * $prongW;
        imageline($img, $px, (int)($cy - $size * 0.25), $px, (int)($cy - $size * 0.12), $dark);
    }

    // Knife (right)
    $knifeX = (int)($cx + $size * 0.22);
    imageline($img, $knifeX, (int)($cy - $size * 0.25), $knifeX, (int)($cy + $size * 0.25), $dark);
    // Knife blade
    imagefilledellipse($img, $knifeX + (int)($size * 0.02), (int)($cy - $size * 0.15), (int)($size * 0.06), (int)($size * 0.18), $dark);

    // Text "MP"
    $textColor = imagecolorallocate($img, 232, 93, 38);
    $fontSize = max(8, (int)($size * 0.14));
    $fontFile = null;

    // Try system font, fallback to built-in
    if (function_exists('imagettftext')) {
        $fonts = [
            'C:/Windows/Fonts/arialbd.ttf',
            '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
        ];
        foreach ($fonts as $f) {
            if (file_exists($f)) { $fontFile = $f; break; }
        }
    }

    if ($fontFile) {
        $bbox = imagettfbbox($fontSize, 0, $fontFile, 'MP');
        $tw = $bbox[2] - $bbox[0];
        $th = $bbox[1] - $bbox[7];
        imagettftext($img, $fontSize, 0, (int)($cx - $tw/2), (int)($cy + $th/2), $textColor, $fontFile, 'MP');
    } else {
        $tw = imagefontwidth(5) * 2;
        imagestring($img, 5, (int)($cx - $tw/2), (int)($cy - 8), 'MP', $textColor);
    }

    imagepng($img, $filename);
    imagedestroy($img);
    return true;
}

$dir = __DIR__ . '/assets/icons/';
if (!is_dir($dir)) mkdir($dir, 0777, true);

createIcon(192, $dir . 'icon-192.png');
createIcon(512, $dir . 'icon-512.png');
createIcon(180, $dir . 'apple-touch-icon.png');

echo "<h2>✅ Icons generated!</h2>";
echo "<p>Files created in /assets/icons/</p>";
echo "<img src='assets/icons/icon-192.png' style='width:96px;border:1px solid #ccc;border-radius:16px;'> ";
echo "<img src='assets/icons/icon-512.png' style='width:128px;border:1px solid #ccc;border-radius:24px;'>";
echo "<br><br><a href='index.php/dashboard'>← Kembali ke Dashboard</a>";
