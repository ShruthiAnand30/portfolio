<?php
/*
 * IMPORTANT: The header() function must be called BEFORE any output is sent
 * to the browser. This includes HTML, whitespace, or even a blank line before
 * the opening <?php tag. HTTP headers are part of the response "head" that
 * the server sends before the "body" (page content). Once PHP begins sending
 * body output, the headers have already been transmitted and can no longer be
 * modified. Calling header() after output will trigger a
 * "headers already sent" warning and the redirect will fail.
 */
 
// Send a 302 Found (temporary) redirect to the /iit/ directory.
header("Location: /iit/", true, 302);
 
// Always exit after a redirect to stop the rest of the script from executing.
exit();
?>