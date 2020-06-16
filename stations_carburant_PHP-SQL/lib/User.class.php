<?php
class User {
  public $pseudo;
  public $nom;
  public $description;
  public function __construct($pseudo,$nom,$description)
  {
    $this->pseudo = $pseudo;
    $this->nom = $nom;
    $this->description = $description;
  }
}
?>
