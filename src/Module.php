<?php
/** @Entity */
class Module {
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="integer", length=1)
     */
    //Etat du module, allumé, éteint...
    private $etat;

    /**
     * @Column(type="text",length=64)
     */
    private $nom;

    /**
     * @Column(type="integer",length=32)
     */
    //Période en secondes entre deux prises de mesures.
    private $periode;

    
    
    /**
     * @Column(type="text",length=64)
     */
    private $unite;

    /**
     * @Column(type="text",length=64,nullable=true)
     */
    private $nbSerie;

    /**
     * @Column(type="text",length=256)
     */
    private $description;



    
    
    public function getId()
    {
        return $this->id;
    }

    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    
    public function getEtat()
    {
        return $this->etat;
    }

   
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    
    public function getNom()
    {
        return $this->nom;
    }

    
    public function setUnite($unite)
    {
        $this->unite = $unite;

        return $this;
    }

   
    public function getUnite()
    {
        return $this->unite;
    }

    
    public function setPeriode($periode)
    {
        $this->periode = $periode;

        return $this;
    }

    
    public function getPeriode()
    {
        return $this->periode;
    }

    
    public function setNbSerie($nbSerie = null)
    {
        $this->nbSerie = $nbSerie;

        return $this;
    }

    
    public function getNbSerie()
    {
        return $this->nbSerie;
    }

    
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    
    public function getDescription()
    {
        return $this->description;
    }


    // fonction pour transformer l'objet en tableau pour l'API
    public function arrayfy(){
        return array(
            'id' => $this->getId(),
            'etat' => $this->getEtat(),
            'nom' => $this->getNom(),
            'unite' => $this->getUnite(),
            'nbSerie' => $this->getNbSerie(),
            'periode' => $this->getPeriode(),
            'description' => $this->getDescription(),
        );
    }

    public function DureeFonc(){
        $this->getStartDate();
    }

}