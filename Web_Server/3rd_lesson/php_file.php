$htmlSoubor = file_get_contents('forms.html');
$nazev = "Frajer";

$htmlSoubor = str_replace("#NAZEV#", $nazev, $htmlSoubor);
print($htmlSoubor);
