# Prompt Log — Site Analytics Dashboard
## Quiz 3 | Shruthi Anandraman | anands3

---

## Prompt 1 — Database Schema

Prompt given to AI:
"I'm building a site analytics dashboard for a web class. I need a MySQL CREATE TABLE statement for tracking page visits. I need to store: which page was visited, when it was visited, the visitor's IP address, and their browser info. Give me the CREATE TABLE statement with appropriate data types and explain why you chose each type."

What it returned:
It gave me a CREATE TABLE statement with VARCHAR for page URLs and IPs, DATETIME for timestamps, and TEXT for user agent. It explained why each type was chosen.

What I kept:
The VARCHAR(45) for IP addresses — I didn't know IPv6 addresses could be that long and needed that size. The DATETIME DEFAULT CURRENT_TIMESTAMP was also useful so I don't have to manually set the time.

What I changed:
I used my own database name (analytics_db) and renamed some columns to match my own naming convention. I also added AUTO_INCREMENT to the id column myself after realizing the AI left it off.

Why:
I made the decision about what data to actually track — the AI gave me the structure but I chose the columns based on what my dashboard actually needed to display.

---

## Prompt 2 — PHP Database Connection

Prompt given to AI:
"Write me a PHP database connection file called db.php that connects to a MySQL database called analytics_db using mysqli. It should handle connection errors without exposing sensitive details to the user, and instead log them. I'll be including this file in other PHP files."

What it returned:
A db.php file using new mysqli(), with an if ($conn->connect_error) check that called error_log() and showed a generic message to the user.

What I kept:
The error_log() approach instead of echoing the real error — I learned from Lab 9 that showing database errors to users is a security risk. Also kept the die() pattern to stop execution on failure.

What I changed:
Swapped in my actual server credentials and database name. Also removed a comment the AI added that included my password in plain text in the comment — that felt like bad practice.

Why:
The structure was right but the credentials were placeholders. I also didn't want any trace of my password in a comment that might get committed to GitHub.

---

## Prompt 3 — The Write Path (Logger)

Prompt given to AI:
"Write a PHP script called log_visit.php that takes a page name from a GET parameter and inserts it into a MySQL table called page_visits along with the visitor's IP address and user agent. It MUST use a prepared statement with bind_param — not string concatenation. After inserting, it should return a 1x1 transparent GIF so it can be loaded as an invisible image tag on other pages."

What it returned:
A complete log_visit.php with $conn->prepare(), bind_param("sss", ...), and the base64-encoded transparent GIF trick at the end.

What I kept:
The entire prepared statement structure and the GIF pixel idea — I hadn't thought of using an image src to trigger a server-side log without any visible page change. That was clever and I understood why it works.

What I changed:
I made sure the column names in bind_param matched exactly what I created in my table. I also added a check for whether the GET parameter was actually set before using it, using isset().

Why:
The AI's column names didn't match my schema from Prompt 1. I caught that by comparing the two and fixing it myself rather than just assuming they'd match.

---

## Prompt 4 — The Read Path (Dashboard Queries)

Prompt given to AI:
"Write PHP code for a dashboard that queries a MySQL table called page_visits three ways: (1) total visit count grouped by page_url ordered by most visited, (2) daily visit counts for the last 7 days using a prepared statement with a date parameter, (3) the 10 most recent visits. Store each result in a PHP array. Don't write the HTML yet, just the queries and data collection."

What it returned:
Three separate query blocks — a regular $conn->query() for the grouped counts, a prepared statement for the 7-day filter using strtotime('-7 days'), and a LIMIT 10 query for recent visits.

What I kept:
The strtotime('-7 days') approach for calculating the cutoff date — much cleaner than hardcoding a date. Also kept the pattern of storing results in arrays before building HTML, which separates the data logic from the presentation.

What I changed:
The AI used mysqli_fetch_assoc() procedural style instead of the object-oriented $result->fetch_assoc() I used in Lab 9. I switched it to match my existing code style for consistency.

Why:
Mixing procedural and OOP mysqli in the same file causes confusion. Since I learned the OOP style in Lab 9, I kept that consistent across my whole project.

---

## Prompt 5 — Building the HTML Output

Prompt given to AI:
"Now write the HTML output section of dashboard.php. Using the $pages array (page visit counts) and $latest result (recent visits), build an HTML table for each. Every value printed to the page MUST be wrapped in htmlspecialchars(). Also pass the $daily array to JavaScript using json_encode so I can use it in a chart. Add basic inline CSS for a card-style layout."

What it returned:
HTML with two tables, both using htmlspecialchars() on every echoed value, a canvas element for the chart, and a script tag passing json_encode($daily) to a JavaScript variable.

What I kept:
The json_encode pattern for passing PHP data to JavaScript — I didn't know you could do that so cleanly. Also kept htmlspecialchars() on every single output, which the AI applied consistently.

What I changed:
Replaced the AI's generic CSS with a link to my existing site stylesheet. Also restructured the HTML to match the layout style of my other Lab pages so it looks consistent.

Why:
The AI had no context about my existing site design. I had to connect the output to my real visual style — the AI just gave me functional HTML, the design decisions were mine.

---

## Prompt 6 — JavaScript Chart

