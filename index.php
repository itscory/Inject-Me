<!--
Inject Me
Copyright (C) 2015  Corey H. Stewart

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
-->

<!DOCTYPE html>
<html>
<head>
<title>Inject Me</title>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-60155709-2', 'auto');
  ga('send', 'pageview');

</script>
<link href="style.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<meta name="description" content="Demonstrates how one might inject MySQL queries 
via a POST/GET vulnerability.">
<meta name="keywords" content="mysql inject, tutorial, example, mysql hack, POST inject, get inject">
<meta name="author" content="Corey H. Stewart">
</head>

<body>
<h1>Inject Me</h1>
<p><a href="http://github.com/itscory/Inject-Me" target="_blank">[Contribute on GitHub]</a></p>

<p><b>PHP echos will appear here:</b></p>
<hr>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	$conn = new mysqli("localhost", "injectmeuser", "password", "injectme");

	if ($conn->connect_error) {
		echo "MySQL connection failed for some reason: " . $conn->connect_error;
    }else{

        $sql = "SELECT user, pass FROM injectme.logins
        WHERE user = '$user' AND pass = '$pass'";

        if(!$result = $conn->query($sql)) {
            echo "MySQL failed for some reason : " . $sql ."<br>" . $conn->error;
        }else{
            echo "I did this for you: <b>" . $sql . "</b>";

            if ($result->num_rows > 0) {
                echo "<p style=\"color:green\">Login Successful!</p>";
            }else{
                echo "<p style=\"color:red\">Login Failed!</p>";
            }
        }
    }
}else{
    echo "Nothing to do without a POST.";
}
?>
<hr>
<h3>How it works:</h3>
<p>This site is just to demonstrate how one might inject MySQL queries 
via a POST/GET vulnerability. Here's how it's "suppose" to work: you put a username 
and password in the form, you click submit, and it will check the injectme.logins 
table for that pass/user combination. However, a skilled programmer, knowing that 
this site uses the coding below, will be able to do a lot more.</p>
<p>The username and password below works.</p>
<p>User: testuser Pass: testpass</p>
<br />
<form method="POST" action="">

<div>User: <input type="text" name="user"></div>
<div>Pass: <input type="password" name="pass"></div>
<input type="submit" value="Submit">
</form>
<br />
<div class="example">
<h3>Example:</h3>
<hr>
<p>Say you login using User: <b>testuser</b>, Pass: <b>' OR 1=1 -- </b>
<br>Then the server will do this:
</p>
<div class="coding">SELECT user, pass FROM injectme.logins WHERE user = 'testuser' AND pass = '' OR 1=1 -- '</div>
<p>Since <b>pass='' OR 1=1</b> is true, the login will be successful.</p>
</div>

<br><br>
<div class="example">
<h3>Source code:</h3>
<hr>

<p>&lt;?php</p>

<p>if ($_SERVER[&#39;REQUEST_METHOD&#39;] == &#39;POST&#39;)</p>

<p>{</p>

<p> $user = $_POST[&#39;user&#39;];</p>

<p> $pass = $_POST[&#39;pass&#39;];</p>

<p> // This MySQL user does not have DROP or ALTER privileges.</p>

<p> $conn = new mysqli(&quot;localhost&quot;, &quot;injectmeuser&quot;, &quot;password&quot;, &quot;injectme&quot;);</p>

<p> if ($conn->connect_error) {</p>

<p> die(&quot;MySQL connection failed for some reason: &quot; . $conn->connect_error);</p>

<p> }</p>

<p> $sql = &quot;SELECT user, pass FROM injectme.logins</p>

<p> WHERE user = &#39;$user&#39; AND pass = &#39;$pass&#39;&quot;;</p>

<p> if(!$result = $conn->query($sql)) {</p>

<p> echo &quot;MySQL failed for some reason : &quot; . $sql .&quot;&lt;br>&quot; . $conn->error;</p>

<p> }else{</p>

<p> echo &quot;I did this for you: &lt;b>&quot; . $sql . &quot;&lt;/b>&quot;;</p>

<p> if ($result->num_rows > 0) {</p>

<p> echo &quot;&lt;p style=\&quot;color:green\&quot;>Login Successful!&lt;/p>&quot;;</p>

<p> }else{</p>

<p> echo &quot;&lt;p style=\&quot;color:red\&quot;>Login Failed!&lt;/p>&quot;;</p>

<p> }</p>

<p> }</p>

<p>}else{</p>

<p>echo &quot;Nothing to do without a POST.&quot;;</p>

<p>}</p>

<p>?&gt;</p>
</div>
</body>
</html>
