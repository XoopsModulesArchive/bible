<?php
// $Id: index.php,v 1 2004/07/18 14:45:56 buennagel Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
require('header.php');

include(XOOPS_ROOT_PATH.'/header.php');


include("config.php");

function is_valid_number($something)
	{
	if(preg_match("/^([0-9]+)$/", $something)) return(TRUE);
	else return(FALSE);
	}

//We try to _GET the infos.
if(isset($_GET["book"])) $config["book"] = $_GET["book"];
if(isset($_GET["chapter"])) $config["chapter"] = $_GET["chapter"];
if(isset($_GET["verse"])) $config["verse"] = $_GET["verse"];
if(isset($_GET["operation"])) $config["operation"] = $_GET["operation"];
if(isset($_GET["search"])) $config["search"] = $_GET["search"];
if(isset($_GET["page"])) $config["page"] = $_GET["page"];

if(isset($_POST["book"])) $config["book"] = $_POST["book"];
if(isset($_POST["chapter"])) $config["chapter"] = $_POST["chapter"];
if(isset($_POST["verse"])) $config["verse"] = $_POST["verse"];
if(isset($_POST["operation"])) $config["operation"] = $_POST["operation"];
if(isset($_POST["search"])) $config["search"] = $_POST["search"];
if(isset($_POST["page"])) $config["page"] = $_POST["page"];

if(isset($config["book"]) && strcmp($config["book"], "") == 0) unset($config["book"]);
if(isset($config["chapter"]) && strcmp($config["chapter"], "") == 0) unset($config["chapter"]);
if(isset($config["verse"]) && strcmp($config["verse"], "") == 0) unset($config["verse"]);
if(isset($config["operation"]) && strcmp($config["operation"], "") == 0) unset($config["operation"]);
if(isset($config["search"]) && strcmp($config["search"], "") == 0) unset($config["search"]);
if(isset($config["page"]) && strcmp($config["page"], "") == 0) unset($config["page"]);

if($config["disable_searching"] === TRUE)
	{
	if(isset($config["operation"]) && strcmp($config["operation"], "Search") == 0) unset($config["operation"]);
	unset($config["search"]);
	unset($config["page"]);
	}

//Now we assemble a correct URL to redirect to.
if(isset($config["book"]))
	{
	if(isset($config["book"]))
		{
		$stringbits[0] = ($config["book"]);
		if(isset($config["chapter"]))
			{
			$stringbits[1] = ("/" . $config["chapter"]);
			if(isset($config["verse"]))
				{
				$stringbits[2] = ("/" . $config["verse"]);
				}
			}
		}

	//Now assemble GET vars.
	unset($stringbits[3]); //Make sure is unset.
	if(isset($config["operation"]) && strcasecmp($config["operation"], "Go") != 0) //There is a special exception for operation "Go", because it's default anyway.
		{
		if(isset($stringbits[3]))
			$stringbits[3] = ($stringbits[3] . "&");
		else
			$stringbits[3] = ($stringbits[3] . "?");
		$stringbits[3] = ($stringbits[3] . "operation=" . $config["operation"]);
		}
	if(isset($config["search"]))
		{
		if(isset($stringbits[3]))
			$stringbits[3] = ($stringbits[3] . "&");
		else
			$stringbits[3] = ($stringbits[3] . "?");
		$stringbits[3] = ($stringbits[3] . "search=" . $config["search"]);
		}
	if(isset($config["page"]))
		{
		if(isset($stringbits[3]))
			$stringbits[3] = ($stringbits[3] . "&");
		else
			$stringbits[3] = ($stringbits[3] . "?");
		$stringbits[3] = ($stringbits[3] . "page=" . $config["page"]);
		}

	header("Location: " . $config["URI_prefix"] . $config["script_suffix"] . $stringbits[0] . $stringbits[1] . $stringbits[2] . $stringbits[3]);
	exit();
	}

if(isset($_SERVER["PATH_INFO"])) //The info from the path takes precedence.
	{
	$array = explode("/", $_SERVER["PATH_INFO"], 5);
	for($tint = 1;isset($array[$tint]);$tint++)
		{
		if($tint === 1)
			$config["book"] = $array[$tint];
		else if($tint === 2)
			$config["chapter"] = $array[$tint];
		else if($tint === 3)
			$config["verse"] = $array[$tint];
		}
	}

//echo(" \"" . $config["chapter"] . "\" \n");

?>
<?
if($config["headerless"] === FALSE)
	{
	?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<html>
		<head>
		<?
		if(!isset($config["operation"]) || !(strcmp($config["operation"], "print") == 0))
			{
			?>
			<style type="text/css">
				<? include($config["local_prefix"] . $config["themes_midfix"] . $config["theme"] . "/theme.php"); ?>
			</style>
			<?
			}
			?>
		<title><? echo($config["title"]); ?></title>
		</head>

	<body>
	<?
	}
