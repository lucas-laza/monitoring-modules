<?php
/** @Entity */
class Mesure {
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="integer",length=64, nullable=true)
     */
    private $valeur;

    /**
     * @Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ManyToOne(targetEntity="Session");
     */
    private $session;



    
    public function getId()
    {
        return $this->id;
    }

    
    public function setValeur($valeur = null)
    {
        $this->valeur = $valeur;

        return $this;
    }

   
    public function getValeur()
    {
        return $this->valeur;
    }

    

    
    public function setDate(\DateTimeInterface $date)
    {
        $this->date = $date;

        return $this;
    }

    
    public function getDate()
    {
        return $this->date;
    }

   
    public function setSession(\Session $session = null)
    {
        $this->session = $session;

        return $this;
    }

   
    public function getSession()
    {
        return $this->session;
    }

    // fonction pour transformer l'objet en tableau pour l'API
    public function arrayfy(){
        return array(
            'id' => $this->getId(),
            'valeur' => $this->getValeur(),
            'date' => $this->getDate(),
            'session' => $this->getSession()->arrayfy(),
        );
    }



}