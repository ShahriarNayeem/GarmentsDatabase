<?php

$conn = oci_connect("system","abcd","localhost/XE");

if (!$conn)
{
    echo "Can not Connect with database.";
    echo "<br>";
}