<!--
/*
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
*/
-->

<html>
<head>
<title>Inject Me</title>
</head>

<body>
<h1>Inject Me</h1>

<p>PHP echos will appear here:</p>
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

<p>The PHP code is below.</p>
<hr>

<p>&lt;?php</p>

<p>if ($_SERVER[&#39;REQUEST_METHOD&#39;] == &#39;POST&#39;)</p>

<p>{</p>

<p> $user = $_POST[&#39;user&#39;];</p>

<p> $pass = $_POST[&#39;pass&#39;];</p>

<p> // This MySQL user does not have DROP or ALTER privileges.

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
       
</body>
</html>
