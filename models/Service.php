<?php

require_once('models/Model.php');

class Service
{
    use Model;

    private int $id;
    private string $name;
    private string $description;

    public function getserviceDetailById (int $id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM services WHERE id = ?');
        $serviceById = null;
        if ($stmt->execute([$id])) {
          $serviceById = $stmt->fetchObject('Service');
          if(!is_object($serviceById)) {
              $serviceById = null;
          }
        return $serviceById;
        }
    }

    public function addService (string $addname, string $adddescription)
    {
        function validAddServicedonnees($donnees) {
            $donnees = trim($donnees);
            $donnees = stripslashes($donnees);
            $donnees = htmlspecialchars($donnees);
            return $donnees;
        }
        
        $addname = validAddServicedonnees($_POST["addname"]);
        $adddescription = validAddServicedonnees($_POST["adddescription"]);
        
        if($addname !== "" && $adddescription !== "" ) {
                $stmt = $this->pdo->prepare('INSERT INTO services (name, description) 
                    VALUES (:addname, :adddescription)');
                $stmt->bindParam(':addname', $addname);
                $stmt->bindParam(':adddescription', $adddescription);
                $stmt->execute();
        } else {
            ?>
                <script type="text/javascript"> alert('Les informations du formulaire ne sont pas conformes') </script>
            <?php  
        } 
    }

    public function deleteservice (int $id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM services 
            WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function updateService (int $updateid, string $updatename, string $updatedescription)
    {
        function validUpdateServicedonnees($donnees) {
            $donnees = trim($donnees);
            $donnees = stripslashes($donnees);
            $donnees = htmlspecialchars($donnees);
            return $donnees;
        }
        
        $updatename = validUpdateServicedonnees($_POST["updatename"]);
        $updatedescription = validUpdateServicedonnees($_POST["updatedescription"]);

        $stmt = $this->pdo->prepare('UPDATE services 
            SET 
            name = :updatename, 
            description = :updatedescription 
            WHERE id = :updateid');
        $stmt->bindParam(':updateid', $updateid);
        $stmt->bindParam(':updatename', $updatename);
        $stmt->bindParam(':updatedescription', $updatedescription);
        $stmt->execute();
    }

    public function getServiceId()
    {
        return $this->id;
    }

    public function getServiceName()
    {
        return $this->name;
    }

    public function getServiceDescription()
    {
        return $this->description;
    }
}