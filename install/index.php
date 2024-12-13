<?

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Loader;

Loader::includeModule("crm");
Loc::loadMessages(__FILE__);
IncludeModuleLangFile(__FILE__);

class mywebstor_dmsintegration extends CModule
{
    public $MODULE_ID = "mywebstor.dmsintegration";
    public $errors = '';
    static $events = array(
        array(
            "FROM_MODULE" => "rest",
            "FROM_EVENT" => "onRestServiceBuildDescription",
            "TO_CLASS" => "CDmsIntegrationRestService",
            "TO_FUNCTION" => "onRestServiceBuildDescription",
            "VERSION" => "1"
        ),
    );

    public function __construct()
    {
        if (file_exists(__DIR__ . "/version.php")) {

            $arModuleVersion = array();

            include_once(__DIR__ . "/version.php");
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
            $this->MODULE_NAME = Loc::getMessage("MYWEBSTOR_MODULE_1C_NAME");
            $this->MODULE_DESCRIPTION = Loc::getMessage("MYWEBSTOR_MODULE_DESCRIPTION");
            $this->PARTNER_NAME = Loc::getMessage("MYWEBSTOR_MODULE_PARTNER_NAME");
            $this->PARTNER_URI = Loc::getMessage("MYWEBSTOR_MODULE_PARTNER_URI");
        }
        return true;
    }

    public function DoInstall()
    {
        if (!check_bitrix_sessid())
            return false;

        ModuleManager::registerModule($this->MODULE_ID);
        $this->InstallEvents();

        return true;
    }

    public function DoUninstall()
    {
        $this->UnInstallEvents();
        ModuleManager::unRegisterModule($this->MODULE_ID);
        return true;
    }

    public function InstallEvents()
    {
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        foreach (static::$events as $event) 
            $eventManager->registerEventHandlerCompatible($event["FROM_MODULE"], $event["FROM_EVENT"], $this->MODULE_ID, $event["TO_CLASS"], $event["TO_FUNCTION"]);
        return true;
    }

    public function UnInstallEvents()
    {
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        foreach (static::$events as $event)
            $eventManager->unRegisterEventHandler($event["FROM_MODULE"], $event["FROM_EVENT"], $this->MODULE_ID, $event["TO_CLASS"], $event["TO_FUNCTION"]);
        return true;
    }
}