?>

<div align="center"><h1><? echo($config["title"]); ?></h1></div>

<?
//Check for the validity of the input.
if(isset($config["chapter"]) && (is_valid_number($config["chapter"]) === FALSE))
	{
	if(strcmp($config["chapter"], "") != 0) echo("<h3>Desculpe, o Capítulo tem de ser um número.</h3>\n");
	unset($config["chapter"]); //Just get rid of it.
	}
if(isset($config["verse"]) && (is_valid_number($config["verse"]) === FALSE))
	{
	//There is a non-numerical character in verse. We /should/ be able to examine it for range.
	$temp_array = explode("-", $config["verse"], 2);
	if(isset($temp_array[0]) && isset($temp_array[1]) && is_valid_number($temp_array[0]) === TRUE && is_valid_number($temp_array[1]) === TRUE)
		{
		$config["verse"] = $temp_array[0];
		$config["verse_end"] = $temp_array[1];
		//echo("<h3>Verse Range \"" . $temp_array[0] . "\" - \"" . $temp_array[1] . "\"</h3>\n");
		if($config["verse_end"] <= $config["verse"])
			{
			echo("<h3>Sorry. With a verse range, ending Verse needs to be larger then begining Verse.</h3>\n");
			unset($config["verse"]);
			unset($config["verse_end"]);
			}
		}
	else
		{
		if(strcmp($config["verse"], "") != 0) echo("<h3>Desculpe, o Versículo precisa de ser um número.</h3>\n");
		unset($config["verse"]); //Just get rid of it.
		}
	}
if(isset($config["verse"]) && !isset($config["chapter"]))
	{
	echo("<h3>Sorry, you need a chapter if you're going to have a verse.</h3>\n");
	unset($config["verse"]); //Just get rid of it.
	}

if(strstr($config["book"], "/") === FALSE)
	{
	$bookok = FALSE; //Assume the book is invalid.

	for($tint = 0;isset($bible_books[$tint]);$tint++)
		{
		//echo("<p> " . $tint . " " . $config["book"] . " " . $bible_books[$tint]["long"] . " " . $bible_books[$tint]["short"]);
		if(strcasecmp($config["book"], $bible_books[$tint]["long"]) == 0) //This is a ref to the long name.
			{
			$bookok = TRUE; //The book is valid.
			$bookindex = $tint;
			$config["book"] = $bible_books[$tint]["short"]; //But the name needs to be the short version.
			//echo(" &lt;-- This!\n");
			}
		else if(strcasecmp($config["book"], $bible_books[$tint]["short"]) == 0) //This is a ref to the short name.
			{
			$bookok = TRUE; //The book is valid.
			$bookindex = $tint;
			$config["book"] = $bible_books[$tint]["short"]; //Make sure the name is exact. (We checked case insensitive, the case does matter though, so it's fixed.)
			//echo(" &lt;-- This!\n");
			}
		}

	//If it's still okay.
	if($bookok === TRUE)
		{
		//echo("<p>Book still okay\n");
		$bookfilename = ($config["local_prefix"] . $config["bible_midfix"] . $config["book"]); //Generate the real filename.
		//echo("<p>\"" . $bookfilename . "\"\n");
		$bookfile = @fopen($bookfilename, "rb"); //Try to open the book.
		if($bookfile == FALSE)
			{
			$bookok = FALSE;
			//echo("<p>No such book! \"" . $bookfilename . "\"\n");
			}
		else
			{
			//echo("<p>Book Opened! \"" . $bible_books[$bookindex]["long"] . "\"\n");
			}
		//echo("<p>Book either opened or not.\n");
		}
	}
else
	{
	$bookok = FALSE;
	}

