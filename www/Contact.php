<?php
include_once 'DBConnect.php';
class Contact {
	private ?int $id;
	private ?string $name;
	private ?string $email;
	private ?string $phoneNumber;

	public function __construct( ?string $name = null, ?string $email = null, ?string $phoneNumber = null) {
		$this->name = $name;
		$this->email = $email;
		$this->phoneNumber = $phoneNumber;
	}

	/**
	 * @return int|null
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int|null $id
	 */
	public function setId( ?int $id ): void {
		$this->id = $id;
	}

	/**
	 * @return string|null
	 */
	public function getName(): ?string {
		return $this->name;
	}

	/**
	 * @param string|null $name
	 */
	public function setName( ?string $name ): void {
		$this->name = $name;
	}

	/**
	 * @return string|null
	 */
	public function getEmail(): ?string {
		return $this->email;
	}

	/**
	 * @param string|null $email
	 */
	public function setEmail( ?string $email ): void {
		$this->email = $email;
	}

	/**
	 * @return string|null
	 */
	public function getPhoneNumber(): ?string {
		return $this->phoneNumber;
	}

	/**
	 * @param string|null $phoneNumber
	 */
	public function setPhoneNumber( ?string $phoneNumber ): void {
		$this->phoneNumber = $phoneNumber;
	}

	public function toString(): string {
		return "Contact [ID: {$this->id}, Name: {$this->name}, email: {$this->email}, Phone Number: {$this->phoneNumber}]";
	}

	public function findAll()
	{
		try {
			$dbConnect = new DBConnect();

			$contactsStatement = $dbConnect->contactsBDD->prepare('SELECT * FROM contact');
			$contactsStatement->execute();
			$contactsData = $contactsStatement->fetchAll();
			$contactsArray = array();
			if ($contactsData !== false) {
				foreach ($contactsData as $contactData) {

					$contact = clone $this;
					$contact->setId( $contactData['id'] );
					$contact->setName( $contactData['name'] );
					$contact->setEmail( $contactData['email'] );
					$contact->setPhoneNumber( $contactData['phone_number'] );
					$contactsArray[] = $contact;
				}
				return $contactsArray;
			} else {
				echo 'Aucune correspondance trouvée.' . "\n";
				return null;
			}
		} catch (Exception $e) {
			die('Erreur: ' . $e->getMessage());
		}
	}

	public function findById($id)
	{
		try {

			$dbConnect = new DBConnect();
			$id = (int) $id;

			$contactsStatement = $dbConnect->contactsBDD->prepare('SELECT * FROM contact WHERE id = :id');

			$contactsStatement->bindParam(':id', $id, PDO::PARAM_INT);
			$contactsStatement->execute();

			$contactData = $contactsStatement->fetch(PDO::FETCH_ASSOC);
			
			if ($contactData !== false) {

				$this->setId($contactData['id']);
				$this->setName($contactData['name']);
				$this->setEmail($contactData['email']);
				$this->setPhoneNumber($contactData['phone_number']);

				return $this;
			} else {
				echo 'Aucune correspondance trouvée.' . "\n";
				return null;
			}
		} catch (Exception $e) {
			die('Erreur: ' . $e->getMessage());
		}

	}

	public function findByPhone($email){
		try{
			$dbConnect = new DBConnect();
			$emailStatement = $dbConnect->contactsBDD->prepare('SELECT * FROM contact WHERE email = :email');
			$emailStatement->bindParam(':email', $email, PDO::PARAM_STR_CHAR);
			$emailStatement->execute();
			$contactEmail = $emailStatement->fetch(PDO::FETCH_ASSOC);
			return $contactEmail;
		} catch (PDOException $e) {
			echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
		}
	}

	public function insertContact() {
		if(!$this->findByEmail($this->email)){
			$dbConnect = new DBConnect();
			$sqlQuery = 'INSERT INTO contact (name, email, phone_number) VALUES ( :name, :email, :phone_number)';
			$inserContact = $dbConnect->contactsBDD->prepare($sqlQuery);
			$inserContact->execute([
				'name'=> $this->name,
				'email'=> $this->email,
				'phone_number'=> $this->phoneNumber,
			]);
			return true;
		} else {
			return false;
		}
	}

	public function contactDelete($idContact) {

		if($this->findById($idContact)){
			$dbConnect = new DBConnect();
			$sqlQuery = 'DELETE FROM contact WHERE id = :id';
			$deleteContact = $dbConnect->contactsBDD->prepare($sqlQuery);
			$deleteContact->bindParam(':id', $idContact, PDO::PARAM_INT);
			$deleteContact->execute();
			return true;
		} else {
			return false;
		}
	}

	public function findByEmail($email){
		try{
			$dbConnect = new DBConnect();
			$emailStatement = $dbConnect->contactsBDD->prepare('SELECT * FROM contact WHERE email = :email');
			$emailStatement->bindParam(':email', $email, PDO::PARAM_STR_CHAR);
			$emailStatement->execute();
			$contactEmail = $emailStatement->fetch(PDO::FETCH_ASSOC);

			if ($contactEmail !== false) {
				$contact = new Contact();
				$contact->setId($contactEmail['id']);
				$contact->setName($contactEmail['name']);
				$contact->setEmail($contactEmail['email']);
				$contact->setPhoneNumber($contactEmail['phone_number']);

				return $contact;
			}

		} catch (PDOException $e) {
			echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
		}
	}

	public function contactUpdate($modifyContact) {
		if($this->findById($modifyContact[0])){
			$dbConnect = new DBConnect();
			$sqlQuery = "UPDATE contact SET name = :newName,  email = :newEmail, phone_number = :newPhoneNumber WHERE id = :id";
			$updateContact = $dbConnect->contactsBDD->prepare($sqlQuery);
			$updateContact->bindParam(':newName', $modifyContact[1]);
			$updateContact->bindParam(':newEmail', $modifyContact[2]);
			$updateContact->bindParam(':newPhoneNumber', $modifyContact[3]);
			$updateContact->bindParam(':id', $modifyContact[0]);
			$updateContact->execute();
			return true;
		} else {
			return false;
		}
	}


}