<?php
include_once 'DBConnect.php';
include_once 'Contact.php';
class ContactManager
{
	public function createContact($contact)
	{
		try {
			$contact = new Contact($contact[0], $contact[1], $contact[2]);

			if($contact->insertContact()){
				echo'contact enregistré' . "\n";
			} else {
				echo 'Contact déja enregistré' . "\n";
			}
		} catch (PDOException $e) {
			echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
		}

	}

	public function updateContact($modifyContact)
	{
		try {
			$contact = new Contact();
			if($contact->contactUpdate($modifyContact)){
				echo 'contact modifié' . "\n";
			} else {
				echo 'Aucun contactes ne correspond à votre recherche';
			}
		} catch (PDOException $e) {
			echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
		}
	}

	public function deleteContact($idContact)
	{
		try {
			$contact = new Contact();
			if($contact->contactDelete($idContact)){
				echo 'contact supprimé' . "\n";
			} else {
				echo 'Aucun contactes ne correspond à votre recherche';
			}
		} catch (PDOException $e) {
			echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
		}
	}

	public function readContact($idContact=false)
	{
		$contact = new Contact();
		if($idContact > 0){
			return $contact->findById($idContact);
		} else {
			return $contact->findAll();
		}

	}

}
?>