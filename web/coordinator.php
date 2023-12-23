<?php
// comment out the following two lines when deployed to production

header('x-coordinator-set-cookie: x-user-logged-in=1');
header('x-coordinator-set-header: x-user-logged-in=1');
header('userLoggedIn: 1');
setcookie('userLoggedIn',1);
http_response_code(307);


if($_COOKIE['userToken'] == '12345'){
    header('x-coordinator-set-cookie: userLoggedIn=1');
    header('x-coordinator-set-header: userLoggedIn=1');
    http_response_code(307);
}

if($_COOKIE['userToken'] == '67890'){
    header('x-coordinator-set-cookie: userLoggedIn=0');
    header('x-coordinator-set-header: userLoggedIn=0');
    http_response_code(307);
}

