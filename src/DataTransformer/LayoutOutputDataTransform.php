<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\LayoutOutput;
use App\Entity\Layout;

final class LayoutOutputDataTransform implements DataTransformerInterface {
  /**
   * {@inheritDoc}
   */
  public function transform($data, string $to, array $context = [])
  {
    $layout_output         = new LayoutOutput();
    $layout_output->id     = $data->getId();
    $layout_output->data   = $data->getData();
    $layout_output->spiral = $data->getSpiralString();
    $layout_output->x      = $data->getX();
    $layout_output->y      = $data->getY();

    return $layout_output;
  }

  /**
   * @{inheritDoc}
   */
  public function supportsTransformation($data, string $to, array $context = []): bool
  {
    return LayoutOutput::class === $to && $data instanceof Layout;
  }
}