Prompt given to AI:
"Write a JavaScript file called dashboard.js that uses the HTML5 canvas element to draw a bar chart from an array called dailyData. Each item has a 'day' (YYYY-MM-DD string) and 'total' (number). Draw bars proportional to the max value, label each bar with the date (just MM-DD) and the count. Add a refresh button below the canvas that reloads the page. Wrap everything in an IIFE so it doesn't pollute global scope."

What it returned:
A complete dashboard.js using canvas.getContext('2d'), calculating bar heights as a proportion of the max value, and a dynamically created refresh button appended to the DOM.

What I kept:
The IIFE wrapper (function() { ... })() — I understood from class that this prevents variable leaking into global scope. Also kept the proportional bar height calculation.

What I changed:
Changed the bar color to match my site's color palette. Also added the row highlight for the top visited page, which the AI didn't include — I thought that was a nice interactive touch.

Why:
The core math was right but the visual styling needed to be mine. The highlight feature was my own addition that made the dashboard feel more interactive beyond just the refresh button.

---

## Prompt 7 — The Logging Pixel HTML

Prompt given to AI:
"I have a script at /quiz3/log_visit.php that accepts a GET parameter called 'page' and returns a transparent 1x1 GIF. Write the HTML img tag I should paste into my existing HTML pages to silently log visits. Give me 4 examples with different page names matching these pages: about.html, labs.html, bio.html, fav.html"

What it returned:
Four img tags with width="1" height="1" style="display:none" and the correct src path with different ?page= values.

What I kept:
The display:none styling and the alt="" attribute — the AI reminded me that empty alt text is still needed for accessibility even on hidden images.

What I changed:
Verified the /quiz3/ path matched my actual server folder structure. I also moved the img tag to just before </body> instead of where the AI suggested (inside <head>) because it makes more sense to log after the page loads.

Why:
The AI placed it in the head which would fire before the full page load. Putting it at the end of body is more accurate — the visit is only fully counted when the page actually rendered.

---

## Prompt 8 — SQL Injection Break-It

Prompt given to AI:
"I have this safe PHP prepared statement: $stmt = $conn->prepare('INSERT INTO page_visits (page_url, ip_address, user_agent) VALUES (?, ?, ?)'); $stmt->bind_param('sss', $page, $ip, $agent); Rewrite it as a vulnerable version using string concatenation. Then show me a specific malicious URL parameter someone could use to exploit it and explain step by step what would happen to the database. Then explain exactly why the prepared statement prevents this."

What it returned:
The vulnerable version using direct concatenation, a specific attack URL using '); DROP TABLE page_visits; --, and a technical explanation of how the SQL parser interprets the injected input.

What I kept:
The specific attack string and the explanation of how the semicolon ends the first statement and starts a new one. That was the clearest explanation of SQL injection I'd seen.

What I changed:
I rewrote the "why prepared statements are safe" section in my own words for break-it.md rather than pasting the AI's explanation directly, because I needed to prove I understood it.

Why:
The assignment says if I can't explain code in my own words it shouldn't be in my submission. The same applies to the break-it explanations — I used the AI to understand it, then wrote my own version.

---

## Prompt 9 — XSS Break-It

Prompt given to AI:
"In my dashboard.php I print page URLs like this: echo $row['page_url']; without any escaping. Show me exactly what a malicious user would need to type as a page name to execute a script alert in other visitors' browsers. Then show me the fixed version using htmlspecialchars() and explain what it does to the characters that make XSS possible."

What it returned:
The malicious input <script>alert('hacked')</script>, an explanation of how it gets stored in the database and then rendered as executable HTML for every future visitor, and a table showing how htmlspecialchars() converts < to &lt; and > to &gt;.

What I kept:
The character conversion table — seeing that < becomes &lt; made the fix click for me. I also used the exact malicious input string in my break-it.md as the example.

What I changed:
I added a note specific to my project: since my dashboard displays stored page URLs, any stored script would run for every person who views the dashboard — making XSS especially damaging here compared to a one-time form.

Why:
The AI gave a generic XSS explanation. I connected it to the specific risk in my dashboard where the vulnerability is amplified because stored data is displayed to everyone, not just the original attacker.

---

## Prompt 10 — .htaccess Protection

Prompt given to AI:
"I have a PHP file called db.php inside my quiz3 folder that contains my MySQL username and password. Write me an .htaccess file that password-protects the entire quiz3 folder using Basic auth. Also write the htpasswd command I need to run on my Azure server to create the password file, stored outside the web root. Explain why storing .htpasswd outside the web root matters."

What it returned:
A complete .htaccess file with AuthType Basic, AuthName, AuthUserFile pointing to /etc/apache2/.htpasswd, and Require valid-user. Also gave me the htpasswd -c /etc/apache2/.htpasswd shruthi command to run via SSH.

What I kept:
The path /etc/apache2/.htpasswd — outside the web root — and the explanation that if it were inside /var/www/html, Apache might serve it as a plain text file exposing all usernames and hashed passwords.

What I changed:
Replaced the placeholder username with my own (shruthi) and double-checked that AllowOverride All was already set in my Apache config from Lab 10, since .htaccess won't work without it.

Why:
I already did .htaccess in Lab 10 so I knew what I was looking for. I used this prompt mainly to get the exact syntax right and confirm the file path. The understanding was already mine from the previous lab.