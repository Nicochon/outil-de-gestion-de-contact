<?php
require_once 'ContactManager.php';
class CliCmd
{

	public function list() {
		$contactManager = new ContactManager();
		$contactsData = $contactManager->readContact();
		foreach ($contactsData as $contactData) {
			echo $contactData->toString()  . "\n";
		}
	}

	public function detail($line){
		$contactManager = new ContactManager();
		$pattern = '/[0-9]+/';
		$subject = $line;
		$matches = array();

		if (preg_match($pattern, $subject, $matches)) {
			$results = $contactManager->readContact($matches[0]);
			if($results !== null) {
					echo $results->toString() . "\n";
			} 
		} else {
			echo 'Aucune correspondance trouvée.' . "\n";

		}
	}

	public function create($line) {
		$contactManager = new ContactManager();

		preg_match_all('/\[([^\]]+)\]/', $line, $matches);
		$elements = $matches[1];
		$contactManager->createContact($elements);
	}

	public function delete($line){
		$contactManager = new ContactManager();

		$pattern = '/[0-9]+/';
		$subject = $line;
		$matches = array();

		if (preg_match($pattern, $subject, $matches)) {
			$idDelete = $matches[0];
			$contactManager->deleteContact($idDelete);
		}
	}

	public function help(){
		echo 'voici la liste des commandes disponnible:' . "\n";
		echo 'list: Va vous permettre de lister tous vos contactes' . "\n";
		echo 'detail: Avec le mot clef detail et un id vous pourrez cibler un contacte Exemple: detail 3  ' . "\n";
		echo 'create: Avec le mot clef create et en ajoutant le nom, l\'email, et le numero de téléphone vous pourrez créer un contacte exemple: create [Gandalf le gris], [gandalf@istari.com], [01013021]' . "\n";
		echo 'modify: Avec le mot clef modify et en ajoutant l\'id Pour retrouver le contacte à modifier, le nouveau nom, le nouvel email, et le nouveau numero de téléphone vous pourrez modifier un contacte exemple: modify [2] [Gandalf le gris], [gandalf@istari.com], [01013021]' . "\n";
		echo 'delete:  Avec le mot clef delete et un id vous pourrez supprimer un contacte Exemple: delete 3' . "\n";
	}

	/**
	 * @param $line
	 *
	 * @return void
	 */
	public function modify($line) {
		$contactManager = new ContactManager();

		preg_match_all('/\[([^\]]+)\]/', $line, $matches);
		$elements = $matches[1];
		$contactManager->updateContact($elements);
	}
}
?>