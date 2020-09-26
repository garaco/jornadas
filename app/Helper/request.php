<?php

function request( $val ) {
    return $_GET[$val];
}

function input( $val ) {
    return $_POST[$val];
}

function files( $val ) {
    return $_FILES[$val];
}

function type() {
    @session_start();
    return @$_SESSION['type'];
}

function user() {
    @session_start();
    return @$_SESSION['Username'];
}
