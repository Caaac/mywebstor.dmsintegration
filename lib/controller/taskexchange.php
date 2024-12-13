<?

namespace Mywebstor\DmsIntegration\Controller;

use Bitrix\Tasks\TaskTable;
use Bitrix\Rest\RestException;
use Bitrix\Main\SystemException;
use Bitrix\Main\Type\DateTime;

class TaskExchange extends \IRestService
{
  const NAMESPACE = 'dmsintegration';

  public static $methods = array(
    self::NAMESPACE . '.task.add' => array(__CLASS__, 'add'),
    self::NAMESPACE . '.task.update' => array(__CLASS__, 'update'),
  );

  /**
   * Fields required for task creation:
   * - TITLE
   * - DESCRIPTION
   * - RESPONSIBLE_ID
   * - CREATED_BY
   * and so on
   */
  public static function add($query)
  {
    $query['SITE_ID'] = 's1';
    $query['DEADLINE_COUNTED'] = 0;
    $query['CREATED_DATE'] = new DateTime();

    $result = TaskTable::add($query);

    if (!$result->isSuccess()) {
      return $result->getErrorMessages();
      throw new RestException($result->getErrorMessages());
      return false;
    }

    return $result->getId();
  }

  /**
   * Fields required for task update:
   * - id: integer
   * - data: array
   */
  public static function update($query)
  {
    if (!isset($query['id']) || !isset($query['data'])) {
      throw new RestException('Fields "id" and "data" are required');
      return false;
    }

    $result = TaskTable::update($query['id'], $query['data']);

    if (!$result->isSuccess()) {
      throw new SystemException($result->getErrorMessages());
      return false;
    }

    return true;
  }
}
