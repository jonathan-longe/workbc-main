<?php

namespace Drupal\workbc_extra_fields\Plugin\ExtraField\Display\IndustryProfile;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\extra_field\Plugin\ExtraFieldDisplayFormattedBase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Example Extra field with formatted output.
 *
 * @ExtraFieldDisplay(
 *   id = "industry_employment",
 *   label = @Translation("Employment"),
 *   description = @Translation("An extra field to display labour market employment."),
 *   bundles = {
 *     "node.industry_profile",
 *   }
 * )
 */
class IndustryEmployment extends ExtraFieldDisplayFormattedBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function getLabel() {

    return $this->t('Employment');
  }

  /**
   * {@inheritdoc}
   */
  public function getLabelDisplay() {

    return 'above';
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(ContentEntityInterface $entity) {

    $output = "[not-yet-available]";

    return [
      ['#markup' => $output],
    ];
  }

}
