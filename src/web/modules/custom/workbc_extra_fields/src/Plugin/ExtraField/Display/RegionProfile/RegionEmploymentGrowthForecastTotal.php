<?php

namespace Drupal\workbc_extra_fields\Plugin\ExtraField\Display\RegionProfile;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\extra_field\Plugin\ExtraFieldDisplayFormattedBase;

/**
 * Example Extra field with formatted output.
 *
 * @ExtraFieldDisplay(
 *   id = "region_employment_growth_forecast_total",
 *   label = @Translation("Employment Growth Forecast Total"),
 *   description = @Translation("An extra field to display employment growth forecast total."),
 *   bundles = {
 *     "node.region_profile",
 *   }
 * )
 */
class RegionEmploymentGrowthForecastTotal extends ExtraFieldDisplayFormattedBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function getLabel() {

    return $this->t('Forecasted 10-Year Total Employment Growth');
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

    if (!empty($entity->ssot_data) && isset($entity->ssot_data['regional_labour_market_outlook']['forecasted_total_employment_growth_10y'])) {
      $output = ssotFormatNumber($entity->ssot_data['regional_labour_market_outlook']['forecasted_total_employment_growth_10y'],0);
    }
    else {
      $output = WORKBC_EXTRA_FIELDS_NOT_AVAILABLE;
    }
    return [
      ['#markup' => $output],
    ];
  }

}
