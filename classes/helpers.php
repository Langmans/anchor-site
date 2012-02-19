<?php

function url_title($str) {
	return preg_replace('/[^0-9a-zA-Z]+/', '-', strtolower(trim($str)));
}