<?php
// Tady dej cestu do složky kde jsou uloženy obrázky na který chceš nahrát watermark
$dir = 'Cesta sem';
// Tady dej cestu do složky kam je chce outputnout
$dir2 = 'Cesta sem';
// Tady dej cestu k obrázku kterej chceš použít jako watermark
$watermark = 'Cesta sem';
// Příklad cesty - C:\Users\Safik\moti\dest\\
// Tohle projde všechny JPG obrázky
foreach (glob($dir . '*.jpg') as $file) {

    $background = imagecreatefromjpeg($file);

    $overlay = imagecreatefrompng($watermark);

    $overlay_width = imagesx($overlay);
    $overlay_height = imagesy($overlay);

    $x = (imagesx($background) - $overlay_width) / 2;
    $y = (imagesy($background) - $overlay_height) / 2;

    imagecopy($background, $overlay, $x, $y, 0, 0, $overlay_width, $overlay_height);

    // Tady se vytváří a ukládá obrázek
    $merged_file = $dir2 . basename($file);
    imagejpeg($background, $merged_file);

    // Tohle ti vyhodí kde se soubory vytvořily + jak se jmenuje, pokud se to nezobrazí tak je něco špatně
    echo "The merged image file has been saved to: $merged_file"."\n";

    // Hlavně nic neměň, při problému kontaktujte mě!
}
?>