if($bookok === FALSE && strcasecmp($config["operation"], "Search") != 0) //We'll be displaying a list of availible books if the book is bad we're not searching.
	{
	if(strcmp($config["book"], "") != 0) echo("<h3>Sorry, can't find Book \"" . $config["book"] . "\"</h3>\n");
	?>
<?
//Prepare the required vars.
$tint = 0;
$wrap = 0;
?>

<div align="center">
<hr><hr>
<h3><i><font size="4">Antigo Testamento</font></i></h3>
<hr width="40%"><br>
<h4>Livros da Lei</h4>
<p>
<table border="0"><tr align="center" valign="middle">
<?
$wrap = 0;
while($tint < 5)
	{
	if($wrap >= $config["element_wrap"])
		{
		$wrap = 0;
		echo("</tr><tr align=\"center\" valign=\"middle\">");
		}
	echo("<td><form ACTION=\"" . $config["URI_prefix"] . $config["script_suffix"] . $bible_books[$tint]["short"] . "/" . 1 . "/\" METHOD=\"post\"><input TYPE=\"submit\" VALUE=\"" . $bible_books[$tint]["long"] . "\"></form></td>\n");
	$tint++;
	$wrap++;
	}
?>
</tr></table>
<br><br><hr>
<h4>Livros Históricos</h4>
<p>
<table border="0"><tr align="center" valign="middle">
<?
$wrap = 0;
while($tint < 17)
	{
	if($wrap >= $config["element_wrap"])
		{
		$wrap = 0;
		echo("</tr><tr align=\"center\" valign=\"middle\">");
		}
	echo("<td><form ACTION=\"" . $config["URI_prefix"] . $config["script_suffix"] . $bible_books[$tint]["short"] . "/" . 1 . "/\" METHOD=\"post\"><input TYPE=\"submit\" VALUE=\"" . $bible_books[$tint]["long"] . "\"></form></td>\n");
	$tint++;
	$wrap++;
	}
?>
</tr></table>
<br><br><hr>
<h4>Livros de Sabedoria e Poéticos</h4>
<p>
<table border="0"><tr align="center" valign="middle">
<?
$wrap = 0;
while($tint < 22)
	{
	if($wrap >= $config["element_wrap"])
		{
		$wrap = 0;
		echo("</tr><tr align=\"center\" valign=\"middle\">");
		}
	echo("<td><form ACTION=\"" . $config["URI_prefix"] . $config["script_suffix"] . $bible_books[$tint]["short"] . "/" . 1 . "/\" METHOD=\"post\"><input TYPE=\"submit\" VALUE=\"" . $bible_books[$tint]["long"] . "\"></form></td>\n");
	$tint++;
	$wrap++;
	}
?>
</tr></table>
<br><br><hr>
<h4>The Books of the Prophets</h4>
<p>
<table border="0"><tr align="center" valign="middle">
<?
$wrap = 0;
while($tint < 39)
	{
	if($wrap >= $config["element_wrap"])
		{
		$wrap = 0;
		echo("</tr><tr align=\"center\" valign=\"middle\">");
		}
	echo("<td><form ACTION=\"" . $config["URI_prefix"] . $config["script_suffix"] . $bible_books[$tint]["short"] . "/" . 1 . "/\" METHOD=\"post\"><input TYPE=\"submit\" VALUE=\"" . $bible_books[$tint]["long"] . "\"></form></td>\n");
	$tint++;
	$wrap++;
	}
?>
</tr></table>
<br><br><hr><hr>
<h3><i><font size="4">Novo Testamento</font></i></h3>
<hr width="40%"><br>
<h4>Acontecimentos da Vida de Jesus Cristo na Terra e do Início da Igreja</h4>
<p>
<table border="0"><tr align="center" valign="middle">
<?
$wrap = 0;
while($tint < 44)
	{
	if($wrap >= $config["element_wrap"])
		{
		$wrap = 0;
		echo("</tr><tr align=\"center\" valign=\"middle\">");
		}
	echo("<td><form ACTION=\"" . $config["URI_prefix"] . $config["script_suffix"] . $bible_books[$tint]["short"] . "/" . 1 . "/\" METHOD=\"post\"><input TYPE=\"submit\" VALUE=\"" . $bible_books[$tint]["long"] . "\"></form></td>\n");
	$tint++;
	$wrap++;
	}
?>
</tr></table>
<br><br><hr>
<h4>Cartas do Apóstolo Paulo às Igrejas</h4>
<p>
<table border="0"><tr align="center" valign="middle">
<?
$wrap = 0;
while($tint < 53)
	{
	if($wrap >= $config["element_wrap"])
		{
		$wrap = 0;
		echo("</tr><tr align=\"center\" valign=\"middle\">");
		}
	echo("<td><form ACTION=\"" . $config["URI_prefix"] . $config["script_suffix"] . $bible_books[$tint]["short"] . "/" . 1 . "/\" METHOD=\"post\"><input TYPE=\"submit\" VALUE=\"" . $bible_books[$tint]["long"] . "\"></form></td>\n");
	$tint++;
	$wrap++;
	}
?>
</tr></table>
<br><br><hr>
<h4>Cartas do Apóstolo Paulo à Indivíduos</h4>
<p>
<table border="0"><tr align="center" valign="middle">
<?
$wrap = 0;
while($tint < 57)
	{
	if($wrap >= $config["element_wrap"])
		{
		$wrap = 0;
		echo("</tr><tr align=\"center\" valign=\"middle\">");
		}
	echo("<td><form ACTION=\"" . $config["URI_prefix"] . $config["script_suffix"] . $bible_books[$tint]["short"] . "/" . 1 . "/\" METHOD=\"post\"><input TYPE=\"submit\" VALUE=\"" . $bible_books[$tint]["long"] . "\"></form></td>\n");
	$tint++;
	$wrap++;
	}
?>
</tr></table>
<br><br><hr>
<h4>Outras Epístolas</h4>
<p>
<table border="0"><tr align="center" valign="middle">
<?
$wrap = 0;
while($tint < 65)
	{
	if($wrap >= $config["element_wrap"])
		{
		$wrap = 0;
		echo("</tr><tr align=\"center\" valign=\"middle\">");
		}
	echo("<td><form ACTION=\"" . $config["URI_prefix"] . $config["script_suffix"] . $bible_books[$tint]["short"] . "/" . 1 . "/\" METHOD=\"post\"><input TYPE=\"submit\" VALUE=\"" . $bible_books[$tint]["long"] . "\"></form></td>\n");
	$tint++;
	$wrap++;
	}
?>
</tr></table>
<br><br><hr>
<h4>Profecia</h4>
<p>
<table border="0"><tr align="center" valign="middle">
<?
$wrap = 0;
while($tint < 66)
	{
	if($wrap >= $config["element_wrap"])
		{
		$wrap = 0;
		echo("</tr><tr align=\"center\" valign=\"middle\">");
		}
	echo("<td><form ACTION=\"" . $config["URI_prefix"] . $config["script_suffix"] . $bible_books[$tint]["short"] . "/" . 1 . "/\" METHOD=\"post\"><input TYPE=\"submit\" VALUE=\"" . $bible_books[$tint]["long"] . "\"></form></td>\n");
	$tint++;
	$wrap++;
	}
?>
</tr></table>
<br><br><hr>
</div>
	<?
	}
