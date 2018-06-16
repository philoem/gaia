<?php

namespace App\Entity;

use Serializable;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Valid;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Members
 *
 * @ORM\Table(name="members")
 * @ORM\Entity
 * @UniqueEntity(fields="username", message="Ce pseudonyme est déjà pris")
 * @UniqueEntity(fields="mail", message="Cet email existe déjà")
 * @Vich\Uploadable
 * 
 */
class Members implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_member", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\OneToMany(targetEntity="App\Entity\Adverts", mappedBy="idMember")
     */
    private $idMember;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=60, nullable=false)
     * @Assert\NotBlank(message="Le prénom est obligatoire !")
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=60, nullable=false)
     * @Assert\NotBlank(message="Le nom est obligatoire !")
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=60, nullable=false)
     * @Assert\NotBlank(message="Le pseudonyme est obligatoire !")
     * @Assert\Valid
     * 
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="L'email est impératif !")
     * @Assert\Email(message="L'email '{{ value }}' n'est pas un format valide")
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Choisissez un mot de passe !")
     * @Assert\Valid
     * 
     */
    private $password;
      
    /**
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @ORM\Column(name="roles", type="array", nullable=true)
     * 
     */
    private $roles = [];

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
     private $isActive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_register", type="datetime", nullable=false)
     * @ORM\GeneratedValue
     * @Assert\DateTime()
     */
    private $dateRegister;

    /**
    * @ORM\Column(name="locations", type="string", length=80, nullable=true)
    */
    private $locations;
    
    /**
    * @ORM\Column(name="lat", type="decimal", precision=6, scale=6,  nullable=true)
    */
    private $lat;

    /**
    * @ORM\Column(name="lng", type="decimal", precision=6, scale=6, nullable=true)
    */
    private $lng;

    /**
    * NOTE: This is not a mapped field of entity metadata, just a simple property.
    * 
    * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName", size="imageSize")
    * 
    * @var File
    */
    private $imageFile;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    *
    * @var string
    */
    private $imageName;

    /**
    * @ORM\Column(type="integer", nullable=true)
    *
    * @var integer
    */
    private $imageSize;

    /**
    * @ORM\Column(type="datetime", nullable=true)
    *
    * @var \DateTime
    */
    private $updatedAt;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        
        $this->dateRegister = new \DateTime();
        $this->isActive = true;
    }

    public function eraseCredentials(): void
    {
        //pas d'utilisation de 'plainpassword' donc pas besoin de 'eraseCreadentials()';
        // $this->plainPassword = null;
        
    }


    /**
     * Get the value of idMember
     *
     * @return  int
     */ 
    public function getIdMember()
    {
        return $this->idMember;
    }

    /**
     * Set the value of idMember
     *
     * @param  int  $idMember
     *
     * @return  self
     */ 
    public function setIdMember(int $idMember)
    {
        $this->idMember = $idMember;

        return $this;
    }

    /**
     * Get the value of firstname
     *
     * @return  string
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @param  string  $firstname
     *
     * @return  self
     */ 
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     *
     * @return  string
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @param  string  $lastname
     *
     * @return  self
     */ 
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }
  

    /**
     * Get the value of mail
     *
     * @return  string
     */ 
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set the value of mail
     *
     * @param  string  $mail
     *
     * @return  self
     */ 
    public function setMail(string $mail)
    {
        $this->mail = $mail;

        return $this;
    }
    

    /**
     * Get the value of dateRegister
     *
     * @return  \DateTime
     */ 
    public function getDateRegister()
    {
        return $this->dateRegister;
    }

    /**
     * Set the value of dateRegister
     *
     * @param  \DateTime  $dateRegister
     *
     * @return  self
     */ 
    public function setDateRegister(\DateTime $dateRegister)
    {
        $this->dateRegister = $dateRegister;

        return $this;
    }

    
    /**
     * Get the value of salt
     */ 
    public function getSalt(): ? string
    {
        return $this->salt;
    }

    /**
     * Set the value of salt
     *
     * @return  self
     */ 
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

      
    /**
     * Get the value of roles
     */ 
    public function getRoles(): array
    {
        $roles = $this->roles;
        // Un 'USER' aura toujours un rôle par défaut
        if(empty($roles)){
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    /**
     * Set the value of roles
     *
     * @return  self
     */ 
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get the value of isActive
     *
     * @return  booleen
     */ 
     public function getIsActive()
     {
         return $this->isActive;
     }
 
     /**
      * Set the value of isActive
      *
      * @param  booleen  $isActive
      *
      * @return  self
      */ 
     public function setIsActive(string $isActive)
     {
         $this->isActive = $isActive;
 
         return $this;
     }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    // serialize and unserialize must be updated - see below
    public function serialize()
    {
        return serialize(array(
            $this->idMember,
            $this->firstname,
            $this->lastname,                        
            $this->username,
            $this->mail,
            $this->password,
            $this->isActive,
            $this->roles,
            $this->locations,
            $this->lat,
            $this->lng,

        ));
    }
    public function unserialize($serialized)
    {
        list (
            $this->idMember,
            $this->firstname,
            $this->lastname,
            $this->username,
            $this->mail,
            $this->password,
            $this->isActive,
            $this->roles,
            $this->locations,
            $this->lat,
            $this->lng,
        ) = unserialize($serialized);
    }


    /**
     * Get the value of username
     *
     * @return  string
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @param  string  $username
     *
     * @return  self
     */ 
    public function setUsername(string $username)
    {
        $this->username = $username;

        return $this;
    }

    
    /**
     * Get the value of password
     *
     * @return  string
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param  string  $password
     *
     * @return  self
     */ 
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    /**
    * Get the value of locations
    *
    * @return  string
    */ 
    public function getLocations()
    {
        return $this->locations;
    }
 
    /**
    * Set the value of locations
    *
    * @param  string  $locations
    *
    * @return  self
    */ 
    public function setLocations(string $locations)
    {
        $this->locations = $locations;

        return $this;
    }

    /**
    * Get the value of lat
    *
    * @return  float
    */ 
    public function getLat()
    {
        return $this->lat;
    }
 
    /**
    * Set the value of lat
    *
    * @param  float  $lat
    *
    * @return  self
    */ 
    public function setLat(string $lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
    * Get the value of lng
    *
    * @return  float
    */ 
    public function getLng()
    {
        return $this->lng;
    }
 
    /**
    * Set the value of lng
    *
    * @param  float  $lng
    *
    * @return  self
    */ 
    public function setLng(string $lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
    * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
    * of 'UploadedFile' is injected into this setter to trigger the  update. If this
    * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
    * must be able to accept an instance of 'File' as the bundle will inject one here
    * during Doctrine hydration.
    *
    * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
    */
    public function setImageFile(?File $image = null): void
    {
        $this->imageFile = $image;

        if (null !== $image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }
    
    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }
        
}

