<?php
require_once 'ContactManager.php';
require_once 'CliCmd.php';

$commandes = new CliCmd();

$line = 'modify [2] [Nicolas Rivier], [n.rivier@algo-factory.com], [06.23.40.88.52]';
if ($line === 'list') {
	$commandes->list();
} elseif(strpos($line, 'detail') !== false) {
	$commandes->detail($line);
} elseif(strpos($line, 'create') !== false) {
	$commandes->create($line);
} elseif(strpos($line, 'delete') !== false) {
	$commandes->delete($line);
} elseif(strpos($line, 'modify') !== false) {
	$commandes->modify($line);
} elseif($line === 'help') {
	$commandes->help();
} else {
	echo "Vous avez saisi : $line\n";
}


?>

<!--list-->
<!--detail 2-->
<!--create [Gandalf le gris], [gandalf@istari.com], [01013021]-->
<!--delete 5-->
<!--help-->
<!--modify [2] [Nicolas Rivier], [n.rivier@algo-factory.com], [06.23.40.88.52]-->

