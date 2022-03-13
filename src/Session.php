<?php
/** @Entity */
class Session {
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="integer", length=1)
     */
    private $etat;


    /**
     * @Column(type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @Column(type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ManyToOne(targetEntity="Module");
     */
    private $module;

    
    
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

    
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    
    public function getStartDate()
    {
        return $this->startDate;
    }

    
    public function setEndDate($endDate = null)
    {
        $this->endDate = $endDate;

        return $this;
    }

    
    public function getEndDate()
    {
        return $this->endDate;
    }

    
    public function setModule(\Module $module = null)
    {
        $this->module = $module;

        return $this;
    }

    
    public function getModule()
    {
        return $this->module;
    }

    // fonction pour transformer l'objet en tableau pour l'API
    public function arrayfy(){
        return array(
            'id' => $this->getId(),
            'etat' => $this->getEtat(),
            'startDate' => $this->getStartDate(),
            'endDate' => $this->getEndDate(),
            'module' => $this->getModule()->arrayfy(),
        );
    }

    // comptage des mesures prises en une session
    public function countMesures($entityManager){
        $rep=$entityManager->getRepository('Mesure')->findBy(['session' => $this]);
        $i = 0;

        // 
        foreach ($rep as $m){
            $i++;
        }
        return $i;
    }

    // retourne la durée de fonctionnement
    public function dureeFonc(){
        $start = $this->getStartDate();

        date_default_timezone_set('Europe/Paris');
        $date = date("Y-m-d H:i:s");
        $date = new \DateTime($date);
        

        $diff = $start->diff($date);
        
        return $diff;
    }

}