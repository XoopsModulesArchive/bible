<?
/*
 * config.php - The configuration for a simple web program written by Alex Markley to display chunks of the Holy Bible.
 */
require('header.php');
/*
This file is part of PHPScripture (Formally Alex's PHPBible).

PHPScripture is Copyright (C) 2003, Alex Markley

PHPScripture is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
//include "header.php";
//Headerless?
$config["headerless"] = FALSE; //Can be TRUE or FALSE. (Probably FALSE.)

//Theme? (Only takes effect if headerless is false.) (It is the name of a folder within the themes folder.)
$config["theme"] = "plain"; //No theme at all.
//$config["theme"] = "eternity"; //Green and forresty.
//$config["theme"] = "forest_bed"; //Green and forresty.
//$config["theme"] = "aquatic_geometry"; //Blue, watery, etc.

//Searching Stuff (Searching requires a sane version of GREP, and a sane shell to both be installed.)
$config["good_shell"] = "/bin/sh"; //Full path to borne or bash or something similar.
$config["grep_command"] = "egrep"; //Search command.
$config["disable_searching"] = FALSE; //Can be TRUE or FALSE. (Probably FALSE.)

//This stuff probably needs changed. ALL OF THESE VALUES SHOULD END IN A '/', EXCEPT IN VERY RARE CIRCUMSTANCES.
$config["URI_prefix"] = XOOPS_URL."/modules/bible/"; //Where the script lives on the web.
$config["script_suffix"] = "index.php/"; //The name of the main script. (It may seem strange that this should end in a '/', but that is indeed the case.)
$config["local_prefix"] = XOOPS_ROOT_PATH."/modules/bible/"; //Where the script lives on the disk. XOOPS_ROOT_PATH."/class/xoopstree.php";
$config["bible_midfix"] = "bible/"; //The directory that the bible data is in. ($config["local_prefix"] . $config["bible_midfix"])
$config["themes_midfix"] = "themes/"; //The directory that the bible data is in. ($config["local_prefix"] . $config["bible_midfix"])

//This stuff doesn't need changed, but it's useful.
$config["title"] = "Biblia Sagrada"; //Title of the page.
$config["element_wrap"] = 5; //Wrap every 5 things.
$config["search_results_per_page"] = 20; // 20 search results to a page

//Don't change the things below this line.
$config["version"]["major"] = 1;
$config["version"]["minor"] = 2;
$config["version"]["subminor"] = 3;

$bible_books[0]["long"] = "Gênesis";		$bible_books[0]["short"] = "Ge";
$bible_books[1]["long"] = "Êxodo";		$bible_books[1]["short"] = "Ex";
$bible_books[2]["long"] = "Levítico";		$bible_books[2]["short"] = "Le";
$bible_books[3]["long"] = "Números";		$bible_books[3]["short"] = "Nu";
$bible_books[4]["long"] = "Deuteronômio";	$bible_books[4]["short"] = "De";
$bible_books[5]["long"] = "Josué";		$bible_books[5]["short"] = "Jos";
$bible_books[6]["long"] = "Juízes";		$bible_books[6]["short"] = "Jud";
$bible_books[7]["long"] = "Rute";		$bible_books[7]["short"] = "Ru";
$bible_books[8]["long"] = "1 Samuel";		$bible_books[8]["short"] = "1Sa";
$bible_books[9]["long"] = "2 Samuel";		$bible_books[9]["short"] = "2Sa";
$bible_books[10]["long"] = "1 Reis";		$bible_books[10]["short"] = "1Ki";
$bible_books[11]["long"] = "2 Reis";		$bible_books[11]["short"] = "2Ki";
$bible_books[12]["long"] = "1 Crônicas";	$bible_books[12]["short"] = "1Ch";
$bible_books[13]["long"] = "2 Crônicas";	$bible_books[13]["short"] = "2Ch";
$bible_books[14]["long"] = "Esdras";		$bible_books[14]["short"] = "Ezr";
$bible_books[15]["long"] = "Neemias";		$bible_books[15]["short"] = "Ne";
$bible_books[16]["long"] = "Ester";		$bible_books[16]["short"] = "Es";
$bible_books[17]["long"] = "Jó";		$bible_books[17]["short"] = "Job";
$bible_books[18]["long"] = "Salmos";		$bible_books[18]["short"] = "Ps";
$bible_books[19]["long"] = "Provérbios";		$bible_books[19]["short"] = "Pr";
$bible_books[20]["long"] = "Eclesiastes";	$bible_books[20]["short"] = "Ec";
$bible_books[21]["long"] = "Cantares de Salomão";	$bible_books[21]["short"] = "So";
$bible_books[22]["long"] = "Isaías";		$bible_books[22]["short"] = "Isa";
$bible_books[23]["long"] = "Jeremias";		$bible_books[23]["short"] = "Jer";
$bible_books[24]["long"] = "Lamentacões de Jeremias";	$bible_books[24]["short"] = "La";
$bible_books[25]["long"] = "Ezequiel";		$bible_books[25]["short"] = "Eze";
$bible_books[26]["long"] = "Daniel";		$bible_books[26]["short"] = "Da";
$bible_books[27]["long"] = "Oséias";		$bible_books[27]["short"] = "Ho";
$bible_books[28]["long"] = "Joel";		$bible_books[28]["short"] = "Joe";
$bible_books[29]["long"] = "Amós";		$bible_books[29]["short"] = "Am";
$bible_books[30]["long"] = "Obadias";		$bible_books[30]["short"] = "Ob";
$bible_books[31]["long"] = "Jonas";		$bible_books[31]["short"] = "Jon";
$bible_books[32]["long"] = "Miquéias";		$bible_books[32]["short"] = "Mic";
$bible_books[33]["long"] = "Naum";		$bible_books[33]["short"] = "Na";
$bible_books[34]["long"] = "Habacuque";		$bible_books[34]["short"] = "Hab";
$bible_books[35]["long"] = "Sofonias";		$bible_books[35]["short"] = "Zep";
$bible_books[36]["long"] = "Ageu";		$bible_books[36]["short"] = "Hag";
$bible_books[37]["long"] = "Zacarias";		$bible_books[37]["short"] = "Zec";
$bible_books[38]["long"] = "Malaquias";		$bible_books[38]["short"] = "Mal";
$bible_books[39]["long"] = "Mateus";		$bible_books[39]["short"] = "Mt";
$bible_books[40]["long"] = "Marcos";		$bible_books[40]["short"] = "Mr";
$bible_books[41]["long"] = "Lucas";		$bible_books[41]["short"] = "Lu";
$bible_books[42]["long"] = "João";		$bible_books[42]["short"] = "Joh";
$bible_books[43]["long"] = "Atos dos Apóstolos";		$bible_books[43]["short"] = "Ac";
$bible_books[44]["long"] = "Romanos";		$bible_books[44]["short"] = "Ro";
$bible_books[45]["long"] = "1 Coríntios";	$bible_books[45]["short"] = "1Co";
$bible_books[46]["long"] = "2 Coríntios";	$bible_books[46]["short"] = "2Co";
$bible_books[47]["long"] = "Gálatas";		$bible_books[47]["short"] = "Ga";
$bible_books[48]["long"] = "Efésios";		$bible_books[48]["short"] = "Eph";
$bible_books[49]["long"] = "Filipenses";	$bible_books[49]["short"] = "Php";
$bible_books[50]["long"] = "Colossenses";	$bible_books[50]["short"] = "Col";
$bible_books[51]["long"] = "1 Tessalonicenses";	$bible_books[51]["short"] = "1Th";
$bible_books[52]["long"] = "2 Tessalonicenses";	$bible_books[52]["short"] = "2Th";
$bible_books[53]["long"] = "1 Timóteo";		$bible_books[53]["short"] = "1Ti";
$bible_books[54]["long"] = "2 Timóteo";		$bible_books[54]["short"] = "2Ti";
$bible_books[55]["long"] = "Tito";		$bible_books[55]["short"] = "Tit";
$bible_books[56]["long"] = "Filemom";		$bible_books[56]["short"] = "Phm";
$bible_books[57]["long"] = "Hebreus";		$bible_books[57]["short"] = "Heb";
$bible_books[58]["long"] = "Tiago";		$bible_books[58]["short"] = "Jas";
$bible_books[59]["long"] = "1 Pedro";		$bible_books[59]["short"] = "1Pe";
$bible_books[60]["long"] = "2 Pedro";		$bible_books[60]["short"] = "2Pe";
$bible_books[61]["long"] = "1 João";		$bible_books[61]["short"] = "1Jo";
$bible_books[62]["long"] = "2 João";		$bible_books[62]["short"] = "2Jo";
$bible_books[63]["long"] = "3 João";		$bible_books[63]["short"] = "3Jo";
$bible_books[64]["long"] = "Judas";		$bible_books[64]["short"] = "Jude";
$bible_books[65]["long"] = "Apocalipse";	$bible_books[65]["short"] = "Re";



?>
