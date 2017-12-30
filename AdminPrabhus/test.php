<?php
echo filter_var('<p>Regional Code: 2 (Japan, Europe, Middle East, South Africa).<br />
Languages: English, Deutsch.<br />
Subtitles: English, Deutsch, Spanish.<br />
Audio: Dolby Surround 5.1.<br />
Picture Format: 16:9 Wide-Screen.<br />
Length: (approx) 122 minutes.<br />
Other: Interactive Menus, Chapter Selection, Subtitles (more languages).</p>', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH);
echo '<br>';
echo htmlspecialchars('<p>Regional Code: "2" (Japan, Europe, Middle East, South Africa).<br />
Languages: English, Deutsch.<br />
Subtitles: English, Deutsch, Spanish.<br />
Audio: Dolby Surround 5.1.<br />
Picture Format: 16:9 Wide-Screen.<br />
Length: (approx) 122 minutes.<br />
Other: Interactive Menus, Chapter Selection, Subtitles (more languages).</p>',ENT_QUOTES);

 ?>
