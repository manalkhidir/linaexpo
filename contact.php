<?php
// EDIT: put the email address that should receive messages from the contact form (an address on your own domain works best)
$to = "info@your-domain.com";

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !empty($_POST["website"])) { header("Location: index.html"); exit; }

$name  = str_replace(["\r", "\n"], " ", trim(strip_tags($_POST["name"] ?? "")));
$email = filter_var($_POST["email"] ?? "", FILTER_VALIDATE_EMAIL);
$msg   = trim(strip_tags($_POST["message"] ?? ""));
if (!$name || !$email || !$msg) { header("Location: index.html?sent=0#contact"); exit; }

$host = preg_replace("/^www\./", "", $_SERVER["SERVER_NAME"]);
$ok = mail($to, "New website message from $name", "$msg\n\nFrom: $name <$email>", "From: website@$host\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8");
header("Location: index.html?sent=" . ($ok ? "1" : "0") . "#contact");
