<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Entity\Layout;

final class LayoutInputDataTransform implements DataTransformerInterface
{
  /**
   * {@inheritDoc}
   */
  public function transform($data, string $to, array $context = [])
  {
    $layout = new Layout();
    $layout = $layout
      ->setX($data->x)
      ->setY($data->y)
      ->setData();

    return $layout;
  }

  /**
   * @{inheritDoc}
   */
  public function supportsTransformation($data, string $to, array $context = []): bool
  {
    if ($data instanceof Layout) {
      return false;
    }
    return Layout::class === $to && null !== ($context['input']['class'] ?? NULL);
  }
}
