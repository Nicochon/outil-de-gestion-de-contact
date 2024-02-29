<?php
require_once 'CliCmd.php';

$commandes = new CliCmd();

while (true) {
	$line = readline("Entrez votre commande : ");
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
}
?>