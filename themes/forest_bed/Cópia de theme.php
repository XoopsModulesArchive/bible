<?
//This is a sample theme file for PHPScripture.

//It is included directly into the <head>'s stylesheet, so it is very flexible. However, the variables below MUST be set.

//It's important that these variables get set.
$config["color"]["body"]["background"] = "#3e5730"; //This controls various things regarding text color.
$config["color"]["body"]["foreground"] = "#ffffff"; //This controls various things regarding text color.
$theme_unset = FALSE; //This controls wether the color variables above are used, and whether a "Valid CSS" icon is placed in the document.
?>

html, body
	{
	background: <? echo($config["color"]["body"]["background"]); ?>;
	color: <? echo($config["color"]["body"]["foreground"]); ?>;
	
	background-image: url(<? echo($config["URI_prefix"] . $config["themes_midfix"] . $config["theme"] . "/backdrop.jpg"); ?>);
	background-repeat: repeat;
	background-attachment: fixed;
	background-position: top left;
	}

a:link		{ color: #bbff91; }

a:visited	{ color: #bbff91; }

a:hover		{ background: #ffffff; color: #3e5730; }