else if(strcasecmp($config["operation"], "Search") == 0) //Not displaying the title page, but are searching.
	{
	if(!isset($config["search"]) || strcmp(trim($config["search"]), "") == 0) //If there's nothing in there.
		{
		echo("<h3>If I'm going to search, I need something to search for. (Regular Expressions are supported.)</h3>\n");
		}
	else
		{
		$config["search"] = addslashes(trim($config["search"]));
		$bdata_path = $config["local_prefix"] . $config["bible_midfix"];

		//if(!isset($config["book"]))
		if($bookok === FALSE)
			{
			unset($files); //Make sure is unset.
			foreach($bible_books as $bible_book)
				{
				$files = ($files . $bible_book["short"] . " ");
				}

			$command = ("'" . $config["search"] . "' " . $files);
			}
		else
			{
			$command = ("'" . $config["search"] . "' " . $config["book"]);
			}

		if(($search_results = popen($config["good_shell"] . " -c \"cd " . $bdata_path . "; env LANG=C " . $config["grep_command"] . " -H -i " . $command . "\"", "r")) == FALSE)
			{
			echo("<h3>Erro! Erro! Não é possível ler os resultados da pesquisa!</h3>\n");
			}
		else
			{
			echo("<div align=\"center\"><h3>Resultados de busca</h3></div>\n");

			if(is_valid_number($config["page"]) === FALSE) $config["page"] = 1; //If we can't use it, it is probably nothing.

			$evaluate_verse_next = TRUE;
			$page = 0;
			$subpage = $config["search_results_per_page"] + 5;

			while($search_results != FALSE && !feof($search_results))
				{
				$buffer = fgets($search_results, 128);
				if($evaluate_verse_next === TRUE && strcmp(rtrim($buffer), "") == 0) ;//echo("<h3>Killed a buffer!</h3>\n");
				else
					{
					if($evaluate_verse_next === TRUE)
						{
						//Ok, this is a new verse, so we need to parse in and mark up the verse header.
						$buffer = explode(" ", $buffer, 2); //Seperate the verse from the header.
						$versedata = explode(":", $buffer[0]); //Explode the chunks of the header.
						$buffer = $buffer[1];

						//Let's do our page thing.
						if($subpage >= $config["search_results_per_page"])
							{
							$page++;
							$subpage = 1;

							if($page == $config["page"]) $display = TRUE; //Allowed to display.
							else $display = FALSE;
							}
						else $subpage++;

						if($display === TRUE && $previous_book != $versedata[0]) //This is a new book.
							{
							if(isset($previous_book)) if($display === TRUE) { $output_buffer = $output_buffer . ("</ul></li>"); $started_book_list = FALSE; }
							for($tint = 0;isset($bible_books[$tint]);$tint++)
								{
								if(strcasecmp($versedata[0], $bible_books[$tint]["short"]) == 0) //This is a ref to the short name.
									$tstring = $bible_books[$tint]["long"];
								}

							if(!isset($tstring)) echo("<p><b>Error! \$tstring unset!</b></p>\n");

							if($display === TRUE) { $output_buffer = $output_buffer . ("<li>" . $tstring . "<ul>"); $started_book_list = TRUE; }
							$previous_book = $versedata[0];
							}
						if($display === TRUE) $output_buffer = $output_buffer . ("<li><sup><a href=\"" . $config["URI_prefix"] . $config["script_suffix"] . $versedata[0] . "/" . $versedata[1] . "/" . $versedata[2] . "\">" . $versedata[1] . ":" . $versedata[2] . "</a></sup> ");
						}
					if($display === TRUE) $output_buffer = $output_buffer . (htmlentities($buffer));
					$evaluate_verse_next = FALSE; //Assume that we're not going to evaluate the verse next time.
					if(!(strpos($buffer, "\n") === FALSE)) //If there is a newline, then the verse is over.
						{
						$evaluate_verse_next = TRUE;
						if($display === TRUE) $output_buffer = $output_buffer . ("</li>\n");
						}
					}
				}
			if(isset($started_book_list) && $started_book_list === TRUE) { $output_buffer = $output_buffer . ("</ul></li>"); $started_book_list = FALSE; } //Make sure we've closed the tags.

			if($page != 0)
				{
				echo("<div align=\"center\">\n");
				echo("<p>Page " . $config["page"] . " of " . $page . "</p>\n");

				/////PREVIOUS
				echo("<table border=\"0\" width=\"50%\"><tr>\n");
				echo("<td align=\"left\" valign=\"middle\">\n");
				echo("<form ACTION=\"" . $config["URI_prefix"] . $config["script_suffix"] . "\" METHOD=\"get\">\n");
				echo("<input type=\"hidden\" name=\"operation\" value=\"Search\">\n");
				if($bookok === TRUE) echo("<input type=\"hidden\" name=\"book\" value=\"" . $config["book"] . "\">\n");
				echo("<input type=\"hidden\" name=\"search\" value=\"" . $config["search"] . "\">\n");
				echo("<input type=\"hidden\" name=\"page\" value=\"" . ($config["page"] - 1) . "\">\n");
				if(($config["page"] - 1) < 1 || $config["page"] > $page || $config["page"] < 1) echo("<input type=\"submit\" value=\"&lt;&lt; Previous Page\" disabled>\n");
				else echo("<input type=\"submit\" value=\"&lt;&lt; Previous Page\">\n");
				echo("</form>\n");
				echo("</td>\n");

				/////SEEK
				echo("<td align=\"center\" valign=\"middle\">\n");
				echo("<form ACTION=\"" . $config["URI_prefix"] . $config["script_suffix"] . "\" METHOD=\"get\">\n");
				echo("<input type=\"hidden\" name=\"operation\" value=\"Search\">\n");
				if($bookok === TRUE) echo("<input type=\"hidden\" name=\"book\" value=\"" . $config["book"] . "\">\n");
				echo("<input type=\"hidden\" name=\"search\" value=\"" . $config["search"] . "\">\n");
				echo("Page: <input type=\"text\" name=\"page\" value=\"" . $config["page"] . "\" size=\"4\" maxlength=\"10\">\n");
				echo("<input type=\"submit\" value=\"Go\">\n");
				echo("</form>\n");

				/////NEXT
				echo("<td align=\"right\" valign=\"middle\">\n");
				echo("<form ACTION=\"" . $config["URI_prefix"] . $config["script_suffix"] . "\" METHOD=\"get\">\n");
				echo("<input type=\"hidden\" name=\"operation\" value=\"Search\">\n");
				if($bookok === TRUE) echo("<input type=\"hidden\" name=\"book\" value=\"" . $config["book"] . "\">\n");
				echo("<input type=\"hidden\" name=\"search\" value=\"" . $config["search"] . "\">\n");
				echo("<input type=\"hidden\" name=\"page\" value=\"" . ($config["page"] + 1) . "\">\n");
				if(($config["page"] + 1) > $page || $config["page"] > $page || $config["page"] < 1) echo("<input type=\"submit\" value=\"Proxima Pagina &gt;&gt;\" disabled>\n");
				else echo("<input type=\"submit\" value=\"Proxima Pagina &gt;&gt;\">\n");
				echo("</form>\n");
				echo("</td>\n");

				echo("</tr></table>\n");
				echo("</div>\n");
				}

			if(isset($output_buffer)) echo("<ul>\n" . $output_buffer . "</ul>\n");
			else if($page == 0) echo("<p>Desculpe, nenhum resultado para a busca.</p>\n");
			else if($config["page"] > $page || $config["page"] < 1) echo("<p>Desculpe, nada na página solicitada.</p>\n");
			else echo("<p>Não há nada para mostrar, e não sei o porquê. (Este é um bug.)\n");
			}
		}
	}
