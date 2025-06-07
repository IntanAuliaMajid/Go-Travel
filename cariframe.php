<?php

$html = file_get_contents("https://www.google.com/maps/search/pakuwon/@-7.2690594,112.728457,11z?entry=ttu&g_ep=EgoyMDI1MDYwMy4wIKXMDSoASAFQAw%3D%3D");
$dom = new DOMDocument();
@$dom->loadHTML($html);
$iframes = $dom->getElementsByTagName("iframe");

foreach ($iframes as $iframe) {
    echo $iframe->getAttribute("src") . "\n";
}
