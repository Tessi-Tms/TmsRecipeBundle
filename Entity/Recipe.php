<?php

/**
 * @author Pierre FERROLLIET <pierre.ferrolliet@idci-consulting.fr>
 */

namespace Tms\RecipeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Tms\RecipeBundle\Entity\Repository\RecipeRepository")
 * @ORM\Table(name="recipe")
 * @ORM\HasLifecycleCallbacks()
 */
class Recipe
{
    const STATE_AWAITING     = "Déposée";
    const STATE_VALIDATED    = "Validée";
    const STATE_UNVALIDATED  = "Refusée";
    const STATE_HANDLING     = "En cours";

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=256)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $people;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $cookingTime;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $preparationTime;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=128)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=128)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(type="string", columnDefinition="ENUM('Déposée', 'Validée', 'Refusée', 'En cours')")
     */
    private $state;

     /**
     * @ORM\OneToMany(targetEntity="Ingredient", mappedBy="recipe")
     */
    protected $ingredients;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $preparation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\PrePersist()
     */
    public function onCreate()
    {
        $now = new \DateTime("now");
        $this
            ->setCreatedAt($now)
            ->setUpdatedAt($now)
        ;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function onUpdate()
    {
        $this->setUpdatedAt(new \DateTime("now"));
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ingredients = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Recipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Recipe
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Recipe
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Recipe
     */
    public function setState($state)
    {
        if (!in_array($state, array(self::STATE_AWAITING, self::STATE_HANDLING, self::STATE_UNVALIDATED, self::STATE_VALIDATED))) {
            throw new \InvalidArgumentException("Invalid state for recipe.");
        }
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set people
     *
     * @param integer $people
     * @return Recipe
     */
    public function setPeople($people)
    {
        $this->people = $people;

        return $this;
    }

    /**
     * Get people
     *
     * @return integer 
     */
    public function getPeople()
    {
        return $this->people;
    }

    /**
     * Set cookingTime
     *
     * @param integer $cookingTime
     * @return Recipe
     */
    public function setCookingTime($cookingTime)
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    /**
     * Get cookingTime
     *
     * @return integer 
     */
    public function getCookingTime()
    {
        return $this->cookingTime;
    }

    /**
     * Set preparationTime
     *
     * @param integer $preparationTime
     * @return Recipe
     */
    public function setPreparationTime($preparationTime)
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    /**
     * Get preparationTime
     *
     * @return integer 
     */
    public function getPreparationTime()
    {
        return $this->preparationTime;
    }

    /**
     * Add ingredients
     *
     * @param \Tms\RecipeBundle\Entity\Ingredient $ingredients
     * @return Recipe
     */
    public function addIngredient(\Tms\RecipeBundle\Entity\Ingredient $ingredients)
    {
        $this->ingredients[] = $ingredients;

        return $this;
    }

    /**
     * Remove ingredients
     *
     * @param \Tms\RecipeBundle\Entity\Ingredient $ingredients
     */
    public function removeIngredient(\Tms\RecipeBundle\Entity\Ingredient $ingredients)
    {
        $this->ingredients->removeElement($ingredients);
    }

    /**
     * Get ingredients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Set preparation
     *
     * @param string $preparation
     * @return Recipe
     */
    public function setPreparation($preparation)
    {
        $this->preparation = $preparation;

        return $this;
    }

    /**
     * Get preparation
     *
     * @return string 
     */
    public function getPreparation()
    {
        return $this->preparation;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Recipe
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Recipe
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