else //Not displaying the title page, or searching. (Display actual scripture.)
	{
	echo("<div align=\"center\"><h2>" . $bible_books[$bookindex]["long"]);
	if(isset($config["chapter"]) && !isset($config["verse"])) echo(", Capítulo " . $config["chapter"]);
	else if(isset($config["chapter"]) && isset($config["verse"])) echo(" " . $config["chapter"] . ":" . $config["verse"]);
	if(isset($config["verse"]) && isset($config["verse_end"])) echo("-" . $config["verse_end"]);
	echo("</h2></div>\n");

	$evaluate_verse_next = TRUE;

	$previous_chapter_exists = FALSE;
	$next_chapter_exists = FALSE;
	$previous_verse_exists = FALSE;
	$next_verse_exists = FALSE;

	$ever_displayed = FALSE;

	if(isset($config["verse"]) && isset($config["verse_end"])) $range_error = TRUE;
	else $range_error = FALSE;

	$last_chapter = 0;

	$range_hit_start = FALSE;
	$range_hit_end = FALSE;

	if(!isset($config["chapter"]) && !isset($config["verse"]))
		{
		echo("<div align=\"center\"><h3>Por favro, selecione um capítulo.</h3><table border=\"0\"><tr align=\"center\" valign=\"middle\">\n");
		$wrap = 0;
		}

	while(!feof($bookfile))
		{
		$buffer = fgets($bookfile, 128);
		if($evaluate_verse_next === TRUE && strcmp(rtrim($buffer), "") == 0) ;//echo("<h3>Killed a buffer!</h3>\n");
		else //Buffer isn't killed.
			{
			if($evaluate_verse_next === TRUE) //Last thing we did was find the end of a verse.
				{
				for($tint = 0;isset($buffer[$tint]) == TRUE && $buffer[$tint] != ":";$tint++) { ; }
				$current_chapter = substr($buffer, 0, $tint);
				$tint2 = $tint + 1;
				for($tint = 0;isset($buffer[$tint + $tint2]) == TRUE && $buffer[$tint + $tint2] != " ";$tint++) { ; }
				$current_verse = substr($buffer, $tint2, $tint);

				$display = FALSE; //Assume that we're not to display the data.

				if(isset($config["chapter"]) && $current_chapter < $config["chapter"]) $previous_chapter_exists = TRUE;
				if(isset($config["chapter"]) && $current_chapter > $config["chapter"]) $next_chapter_exists = TRUE;
				if(isset($config["chapter"]) && isset($config["verse"]) && $current_chapter === $config["chapter"] && $current_verse < $config["verse"]) $previous_verse_exists = TRUE;
				if(isset($config["chapter"]) && isset($config["verse"]) && !isset($config["verse_end"]) && $current_chapter === $config["chapter"] && $current_verse > $config["verse"]) $next_verse_exists = TRUE;
				if(isset($config["chapter"]) && isset($config["verse"]) && isset($config["verse_end"]) && $current_chapter === $config["chapter"] && $current_verse > $config["verse_end"]) $next_verse_exists = TRUE;

				if(isset($config["chapter"]) && isset($config["verse"]) && $current_chapter === $config["chapter"] && $current_verse === $config["verse"]) $display = TRUE;
				else if(isset($config["chapter"]) && isset($config["verse"]) && isset($config["verse_end"]) && $current_chapter === $config["chapter"] && $current_verse >= $config["verse"] && $current_verse <= $config["verse_end"]) $display = TRUE;
				if(isset($config["chapter"]) && !isset($config["verse"]) && $current_chapter === $config["chapter"]) $display = TRUE;

				if(isset($config["chapter"]) && $current_chapter === $config["chapter"] && isset($config["verse"]) && isset($config["verse_end"]) && $current_verse === $config["verse"]) $range_hit_start = TRUE;
				if(isset($config["chapter"]) && $current_chapter === $config["chapter"] && isset($config["verse"]) && isset($config["verse_end"]) && $current_verse === $config["verse_end"]) $range_hit_end = TRUE;

				if(!isset($config["chapter"]) && !isset($config["verse"]))
					{
					if($last_chapter < $current_chapter)
						{
						if($wrap >= $config["element_wrap"])
							{
							$wrap = 0;
							echo("</tr><tr align=\"center\" valign=\"middle\">");
							}

						echo("<td><form ACTION=\"" . $config["URI_prefix"] . $config["script_suffix"] . $bible_books[$bookindex]["short"] . "/" . $current_chapter . "/\" METHOD=\"post\"><input TYPE=\"submit\" VALUE=\"Capítulo: " . $current_chapter . "\"></form></td>\n");
						$last_chapter = $current_chapter;
						$wrap++;
						}
					}

				if($display === TRUE)
					{
					if($ever_displayed === FALSE) //Never displayed before.
						{
						if(!isset($config["operation"]) || !(strcmp($config["operation"], "print") == 0)) echo("<div align=\"center\"><p><table width=\"60%\" border=\"3\"><tr><td align=\"left\" valign=\"middle\">\n");
						else echo("<div align=\"left\"><p>\n");
						}
					$ever_displayed = TRUE;
					echo("<sup><a href=\"" . $config["URI_prefix"] . $config["script_suffix"] . $config["book"] . "/" . $current_chapter . "/" . $current_verse . "\">" . $current_chapter . ":" . $current_verse . "</a></sup> ");
					}
				}
			if($display === TRUE) //We are supposed to be printing the data here.
				{
				if($evaluate_verse_next === TRUE) echo(htmlentities(substr($buffer, strlen($current_chapter) + strlen($current_verse) + 2), ENT_COMPAT)); //This line actually dumps the data.
				else echo(htmlentities($buffer, ENT_COMPAT)); //This line actually dumps the data.
				}
			$evaluate_verse_next = FALSE; //Assume that we're not going to evaluate the verse next time.
			if(!(strpos($buffer, "\n") === FALSE)) //If there is a newline, then the verse is over.
				{
				$evaluate_verse_next = TRUE;
				if($display === TRUE) echo("<br>\n");
				}
			}
		}

	if($range_hit_start === TRUE && $range_hit_end === TRUE) $range_error = FALSE;

	if($ever_displayed === TRUE)
		{
		if(!isset($config["operation"]) || !(strcmp($config["operation"], "print") == 0))
			{
			echo("</td></tr></table></div>\n");
			echo("<div align=\"right\"><p><a target=\"_blank\" href=\"" . $config["URI_prefix"] . $config["script_suffix"] . $config["book"] . "/" . $config["chapter"] . "/" . $config["verse"]);
			if(isset($config["verse"]) && isset($config["verse_end"])) echo("-" . $config["verse_end"]);
			echo("?operation=print\">Modalidade Printable</a></p></div>\n");
			}
		else
			{
			echo("</p></div>\n");
			}
		}

	if(isset($config["chapter"]) && isset($config["verse"]) && (!isset($config["operation"]) || !(strcmp($config["operation"], "print") == 0)))
		{
		echo("<div align=\"center\"><form ACTION=\"" . $config["URI_prefix"] . $config["script_suffix"] . $config["book"] . "/" . $config["chapter"] . "/\" METHOD=\"post\">\n");
		echo("<input TYPE=\"submit\" VALUE=\"Zoom Out\"></form></div>\n");
		}

	if(!isset($config["chapter"]) && !isset($config["verse"]))
		{
		echo("</tr></table></div>\n");
		}
	else if($ever_displayed === FALSE || $range_error === TRUE)
		{
		//Make sure we're sufficiently sorry.
		echo("<div align=\"center\"><h3>Desculpe. Uma ou mais das passagens solicitadas não existe. " . $bible_books[$bookindex]["long"]);
		if(isset($config["chapter"]) && !isset($config["verse"])) echo(", Capítulo " . $config["chapter"]);
		else if(isset($config["chapter"]) && isset($config["verse"])) echo(" " . $config["chapter"] . ":" . $config["verse"]);
		if(isset($config["verse"]) && isset($config["verse_end"])) echo("-" . $config["verse_end"]);
		echo("</h3></div>\n");

		$previous_chapter_exists = FALSE;
		$next_chapter_exists = FALSE;
		$previous_verse_exists = FALSE;
		$next_verse_exists = FALSE;
		}

	if(isset($config["verse_end"])) $next_verse_start = $config["verse_end"];
	else if(isset($config["verse"])) $next_verse_start = $config["verse"];
	else $next_verse_start = 0;

	fclose($bookfile);
	}

