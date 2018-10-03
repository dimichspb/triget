<?php
namespace app\models\room;

use app\models\BaseModel;
use Doctrine\Common\Collections\ArrayCollection;

class Room extends BaseModel
{
    /**
     * @var Id
     */
    protected $id;

    /**
     * @var Name
     */
    protected $name;

    /**
     * @var Description
     */
    protected $description;

    /**
     * @var Image
     */
    protected $image;

    /**
     * @var ArrayCollection
     */
    protected $bookings;

    /**
     * Room constructor.
     * @param Id $id
     * @param Name|null $name
     * @param Description|null $description
     * @param Image|null $image
     * @param ArrayCollection|null $bookings
     */
    public function __construct(Id $id, Name $name = null, Description $description = null, Image $image = null, ArrayCollection $bookings = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
        $this->bookings = $bookings? $bookings: new ArrayCollection();
    }

    /**
     * @return Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Name $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param Description $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param Image $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return ArrayCollection
     */
    public function getBookings()
    {
        return $this->bookings;
    }
}
