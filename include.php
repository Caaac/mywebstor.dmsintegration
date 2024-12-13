<?
/**
 * Classes loader
 */

use Bitrix\Main\Loader;

Loader::registerAutoLoadClasses(
  'mywebstor.dmsintegration',
  array(
    'CDmsIntegrationRestService' => 'classes/general/restservice.php',
  )
);

$modules = array(
  'crm',
  'tasks'
);

foreach ($modules as $module) {
  if (!Loader::includeModule($module)) {
    ShowError("Module \"{$module}\" not found.");
    return false;
  }
}
