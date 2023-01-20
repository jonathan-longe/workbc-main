<?php

namespace Drupal\workbc_extra_fields\Plugin\ExtraField\Display\CareerProfile;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\extra_field\Plugin\ExtraFieldDisplayFormattedBase;

/**
 * Example Extra field with formatted output.
 *
 * @ExtraFieldDisplay(
 *   id = "salary_info_hourly_rate",
 *   label = @Translation("Salary Info - Hourly Rate"),
 *   description = @Translation("An extra field to display job opening forecast chart."),
 *   bundles = {
 *     "node.career_profile",
 *   }
 * )
 */
class CareerProfileSalaryInfoHourly extends ExtraFieldDisplayFormattedBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function getLabel() {

    return $this->t('Provincial Hourly Rate');
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

    if (!empty($entity->ssot_data) && abs($entity->ssot_data['wages']['esdc_wage_rate_median'] - $entity->ssot_data['wages']['calculated_median_annual_salary']) > PHP_FLOAT_EPSILON) {
      $hourly1 = empty($entity->ssot_data['wages']['esdc_wage_rate_high']) ? WORKBC_EXTRA_FIELDS_NOT_AVAILABLE : '$' . ssotFormatNumber($entity->ssot_data['wages']['esdc_wage_rate_high'],2) . '/hr';
      $hourly2 = empty($entity->ssot_data['wages']['esdc_wage_rate_median']) ? WORKBC_EXTRA_FIELDS_NOT_AVAILABLE : '$' . ssotFormatNumber($entity->ssot_data['wages']['esdc_wage_rate_median'],2) . '/hr';
      $hourly3 = empty($entity->ssot_data['wages']['esdc_wage_rate_low']) ? WORKBC_EXTRA_FIELDS_NOT_AVAILABLE : '$' . ssotFormatNumber($entity->ssot_data['wages']['esdc_wage_rate_low'],2) . '/hr';
    }
    else {
      $hourly1 = WORKBC_EXTRA_FIELDS_NOT_AVAILABLE;
      $hourly2 = WORKBC_EXTRA_FIELDS_NOT_AVAILABLE;
      $hourly3 = WORKBC_EXTRA_FIELDS_NOT_AVAILABLE;
    }

    $content = '<table>';
    $content .= '<tr><td>High</td><td>' . $hourly1 . '</td></tr>';
    $content .= '<tr><td>Median</td><td>' . $hourly2 . '</td></tr>';
    $content .= '<tr><td>Low</td><td>' . $hourly3 . '</td></tr>';
    $content .= '</table>';

    $output = $content;

    return [
      ['#markup' => $output],
    ];
  }

}