if(!isset($config["operation"]) || !(strcmp($config["operation"], "print") == 0))
	{
	?>
	<div align="center">
		<table border="0" width="50%">
		<tr align="center" valign="middle">

			<td align="left"><form ACTION="<? echo($config["URI_prefix"] . $config["script_suffix"] . $config["book"] . "/" . ($config["chapter"] - 1) . "/" . $config["verse"]); ?>" METHOD="post"><input TYPE="submit" VALUE="<< Capítulo Anterior" <? if(isset($config["verse"]) || !isset($previous_chapter_exists) || $previous_chapter_exists != TRUE) echo("DISABLED"); ?> /></form></td>

			<td align="left"><form ACTION="<? echo($config["URI_prefix"] . $config["script_suffix"] . $config["book"] . "/" . $config["chapter"] . "/" . ($config["verse"] - 1)); ?>" METHOD="post"><input TYPE="submit" VALUE="<< Versículo Anterior" <? if(!isset($config["verse"]) || !isset($previous_verse_exists) || $previous_verse_exists != TRUE) echo("DISABLED"); ?> /></form></td>

			<td align="right"><form ACTION="<? echo($config["URI_prefix"] . $config["script_suffix"] . $config["book"] . "/" . $config["chapter"] . "/" . ($next_verse_start + 1)); ?>" METHOD="post"><input TYPE="submit" VALUE="Proximo Versículo >>" <? if(!isset($config["verse"]) || !isset($next_verse_exists) || $next_verse_exists != TRUE) echo("DISABLED"); ?> /></form></td>

			<td align="right"><form ACTION="<? echo($config["URI_prefix"] . $config["script_suffix"] . $config["book"] . "/" . ($config["chapter"] + 1) . "/" . $config["verse"]); ?>" METHOD="post"><input TYPE="submit" VALUE="Proximo Capítulo >>" <? if(isset($config["verse"]) || !isset($next_chapter_exists) || $next_chapter_exists != TRUE) echo("DISABLED"); ?> /></form></td>

		</tr></table>
		<p>Busca de uma passagem:
		<form ACTION="<? echo($config["URI_prefix"] . $config["script_suffix"]); ?>" METHOD="post">
			Livro: <select NAME="book">
			<!-- <option VALUE="" SELECTED>All Books (for searching)</option> -->
				<?
				for($tint = 0;isset($bible_books[$tint]);$tint++)
					{
					if($bookok === TRUE && $tint === $bookindex) echo("<option VALUE=\"" . $bible_books[$tint]["short"] . "\" SELECTED>" . $bible_books[$tint]["long"] . "</option>\n");
					else echo("<option VALUE=\"" . $bible_books[$tint]["short"] . "\">" . $bible_books[$tint]["long"] . "</option>\n");
					}
				?>
			</select>
			Capítulo:
				<?
				if(isset($config["chapter"])) echo("<input TYPE=\"text\" NAME=\"chapter\" size=\"4\" maxlength=\"10\" value=\"" . $config["chapter"] . "\">");
				else echo("<input TYPE=\"text\" NAME=\"chapter\" size=\"4\" maxlength=\"10\">");
				?>
            Versículo:
				<?
				if(isset($config["verse"]) && !isset($config["verse_end"])) echo("<input TYPE=\"text\" NAME=\"verse\" size=\"4\" maxlength=\"10\" value=\"" . $config["verse"] . "\">");
				else if(isset($config["verse"]) && isset($config["verse_end"])) echo("<input TYPE=\"text\" NAME=\"verse\" size=\"4\" maxlength=\"10\" value=\"" . $config["verse"] . "-" . $config["verse_end"] . "\">");
				else echo("<input TYPE=\"text\" NAME=\"verse\" size=\"4\" maxlength=\"10\">");
				?>
			<input type="hidden" name="operation" value="Go">
			<input type="submit" value="Vai">
		</form>

		<? if($config["disable_searching"] != TRUE)
			{
			?>
			<p>Busca de um termo:
			<form ACTION="<? echo($config["URI_prefix"] . $config["script_suffix"]); ?>" METHOD="get">
				Buscar no livro <select NAME="book">
				<option VALUE="">All Books</option>
					<?
					for($tint = 0;isset($bible_books[$tint]);$tint++)
						{
						if($bookok === TRUE && $tint === $bookindex) echo("<option VALUE=\"" . $bible_books[$tint]["short"] . "\" SELECTED>" . $bible_books[$tint]["long"] . "</option>\n");
						else echo("<option VALUE=\"" . $bible_books[$tint]["short"] . "\">" . $bible_books[$tint]["long"] . "</option>\n");
						}
					?>
				</select>

				Termo: <input type="text" name="search" value="<? if(isset($config["search"])) echo($config["search"]); ?>">
				<input type="hidden" name="operation" value="Search">
				<input type="submit" value="Search">

			</form>
			<?
			}
		?>
	</div>
	<?
	}
