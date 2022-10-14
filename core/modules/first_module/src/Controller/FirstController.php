<?php
namespace Drupal\first_module\Controller;

use Drupal\Core\Controller\ControllerBase;

class FirstController extends ControllerBase {
  public function firstMethod() {
    return array (
      '#markup' => 'Welcome to our First Drupal 8 custom Module.'
    );
  }
}
