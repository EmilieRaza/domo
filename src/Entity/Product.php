<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="La description ne peut pas être vide!")
     * @Assert\Length(min=10)
     */
    private $shortDesc;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $solde;

    /**
     * @ORM\Column(type="integer")
     */
    private $sale;


    /**
     * @ORM\Column(type="boolean")
     */
    private $isHome;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductImage", mappedBy="product", cascade={"persist", "remove", "merge"})
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Size", inversedBy="products")
     */
    private $size;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandProduct", mappedBy="product", orphanRemoval=true)
     */
    private $commandProduct;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Weight", inversedBy="products")
     */
    private $weight;

    /**
     * @ORM\Column(type="boolean")
     */
    private $withDelivery;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     */
    private $priceCustomer;

    private $isCustomer;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $gamme;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $humitestEnAction;

    /**
     * @ORM\ManyToOne(targetEntity=Gamme::class, inversedBy="products")
     */
    private $gammeProduct;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isFlagship;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $linkVideo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isNewProduct;

    /**
     * @ORM\OneToMany(targetEntity=TitleCaracteristique::class, mappedBy="product")
     */
    private $titleCaracteristique;


    public function __construct()
    {
        $this->isActive = true;
        $this->isHome = false;
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->sale = 0;
        $this->solde = 0;
        $this->images = new ArrayCollection();
        $this->commandProduct = new ArrayCollection();
        $this->titleCaracteristique = new ArrayCollection();
    }

    public function isCustomer()
    {
        return $this->isCustomer;
    }

    public function setIsCustomer(bool $isCustomer): self
    {
        $this->isCustomer = $isCustomer;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice()
    {
        if($this->isCustomer() == true && $this->priceCustomer > 0 ){
            return $this->priceCustomer;
        }

        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getShortDesc(): ?string
    {
        return $this->shortDesc;
    }

    public function setShortDesc(string $shortDesc): self
    {
        $this->shortDesc = $shortDesc;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(?int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getSale(): ?int
    {
        return $this->sale;
    }

    public function setSale(int $sale): self
    {
        $this->sale = $sale;

        return $this;
    }

    public function getIsHome(): ?bool
    {
        return $this->isHome;
    }

    public function setIsHome(bool $isHome): self
    {
        $this->isHome = $isHome;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|ProductImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ProductImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProduct($this);
        }

        return $this;
    }

    public function removeImage(ProductImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

        return $this;
    }

    public function getPriceSolde()
    {
        $priceSolde = $this->price;

        $priceSolde = $priceSolde - (($this->solde*$priceSolde)/100);
        return number_format($priceSolde,2);
    }

    public function getSize(): ?Size
    {
        return $this->size;
    }

    public function setSize(?Size $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|CommandProduct[]
     */
    public function getCommandProduct(): Collection
    {
        return $this->commandProduct;
    }

    public function addCommandProduct(CommandProduct $commandProduct): self
    {
        if (!$this->commandProduct->contains($commandProduct)) {
            $this->commandProduct[] = $commandProduct;
            $commandProduct->setProduct($this);
        }

        return $this;
    }

    public function removeCommandProduct(CommandProduct $commandProduct): self
    {
        if ($this->commandProduct->contains($commandProduct)) {
            $this->commandProduct->removeElement($commandProduct);
            // set the owning side to null (unless already changed)
            if ($commandProduct->getProduct() === $this) {
                $commandProduct->setProduct(null);
            }
        }

        return $this;
    }

    public function getWeight(): ?Weight
    {
        return $this->weight;
    }

    public function setWeight(?Weight $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getWithDelivery(): ?bool
    {
        return $this->withDelivery;
    }

    public function setWithDelivery(bool $withDelivery): self
    {
        $this->withDelivery = $withDelivery;

        return $this;
    }

    public function getPriceCustomer()
    {
        return $this->priceCustomer;
    }

    public function setPriceCustomer($priceCustomer): self
    {
        $this->priceCustomer = $priceCustomer;

        return $this;
    }

    public function getGamme(): ?string
    {
        return $this->gamme;
    }

    public function setGamme(string $gamme): self
    {
        $this->gamme = $gamme;

        return $this;
    }

    public function getHumitestEnAction(): ?string
    {
        return $this->humitestEnAction;
    }

    public function setHumitestEnAction(?string $humitestEnAction): self
    {
        $this->humitestEnAction = $humitestEnAction;

        return $this;
    }

    public function getGammeProduct(): ?Gamme
    {
        return $this->gammeProduct;
    }

    public function setGammeProduct(?Gamme $gammeProduct): self
    {
        $this->gammeProduct = $gammeProduct;

        return $this;
    }

    public function getIsFlagship(): ?bool
    {
        return $this->isFlagship;
    }

    public function setIsFlagship(?bool $isFlagship): self
    {
        $this->isFlagship = $isFlagship;

        return $this;
    }

    public function getLinkVideo(): ?string
    {
        return $this->linkVideo;
    }

    public function setLinkVideo(?string $linkVideo): self
    {
        $this->linkVideo = $linkVideo;

        return $this;
    }

    public function getIsNewProduct(): ?bool
    {
        return $this->isNewProduct;
    }

    public function setIsNewProduct(?bool $isNewProduct): self
    {
        $this->isNewProduct = $isNewProduct;

        return $this;
    }

    /**
     * @return Collection|TitleCaracteristique[]
     */
    public function getTitleCaracteristique(): Collection
    {
        return $this->titleCaracteristique;
    }

    public function addTitleCaracteristique(TitleCaracteristique $titleCaracteristique): self
    {
        if (!$this->titleCaracteristique->contains($titleCaracteristique)) {
            $this->titleCaracteristique[] = $titleCaracteristique;
            $titleCaracteristique->setProduct($this);
        }

        return $this;
    }

    public function removeTitleCaracteristique(TitleCaracteristique $titleCaracteristique): self
    {
        if ($this->titleCaracteristique->removeElement($titleCaracteristique)) {
            // set the owning side to null (unless already changed)
            if ($titleCaracteristique->getProduct() === $this) {
                $titleCaracteristique->setProduct(null);
            }
        }

        return $this;
    }
}