?>

<hr>

<div align="center">
<p>Bíblia On-Line - Versão Almeida Revista e Corrigida. Traduzida para a Língua
Portuguesa por Paulo Radamés à partir da Versão de Alex Markley's
<a href="http://bible.cyberMalex.com/">PHP<i>Script</i>ure</a> v1.2.3</p>

</div>

<?
if($config["headerless"] === FALSE && (!isset($config["operation"]) || !(strcmp($config["operation"], "print") == 0)))
	{
	?>
	<div align="left">
	<p>
		<a <? if($theme_unset != TRUE) { ?>style="background:<? echo($config["color"]["body"]["background"]); ?>;color:<? echo($config["color"]["body"]["foreground"]); ?>;" <? } ?> href="http://validator.w3.org/check/referer"><img style="border:0;width:88px;height:31px" src="http://www.w3.org/Icons/valid-html401" alt="Valid HTML 4.01!" height="31" width="88"></a>
		<? if($theme_unset != TRUE) { ?><a style="background:<? echo($config["color"]["body"]["background"]); ?>;color:<? echo($config["color"]["body"]["foreground"]); ?>;" href="http://jigsaw.w3.org/css-validator/check/referer"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!"></a> <? } ?>
	</p>
	</div>
	<?
	}
?>

<?
if($config["headerless"] === FALSE)
	{
	?>
	</body>
	</html>
	<?
	}

print '<a target="_blank" href="http://xoopsfire.com/"><img border="0" src="images/site.jpg" align="right"></a>';
include(XOOPS_ROOT_PATH.'/footer.php');
?>
