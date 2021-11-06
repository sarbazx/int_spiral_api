<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Dto\LayoutInput;
use App\Dto\LayoutOutput;
use App\Repository\LayoutRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *   input=LayoutInput::class,
 *   output=LayoutOutput::class,
 *   collectionOperations={"get", "post"},
 *   itemOperations={"get"}
 * )
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass=LayoutRepository::class)
 */
class Layout
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="integer")
   */
  private $x;

  /**
   * @ORM\Column(type="integer")
   */
  private $y;

  /**
   * @ORM\Column(type="array")
   */
  private $data = [];

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getX(): ?int
  {
    return $this->x;
  }

  public function setX(int $x): self
  {
    $this->x = $x;

    return $this;
  }

  public function getY(): ?int
  {
    return $this->y;
  }

  public function setY(int $y): self
  {
    $this->y = $y;

    return $this;
  }

  public function getData(): ?array
  {
    return $this->data;
  }

  public function setData(): self
  {
    $this->data = $this->generateSpiral();

    return $this;
  }

  public function getSpiralString()
  {
    $spiral = '';
    foreach ($this->data as $row) {
      foreach ($row as $value) {
        $spiral .= $value . ' ';
      }
      $spiral .= PHP_EOL;
    }
    return $spiral;
  }

  private function generateSpiral()
  {
    if ($this->x <= 0 || $this->y <= 0) return FALSE;

    $ar   = [];
    $used = [];

    for ($j = 0; $j < $this->y; $j++) {
      $ar[$j] = [];
      for ($i = 0; $i < $this->x; $i++)
        $ar[$j][$i]   = '-';
    }

    for ($j = -1; $j <= $this->y; $j++) {
      $used[$j] = [];
      for ($i = -1; $i <= $this->x; $i++) {
        if ($i == -1 || $i == $this->x || $j == -1 || $j == $this->y)
          $used[$j][$i] = true;
        else
          $used[$j][$i] = false;
      }
    }

    $n         = 0;
    $i         = 0;
    $j         = 0;
    $direction = 0;
    while (true) {
      $ar[$j][$i]   = $n++;
      $used[$j][$i] = true;

      switch ($direction) {
        case 0:
          $i++;
          if ($used[$j][$i]) {
            $i--;
            $j++;
            $direction = 1;
          }
          break;
        case 1:
          $j++;
          if ($used[$j][$i]) {
            $j--;
            $i--;
            $direction = 2;
          }
          break;
        case 2:
          $i--;
          if ($used[$j][$i]) {
            $i++;
            $j--;
            $direction = 3;
          }
          break;
        case 3:
          $j--;
          if ($used[$j][$i]) {
            $j++;
            $i++;
            $direction = 0;
          }
          break;
      }


      if ($used[$j][$i])
        return $ar;
    }
  }
}
