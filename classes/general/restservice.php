<?

use Mywebstor\DmsIntegration\Controller\TaskExchange;

class CDmsIntegrationRestService extends \IRestService
{
  public static function onRestServiceBuildDescription()
  {
    return array(
      "dms_integration" => array_merge(
        TaskExchange::$methods, 
      ),
    );
  }
}
